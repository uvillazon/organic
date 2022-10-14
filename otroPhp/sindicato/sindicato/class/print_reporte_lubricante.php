<?php
class print_prestamo
{

function Display(){
        
		$fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		$query = new query;
      //ejemplo//	 	  <tr>Reporte de Depositos realizados entre las fechas:</tr></br>
		//	  <tr><b>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
		
	  $hoy = date("Y-m-d");
				$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
		
	  //fin ej
	  
$resultmovil1 = $query->getRows("c.id_control_lubricante,i.fecha,c.tipo,c.nombre,c.aporte","control_lubricante c,ingresolubricante i","WHERE c.id_control_lubricante=i.id_control_lubricante and i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' GROUP BY c.id_control_lubricante");
 
//$resultmovil1 = $query->getRows("*","control_lubricante","WHERE fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."' ORDER BY tipo");
		       		        
$hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
         $totalDiaBs = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante i, control_lubricante c","where i.id_control_lubricante=c.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $recaudado = $totalDiaBs['totalDiabs'];
		  $totalD = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante i, control_lubricante c","where  i.tipo='0' AND i.id_control_lubricante=c.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
	//	 $totalventas = $totalD['totalDiabs'];
      $otros = $recaudado - $totalventas;
      $totalDiaDinero = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
      $dinero = $totalDiaDinero['totalDiabs'];
        $saldo = $recaudado - $dinero;
		 //cuidado
		 
	 $totalDiaBsla = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante i","where i.tipo='1' AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $ingresola = $totalDiaBsla['totalDiabs'];
		$totalDiaDinerola = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
      $egresola = $totalDiaDinerola['totalDiabs'];
       $saldola = $ingresola - $egresola;
	   $totalDiaBslu = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante i","where i.tipo='0' AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $ingresolu = $totalDiaBslu['totalDiabs'];
		$totalDiaDinerolu = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where tipo='0' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
      $egresolu = $totalDiaDinerolu['totalDiabs'];
       $saldolu = $ingresolu - $egresolu;
	   
	    $totalaporte = $query->getRow("SUM(montoaporte) as totalDiabs","ingresolubricante i, control_lubricante c","where c.tipo='0' AND i.id_control_lubricante=c.id_control_lubricante  AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $totalAporte = $totalaporte['totalDiabs'];
     $disponiblelu = $saldolu - $totalAporte;
	  $totalaportela = $query->getRow("SUM(montoaporte) as totalDiabs","ingresolubricante i, control_lubricante c","where c.tipo='1' AND i.id_control_lubricante=c.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $totalAportela = $totalaportela['totalDiabs'];
     $disponiblela = $saldola - $totalAportela;
	 
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			      <tr>Totales</tr>					  
			 <tr>
                
				</tr>
				  
				  <tr><b>Del :<tr>'.$fechaInicio.'</tr> <b>Al:<tr>'.$fechaFin.'</tr>
				  <tr><td><b>CONCEPTO<b></td><td><b>INGRESOS<b></td><td><b>EGRESOS<b></td><td><b>SALDO<b></td><td><b>Ganancia<b></td><td><b>Disponible<b></td></tr>
				  
				  <tr><td><b>LAVADERO<b></td><td>'.$ingresola.'</td><td>'.$egresola.'</td><td><b>'.$saldola.'</td><td><b>'.$totalAportela.'</td><td><b>'.$disponiblela.'</td></tr>
				  <tr><td><b>LUBRICANTES<b></td><td>'.$ingresolu.'</td><td>'.$egresolu.'</td><td><b><b>'.$saldolu.'</td><td><b>'.$totalAporte.'</td><td><b>'.$disponiblelu.'</td></tr>
					<tr>Detalle Ingresosfdsfejfgwejg</tr>					  
			 <tr>
         <th>Tipo ingreso</th>
		<th>Concepto</th>
		<th>Cantidad</th>
        <th>Total Ingresos</th>
                
		<th>Aporte Unidad</th>
                <th>Ganancia</th>
				</tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        	$ingreso= $query->getRow("SUM(montoingreso)as total","ingresolubricante","where fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."' and id_control_lubricante = ".$value['id_control_lubricante']);	 
                $cant= $query->getRow("COUNT(id_control_lubricante)AS totalu","ingresolubricante ","where fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'and
id_control_lubricante=".$value['id_control_lubricante']);	 
                $cantidad = $cant["totalu"];
			//	$total = $query -> getRow("COUNT(id_control_lubricante) as total","","where id_prestamo = ".$ingreso['id_']);
				$registro = $ingreso["total"];
                $aporte= $query->getRow("SUM(montoaporte)as totalap","ingresolubricante","where fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."' and id_control_lubricante = ".$value['id_control_lubricante']);	 
                  $aportetotal = $aporte["totalap"];
			//	$interesprestamo =($prestamo['monto_prestamo']*$interes['interes']/100);
		if($value['tipo'] == 0)
				{ $tipoeg="Lubricantes";}
				 else{
				 				  			  
				$tipoeg="Lavadero";}
				
                $list .= '<tbody>
							<tr '.$par.'>
                  <td>'.$tipoeg.'</td>
		          <td>'.$value["nombre"].'</td>
                  <td>'.$cantidad.'</td>
				  <td>'.$registro.'</td>
				  <td>'.$value["aporte"].'</td>
	                    <td>'.$aportetotal.'</td>
                  
				  
                                  </tr></tbody>';
            }
             $list.='<th>Totales
			   <th></th>
			   <th></th>
			 
			   <th><b>Total:<b>'.$totalventas.'</th>
			   <th></th>
			   <th><b>Total:<b>'.$totalAporte.'</th>
			   </th></table>';
			   //lista adicional

			   //fin lista
			
        } else $list = '<div>No existen datos registrados</div>';
		
		return $list;
		return $template->Display();
	}
}
?>