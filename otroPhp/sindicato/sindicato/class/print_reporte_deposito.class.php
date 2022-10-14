<?php
class print_prestamo
{

function Display(){
        
		$fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		$query = new query;
      
       	$resultmovil1 = $query->getRows("*","deposito","WHERE fecha_deposito >= '".$fechaInicio."' and fecha_deposito <= '".$fechaFin."'");
		        $hoy = date("Y-m-d");
				$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        $numsocio = count($resultmovil1);
	$resultmovil1 = $query->getRows("*","deposito","WHERE fecha_deposito >= '".$fechaInicio."' and fecha_deposito <= '".$fechaFin."'");
		       
	   $totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito","where fecha_deposito >= '".$fechaInicio."' and fecha_deposito <= '".$fechaFin."'");
		 $recaudado = $totalDiaBs['totalDiabs'];
         $totalDiaDinero = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito d, prestamo_socio a, tipo_prestamo b","where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito >= '".$fechaInicio."' and d.fecha_deposito <= '".$fechaFin."'");
      $dinero = $totalDiaDinero['totalDiabs'];
        $totalDiainteres = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito d, prestamo_socio a, tipo_prestamo b","where b.interes='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito >= '".$fechaInicio."' and d.fecha_deposito <= '".$fechaFin."'");
      $sinint = $totalDiainteres['totalDiabs'];
    
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			  <tr>Reporte de Depositos realizados entre las fechas:</tr></br>
			  <tr><b>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
			   <tr><b>Recaudado:<b>'.$recaudado.'<tr>- Prestamos '.$dinero.'</tr><tr>- Ventas '.$sinint.'</tr>
			  	  
			  <tr>
                <th>Nro Prestamo</th>
		<th>Nombre Socio</th>
		<th>Nombre Chofer</th>
               <th>Monto Deposito</th>
                <th>Monto Adeudado</th>
				</tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        	$prestamo= $query->getRow("*","prestamo_socio","where id_prestamo = ".$value['id_prestamo']);	 
                $socio = $query->getRow("*","socio","where id_socio = ".$prestamo['socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $chofer = $query -> getRow("nombre_chofer","chofer","where id_chofer = ".$prestamo['chofer']);
			    
				$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$prestamo['id_tipo_prestamo']);
        		$totalPago = $prestamo['monto_prestamo'] + ($prestamo['monto_prestamo']*$interes['interes']/100);
			
				$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$prestamo['id_prestamo']);
				$falta = $totalPago - $total["total"];
                $capitalrecaudado =($total['total']-$interes['interes']);
		           
				$interesprestamo =($prestamo['monto_prestamo']*$interes['interes']/100);
		
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$prestamo["id_prestamo"].'</td>
		          <td>'.$nombreCompleto.'</td>
                  <td>'.$chofer["nombre_chofer"].'</td>
                   <td>'.$value["monto_deposito"].'</td>
                  <td>'.$falta.'</td>
                  
				  
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
		return $template->Display();
	}
}
?>