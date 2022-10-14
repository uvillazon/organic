<?php
class imprimirRecibo
{
	function Display(){
	  //  $numero = $_GET[numHoja];
		//$pago = $_GET[pago];
        $query = new query;
		$template=new template;
		
		$template->SetTemplate('html/imprimirRecibo2.html');
        $hoja = $query -> getRow("*","deposito","where id_deposito = ".$_GET['numHoja']);
		
		$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo = ".$hoja['id_prestamo']);
        
		$socio = $query -> getRow("*","socio","where id_socio = ".$resultprestamo['socio']);
		$chofer = $query ->getRow("*","chofer","where id_chofer = ".$resultprestamo['chofer']);
		//$pago = $query ->getRow("monto_deposito","deposito","where id_deposito = ".$resultprestamo['id_deposito']);
        	
		$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
        		$totalPago = $resultprestamo['monto_prestamo'] + ($resultprestamo['monto_prestamo']*$interes['interes']/100);
			
				$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$resultprestamo['id_prestamo']);
				$falta = $totalPago - $total["total"];
      	
		//$linea = $query->getRow("linea","linea","where id_linea = ".$movilSocio['id_linea']);
        
		$nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
        $nombreConductor = "";
        $licenciaConductor = "";
             $monto = '';
			 $hoy = date('Y-m-d');
      // $resultdeposito = $query->getRows("monto_deposito","deposito","where id_prestamo = ".$hoja['id_prestamo']." and monto_deposito = '".$pago."'");
		
	//	     $monto = $resultdeposito["monto_deposito"];
			   
        $template->SetParameter("numHoja",$hoja['id_deposito']);
        $template->SetParameter("nombreSocio",$nombreSocio);
     $template->SetParameter("nombreChofer",$chofer['nombre_chofer']);
     
		$fecha=$hoja['fecha_deposito']; // El formato que te entrega MySQL es Y-m-d 
             $fecha=date("d-m-Y",strtotime($fecha)); 
        $template->SetParameter("fechaCompra",$fecha);
		// $template->SetParameter("montoPago",$monto);
		  $template->SetParameter("montoPago",$hoja['monto_deposito']);
        $template->SetParameter("conceptodesc",$resultprestamo['descripcion_prestamo']);
        
		$template->SetParameter("totalpago",$totalPago);
        $template->SetParameter("descripcion",$total);
        $template->SetParameter("concepto",$falta);
        
		return $template->Display();
	}
}
?>