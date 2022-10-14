<?php
class print_morosos
{

function Display()

{
      
		$query = new query;
        $hoy = date("Y-m-d");
		$fecha=date("d-m-Y",strtotime($hoy)); 
		$str = "-8 week";
		$fecha_anterior = date('Y-m-d', strtotime($str));
		
		$fecha_actual = date('Y-m-d', strtotime("now"));
        //$resultprestamo = $query->getRows("DISTINCT p.id_prestamo","prestamo_socio p, plan_de_pagos pp","WHERE p.id_prestamo = pp.id_prestamo AND fecha_pago>='".$fecha_anterior."' and fecha_pago<'".$fecha_actual."' ORDER by p.id_prestamo");
        $resultprestamo = $query->getRows("DISTINCT p.id_prestamo","prestamo_socio p, plan_de_pagos pp","WHERE p.id_prestamo = pp.id_prestamo AND fecha_pago<'".$fecha_actual."'ORDER by p.id_prestamo  ");
        
	$numprestamo = count($resultprestamo);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead>
			   <tr>Lista de Morosos </tr></br>
			  <tr>A la Fecha :<tr>'.$fecha.'</tr> 
			 
			  <tr>
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
				<tr><b>Se recuerda a los socios y/o choferes pasar a cancelar sus deudas pendientes<b></tr>
              
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

$result1 = $query->getRow("count(d.fecha_deposito) as total1","deposito d","WHERE d.fecha_deposito<'".$fecha_actual."' AND d.id_prestamo=".$id_prestamo);
			
				$cuota1 = $result1["total1"];
				$cuota =($cuotad-$cuota1);				
				
	//if(($falta > '0') AND($cuota != '0') )
    if(($falta > '0') AND($cuota >= '1') )    		
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
        $resultdepositot = $query->getRow("*","deposito","WHERE fecha_deposito <'".$fecha_actual1."' AND id_prestamo = '".$value['id_prestamo']."' ORDER BY fecha_deposito DESC ");
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
					  
			          </tr></tbody>';
					
	            }
			}
            $list.='</table>';
  } else $list = '<div>No existen morosos </div>';
		return $list;
		
		
		return $template->Display();
	}
}
?>