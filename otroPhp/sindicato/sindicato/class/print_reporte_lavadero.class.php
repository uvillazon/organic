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
	  $resultmovil1 = $query->getRows("*","egreso_lubricante","WHERE fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."' AND tipo='1' ORDER BY fecha DESC");
		        $hoy = date("Y-m-d");
        $numsocio = count($resultmovil1);
         $totalDiaBs = $query->getRow("SUM(montoingreso) as totalDiabs","ingresolubricante i, control_lubricante c","where i.id_control_lubricante=c.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."'");
		 $recaudado = $totalDiaBs['totalDiabs'];
		  $totalD = $query->getRow("SUM(monto_egreso) as totalDiabs","egreso_lubricante","where  tipo='1' AND fecha >= '".$fechaInicio."' and fecha <= '".$fechaFin."'");
		 $totalventas = $totalD['totalDiabs'];
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
	     
	 //ojo lavado
$resultlavado = $query->getRow("SUM(montoingreso)as totallavado","ingresolubricante i, control_lubricante c","where c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.id_control_lubricante='6' ");
		 	  $ingresolav = $resultlavado['totallavado'];   
		$resultlavado1 = $query->getRow("COUNT(i.id_control_lubricante)as totallav","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.id_control_lubricante='6' ");
		 	  $cantidadlav = $resultlavado1['totallav'];  
	
	
			  
 //fumi
 $resultfumi = $query->getRow("SUM(montoingreso)as totalfumi","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND i.id_control_lubricante='7' ");
		 	  $ingresofumi = $resultfumi['totalfumi'];   
		$resultfumig = $query->getRow("COUNT(i.id_control_lubricante)as totalfumig","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND c.id_control_lubricante='7' ");
		 	  $cantidadfumi = $resultfumig['totalfumig'];   
 //fumi y lav
 $resultlavf= $query->getRow("SUM(montoingreso)as totallavf","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND i.id_control_lubricante='5' ");
		 	  $ingresofumil = $resultlavf['totallavf'];   
		$resultlavfl = $query->getRow("COUNT(i.id_control_lubricante)as totalavf","ingresolubricante i, control_lubricante c","WHERE c.id_control_lubricante=i.id_control_lubricante AND i.fecha >= '".$fechaInicio."' and i.fecha <= '".$fechaFin."' AND i.tipo='1' AND c.id_control_lubricante='5' ");
		 	  $cantidadfumil = $resultlavfl['totalavf'];   
 //fin
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			   <tr>Estado de Resultados Lavadero:</tr></br>
			  <tr><b>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
			 
			      <tr>Totales</tr>					  
			 <tr>
                
				</tr>
				  
				  
				  <tr><td><b>CONCEPTO<b></td><td><b>INGRESOS<b></td><td><b>EGRESOS<b></td><td><b>SALDO<b></td></tr>
				  
				  <tr><td><b>LAVADERO<b></td><td>'.$ingresola.'</td><td>'.$egresola.'</td><td><b>'.$saldola.'</td></tr>
				 	<tr>Detalle Ingresos</tr><tr></tr><tr></tr><tr></tr>					  
			 <tr>
         <th>Tipo ingreso</th>
		<th></th>
		<th>Cantidad</th>
        <th>Total Ingresos</th>
                
		
				</tr>
				
                  
                  <tr><td><b>LAVADO<b></td><td></td><td>'.$cantidadlav.'</td><td><b>'.$ingresolav.'</td></tr>
				  <tr><td><b>ASPIRADO<b></td><td></td><td>'.$cantidadfumi.'</td><td><b><b>'.$ingresofumi.'</td></tr>
				 <tr><td><b>LAVADO Y ASPIRADO<b></td><td></td><td>'.$cantidadfumil.'</td><td><b><b>'.$ingresofumil.'</td></tr>
				  <tr><td><b>TOTAL<b></td><td></td><td></td><td><b><b>'.$ingresola.'</td></tr>
				<tr>Detalle Egresos</tr>			
			 <tr>
         <th>Egreso</th>
		<th>Concepto</th>
		
		<th>Recibo</th>
        <th>Total Egresos</th>
                
		
				</tr>
				</thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        	//$ingreso= $query->getRow("SUM(monto_egreso)as total","egreso_lubricante","where id_ = ".$value['id_control_lubricante']);	 
               
				//$registro = $ingreso["total"];
                
				
                $list .= '<tbody>
							<tr '.$par.'>
                  <td>'.$value["fecha"].'</td>
		          <td>'.$value["concepto"].'</td>
                  <td>'.$value["numero"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				  
                                  </tr></tbody>';
            }
             $list.='<th>Totales
			   <th></th>
			   <th></th>
			 
			   <th><b>Total:<b>'.$totalventas.'</th>
			  
			   </th></table>';
			   //lista adicional

			   //fin lista
			
        } else $list = '<div>No existe ningun egreso registrado/Debe registrar por lo menos un egreso para el lavadero/ De no existir ninguno introdusca uno con la denominacion ninguno y un monto "00.00" Gracias por su comprension</div>';
		
		return $list;
	  return $template->Display();
	}
}
?>