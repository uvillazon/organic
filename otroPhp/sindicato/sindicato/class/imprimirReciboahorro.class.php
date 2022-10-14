<?php
class imprimirRecibo
{
	function Display(){
	    $numero = $_GET[numHoja];
		$pago = $_GET[pago];
        $query = new query;
		$template=new template;
		
		$template->SetTemplate('html/imprimirReciboahorro.html');
        $hoja = $query -> getRow("*","pago_ahorro","where id_ahorro = ".$_GET['numHoja']);
	if($hoja["id_movil"]!=0)
		{	
		 $movil = $query -> getRow("*","movil","where id_movil = ".$hoja['id_movil']);
        $pertenece = $query -> getRow("*","pertenece","where id_movil =  ".$hoja['id_movil']);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
	
                //$socio = $query->getRow("*","socio","where id_socio = ".$value['id_socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$hoja['id_movil']." and m.id_linea = l.id_linea");
                $numMovil = split('_',$linea["num_movil"]);
		$linea =$linea["linea"];
                $movil = $numMovil[1];
                $tipo = "-";
                
		}
		else  if($value["id_movil"]==0)
	{
		$chofer = $query -> getRow("*","chofer","where id_chofer = ".$hoja['id_chofer']);
  		$linea ="-";
                $movil = "-";
                $nombreCompleto = $chofer["nombre_chofer"];
		
	 }     
	 $chofer = $query -> getRow("*","chofer","where id_chofer = ".$hoja['id_chofer']);
	  if($chofer["tipo_chofer"]=='Permanente')
	  $tipo = "Chofer";
	  else if ($chofer["tipo_chofer"]=='alquiler')
             $tipo = "Alquiler";
	$fecha=$hoja['fecha_cobro']; // El formato que te entrega MySQL es Y-m-d 
             $fecha=date("d-m-Y",strtotime($fecha)); 
        
	 $monto = '';
        $template->SetParameter("numHoja",$hoja['id_ahorro']);
        $template->SetParameter("nombreSocio",$nombreCompleto);
        $template->SetParameter("movil",$movil);
	$template->SetParameter("linea",$linea);
	 $template->SetParameter("fechaCompra",$fecha);
        $template->SetParameter("tipo",$tipo);
        
	$template->SetParameter("totalPago",$hoja['monto_pago_ahorro']);
        $template->SetParameter("concepto",$hoja['concepto']);
       
		return $template->Display();
	}
}
?>