<?php
class moroso2
{
	var $parameter=array();
	function SetParameter($name,$value)
	{
		$this->parameter[$name]=$value;
	}
	function mostrarregistro(){
		$template=new template;
		$template->SetTemplate('html/registro.html');
		if($_GET['error']){
			$template->SetParameter('error',"DATOS MALOS INGRESADOS");
		}
		else{
			$template->SetParameter('error',"");
		}
		return $template->Display();
	}
	function mostrarregistro1(){
		$template=new template;
		$template->SetTemplate('html/logen.html');
		$query=new query;
		$id=$_SESSION['id'];
		$row=$query->getRow("*","usuario","where id_usuario=$id");
		$nombre=" ".$row['nombre_usuario']." ".$row['apellido1_usuario'];
		$template->SetParameter('name',$nombre);
		
		return $template->Display();
	}
    
    function buscarSocio(){
        $query = new query;
        $nombreSocio = $query->getRow("*","socio","where num_licencia = ".$_GET['licencia']);
        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$nombreSocio['id_socio']."\">";
	}
    
	function buscarChofer(){
        $query = new query;
        $nombreChofer = $query->getRow("*","chofer","where num_chofer = ".$_GET['licencia']);
        $nombreCompleto = $nombreChofer['nombre_chofer'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idChofer\" value=\"".$nombreChofer['id_chofer']."\">";
	}
	
    function listarMorosos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_moroso132.html'); //sets the template for this function
		$template->SetParameter('hoy',date('d-M-Y'));
                
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar esta morosidad?');";
		$str = "-8 week";
		$fecha_anterior = date('Y-m-d', strtotime($str));
		
		$fecha_actual = date('Y-m-d', strtotime("now"));
        //$resultprestamo = $query->getRows("DISTINCT p.id_prestamo","prestamo_socio p, plan_de_pagos pp","WHERE p.id_prestamo = pp.id_prestamo AND fecha_pago>='".$fecha_anterior."' and fecha_pago<'".$fecha_actual."' ORDER by p.id_prestamo");
     // $resultprestamo = $query->getRows("*","plan_de_pagos pp,prestamo_socio a,pertenece p,movil m ","WHERE pp.id_prestamo=a.id_prestamo and p.id_socio=a.socio and p.id_movil=m.id_movil and m.id_linea='2' and pp.fecha_pago>='".$fecha_anterior."' and pp.fecha_pago<'".$fecha_actual."'ORDER by pp.id_prestamo");
        
	   $resultprestamo = $query->getRows("DISTINCT p.id_prestamo","prestamo_socio p, plan_de_pagos pp,pertenece pe,movil m","WHERE p.id_prestamo = pp.id_prestamo and pe.id_socio=p.socio and pe.id_movil=m.id_movil and m.id_linea='2' AND fecha_pago<'".$fecha_actual."'ORDER by p.id_prestamo ");
        
	$numprestamo = count($resultprestamo);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Num Prestamo</th>
                
		<th>Socio</th>
                <th>Chofer</th>
                <th>Cuotas</th>
		<th>Monto Cuota</th>
		
		<th>Monto esperado</th>
<th>Deuda Total</th>
                		
		<th>Monto pagado</th>
                <th> Ultimo pagado</th>
				<th> fecha cuota</th>
				
				<th>Pagar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultprestamo as $key=>$value) {
				$id_prestamo = $value['id_prestamo'];
				$resultdeposito = $query->getRow("sum(monto_deposito) as totaldeposito","deposito","WHERE id_prestamo=".$id_prestamo);
				$resultprestamo = $query -> getRow("*","prestamo_socio","where id_prestamo=".$id_prestamo);
        $interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$resultprestamo['id_tipo_prestamo']);
	$plan = $query -> getRow("*","plan_de_pagos","where id_prestamo=".$id_prestamo);
        /*      
	$deudaalafecha = $plan['monto_pago'] * $plan['semana'];
	
	if ($deudaalafecha > $resultdeposito['totaldeposito'])
				{
		
	                $x++;*/
	$totalPago = $resultprestamo['monto_prestamo'] + ($resultprestamo['monto_prestamo']*$interes['interes']/100);
			$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo=".$id_prestamo);
			$falta = $totalPago - $total["total"];
			//$deudaalafecha = $resultpago1['monto_pago'] * $resultpago1['semana'];
				//			if ($deudaalafecha > $total['total'])

$result = $query->getRow("count(p.fecha_pago) as total","plan_de_pagos p","WHERE p.fecha_pago<'".$fecha_actual."' AND p.id_prestamo=".$id_prestamo);
			
				$cuotad = $result["total"];
$montominimopagar = $query->getRow("sum(p.monto_pago) as total","plan_de_pagos p","WHERE p.fecha_pago<'".$fecha_actual."' AND p.id_prestamo=".$id_prestamo);
				$montominimo = $montominimopagar["total"];
$montopagadod = $query->getRow("sum(d.monto_deposito) as total1","deposito d","WHERE d.fecha_deposito<='".$fecha_actual."' AND d.id_prestamo=".$id_prestamo);
			
				$montopagado = $montopagadod["total1"];

$result1 = $query->getRow("count(d.fecha_deposito) as total1","deposito d","WHERE d.fecha_deposito<'".$fecha_actual."' AND d.id_prestamo=".$id_prestamo);
			
				$cuota1 = $result1["total1"];
				$cuota =($cuotad-$cuota1);				
				
	//if(($falta > '0') AND($cuota != '0') )
    if(($falta > '0') AND($cuota >= '1')AND($montopagado<$montominimo) )
   // if(($falta > '0') AND($cuota >= '1')AND($montopagado<$montominimo) )
        		
	//if($id_prestamo != NULL)
          {	
	          $x++;
	                if(($x%2)==0)
	                    $par = "class='TdAlt'";
	                else $par = "";
					$prestamo = $query->getRow("*","prestamo_socio","WHERE id_prestamo=".$id_prestamo);
	                $socio = $query->getRow("*","socio","where id_socio = ".$prestamo['socio']);
	                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
	                $chofer = $query -> getRow("nombre_chofer","chofer","where id_chofer = ".$prestamo['chofer']);
					$deuda = $deudaalafecha - $resultdeposito['totaldeposito'];
$result = $query->getRow("count(p.fecha_pago) as total","plan_de_pagos p","WHERE p.fecha_pago<'".$fecha_actual."' AND p.id_prestamo=".$id_prestamo);
			
				$cuotad = $result["total"];

$result1 = $query->getRow("count(d.fecha_deposito) as total1","deposito d","WHERE d.fecha_deposito<'".$fecha_actual."' AND d.id_prestamo=".$id_prestamo);
			
				$cuota1 = $result1["total1"];
				$cuota =($cuotad-$cuota1);

				$resultpres = $query -> getRows("*","plan_de_pagos","where id_prestamo=".$id_prestamo);
			$str1 = "-1 week";
		$fecha_anterior1 = date('Y-m-d', strtotime($str1));
		$fecha_actual1 = date('Y-m-d', strtotime("now"));
			$resultpago = $query->getRow("*","plan_de_pagos","WHERE fecha_pago <'".$fecha_actual1."' AND id_prestamo = ".$value['id_prestamo']);
       	 $resultpago1 = $query->getRow("*","plan_de_pagos","WHERE fecha_pago>='".$fecha_anterior1."' and fecha_pago<'".$fecha_actual1."'AND id_prestamo = '".$value['id_prestamo']."'");
       	
			//ORDER BY `deposito`.`fecha_deposito` DESC
        $resultdepositot = $query->getRow("*","deposito","WHERE fecha_deposito <='".$fecha_actual1."' AND id_prestamo = '".$value['id_prestamo']."' ORDER BY fecha_deposito DESC ");
        $total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$value['id_prestamo']);
				
			//$deudaalafecha = $resultpago1['monto_pago'] * $resultpago1['semana'];
				//			if ($deudaalafecha > $total['total'])
				   
				
			
			
				$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$value['id_prestamo']);
				$falta = $totalPago - $total["total"];
			$deuda = $falta + $resultdeposito["totaldeposito"];
					 $list .= '<tbody><tr '.$par.'>
                    <td>'.$resultprestamo['id_prestamo'].'</td>		 		                 
			 <td>'.$nombreCompleto.'</td>
					  <td>'.$chofer["nombre_chofer"].'</td>
                        <td>'.$cuota.'</td>
	                <td>'.$resultpago["monto_pago"].'</td>
			 			
			  <td>'.$falta.'</td>
			<td>'.$deuda.'</td>
			
			<td>'.$resultdeposito["totaldeposito"].'</td>
	                  <td>'.$resultdepositot["fecha_deposito"].'</td>
					  <td>'.$resultpago1["fecha_pago"].'</td>
					  
					  <td><a href="prestamo132.php?accion=pago&id='.$id_prestamo.'" title="Pagar Prestamo"><img src="images/pago.gif"></a></td>
	                  </tr></tbody>';
					
	            }
			}
            $list.='</table>';
        } else $list = '<div>No existen morosos a la fecha</div>';
        $template->SetParameter('add','<a href="print_morosos2.php" target="_blank" onClick="window.open(this.href, this.target); return false;" title="Lista Morosos">Vista de Impresion</a>
');
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
    
	function Display(){
		$template=new template;
		
		if(!$_SESSION['tipo']){
		
			$template->SetTemplate('html/home12.html');
			$template->SetParameter('registro',$this->mostrarregistro());
		}
		if($_SESSION['tipo']==1){
			$template->SetTemplate('html/home1.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_SESSION['tipo']==2){
			$template->SetTemplate('html/home2.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_SESSION['tipo']==3){
			$template->SetTemplate('html/home.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
        if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarMorosos());
        }
		$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
?>
