<?php
class print_prestamo
{

function Display(){
        
		$fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		$query = new query;
      
       	 $resultmovil1 = $query->getRows("*","prestamo_socio a, tipo_prestamo b ","WHERE b.interes!='0.00' and a.id_tipo_prestamo=b.id_tipo_prestamo and a.fecha_prestamo >= '".$fechaInicio."' and a.fecha_prestamo <= '".$fechaFin."'");
		      
	  //$resultmovil1 = $query->getRows("*","prestamo_socio a, tipo_prestamo b, deposito d","WHERE b.interes!='0.00' and d.id_prestamo=a.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito >= '".$fechaInicio."' and d.fecha_deposito <= '".$fechaFin."'");
		 		 
		 $hoy = date("Y-m-d");
		 $fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        $numsocio = count($resultmovil1);
          $totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito d, prestamo_socio a, tipo_prestamo b","where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito = '".$hoy."'");
		
		 $recaudado = $totalDiaBs['totalDiabs'];
         $totalde = $query -> getRow("SUM(monto_deposito) as total","deposito d, prestamo_socio p, tipo_prestamo tp","where d.id_prestamo=p.id_prestamo and p.id_tipo_prestamo = tp.id_tipo_prestamo and tp.interes!='0.00' and d.fecha_deposito >= '".$fechaInicio."' and d.fecha_deposito <= '".$fechaFin."'");
         $totaldepositado = $totalde['total'];
		 
		$interes = $query ->getRow("interes","tipo_prestamo","where interes = '7.00'");
        		//$totalPago = $value['monto_prestamo'] + ($value['monto_prestamo']*$interes['interes']/100);
		$totalpres = $query -> getRow("SUM(monto_prestamo) as total","prestamo_socio p, tipo_prestamo tp","where p.id_tipo_prestamo = tp.id_tipo_prestamo and tp.interes!='0.00' and p.fecha_prestamo >= '".$fechaInicio."' and p.fecha_prestamo <= '".$fechaFin."'");
         $totalprestamo = $totalpres['total'];
		 	$prestamostotales = $totalpres['total'] + ($totalpres['total']*$resultmovil1['interes']/100);
			$totalpr = $query -> getRow("SUM(monto_prestamo) as total","prestamo_socio ","where id_tipo_prestamo !='3'");
         $totalpr1 = $totalpr['total'];

		 $totaldeuda = $prestamostotales - $totaldepositado;
		$totalinteres = $totalde['total']*$interes['interes']/100;
		 $totalcapital = $totaldepositado-$totalinteres;
		 $totalDiaBs = $query->getRow("SUM(monto_deposito) as totalDiabs","deposito d, prestamo_socio a, tipo_prestamo b","where b.interes!='0.00' and a.id_prestamo=d.id_prestamo and a.id_tipo_prestamo=b.id_tipo_prestamo and d.fecha_deposito = '".$hoy."'");
		
		 $recaudado = $totalDiaBs['totalDiabs'];
		// $totalinteres = $totalde['total']*7.00/100;
		$list = '<form name="formPermiso" method="POST" action="lista_prestamo.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			   <tr>Reporte de Prestamos</tr></br>
			  <tr>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
			  <tr>Recaudado:</tr><tr>'.$recaudado.'</tr>
			  
			  <tr>
                <th>Nro Prestamo</th>
		        <th>Nombre Socio</th>
		        <th>Nombre Chofer</th>
                <th>Tipo Prestamo</th>
				<th>Monto Prestamo</th>
                <th>Capital + Interes a cobrar</th>
                <th>Capital Recaudado</th>
                <th>Interes Recaudado</th>
                <th>Monto Total</th>
                <th>Monto Adeudado</th>
				</tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
	        				 
                $socio = $query->getRow("*","socio","where id_socio = ".$value['socio']);
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $chofer = $query -> getRow("nombre_chofer","chofer","where id_chofer = ".$value['chofer']);
			    
				$interes = $query ->getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$value['id_tipo_prestamo']);
        		$totalPago = $value['monto_prestamo'] + ($value['monto_prestamo']*$interes['interes']/100);
			
				$total = $query -> getRow("SUM(monto_deposito) as total","deposito","where id_prestamo = ".$value['id_prestamo']);
				$falta = $totalPago - $total["total"];
				if($total['total'] == '0' or $total['total'] == NULL)
				{
                        $capitalrecaudado =0;
                       $interesprestamo=0; 						
				}
				else
					if($total['total'] != '0')
					{
                //$capitalrecaudado =($total['total']-$interes['interes']);
				$interesprestamo =($value['monto_prestamo']*$interes['interes']/100);
                
				$capitalrecaudado =($total['total']-$interesprestamo);
				
		         //$sum=SUM($total["total"]);  
				     }		
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["id_prestamo"].'</td>
		          <td>'.$nombreCompleto.'</td>
                  <td>'.$chofer["nombre_chofer"].'</td>
                  <td>'.$value["tipo_prestamo"].'</td>
				   <td>'.$value["monto_prestamo"].'</td>
                 
                  <td>'.$totalPago.'</td>
                  <td>'.$capitalrecaudado.'</td>
                  <td>'.$interesprestamo.'</td>
		          <td>'.$total["total"].'</td>
                  <td>'.$falta.'</td>
                  
				  
                                  </tr>
								  </tbody>';
								  
            }
			
            $list.='<th>Totales
			   <th></th>
			   <th></th>
			   <th></th>
			    <th><b>Total:<b>'.$totalpr1.'</th>
			   <th></th>
				
			   <th><b>Total:<b>'.$totalcapital.'</th>
				 <th><b>Total:<b>'.$totalinteres.'</th>
				  <th><b>Total:<b>'.$totaldepositado.'</th>
			   <th><b>Total:<b>'.$totaldeuda.'</th>
			  </th></table>';
			
        } else $list = '<div>No existen prestamos registrados</div>';
		
		return $list;
		
		return $template->Display();
	}
}
?>