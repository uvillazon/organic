<?php
class print_socio
{

function Display(){
        
		$fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		$query = new query;
       // $resultsocio= $query->getRows("*","pertenece p","order by p.id_movil");
		 $resultmovil1 = $query->getRows("*","movil m ","where id_linea= '1'");
               $hoy = date("Y-m-d");
			   $fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        
        
        /*$resultmovil1 = $query->getRows("*","socio m,pertenece p, hoja_control h","where m.id_socio=h.id_socio and p.id_socio=h.id_socio and h.fecha_a_usar >= '".$fechaInicio."' and h.fecha_a_usar <= '".$fechaFin."'");
        */
        $hoy = date("Y-m-d");
        //$numsocio = count($resultsocio);
        $numsocio = count($resultmovil1);
        
		//$list = '<div>N° Dias Hábiles de Trabajo: </div><br />';
		$list = '<form name="formPermiso" method="POST" action="reporte_socio.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			  <tr>Reporte de Ahorros Socios</tr></br>
			  <tr>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
			  <tr>
                <th>Num movil</th>
                <th>Linea</th>
				
				<th>Nombre Socio</th>
				<th>Num Hojas</th>
                <th>Dias trabajados socio</th>
			    <th>Ahorro Socio [Bs.]</th>
                <th>Ahorro Movil [Bs.]</th>
				<th>Total Ahorro</th>
      <th>Pagado</th>
      			<th>Ahorro Disponible</th>
      
       
	          </tr></thead>';
            $x = 0;
            //foreach ($resultsocio as $key=>$value) {
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				  $pertenece = $query->getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
                //$socio = $query->getRow("*","socio","where id_socio = 1");
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $linea = $query -> getRow("linea","linea","where id_linea = ".$value['id_linea']);
				$hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and alquiler='0' and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
               $numHojas = count($hojas);
               // $hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and alquiler='0' and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
               //$numHojas = count($hojas);
				$soloNum = split("_",$value['num_movil']);
              $tener = $query -> getRow("estado","tener","where id_linea = ".$value['id_linea']);
				
			   
                $ahorros = $query->getRows("*","hoja_control h,movil m","where h.id_movil=m.id_movil and alquiler='0'  and m.id_linea='1' and h.id_movil = ".$value['id_movil']." and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
				$numahorro = count($ahorros);
                
				
				$hojaschofer = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and id_chofer !='0' and alquiler='0'  and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
				$diaschofer = count($hojaschofer);
				$dias_sinchofer=$numHojas - $diaschofer;
				$transaccion2 = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '3'");
				$transaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '2'");
			
				$ahorroSocio = $transaccion['monto_transaccion']*$numahorro;
             
				$ahorrocomochofer=$transaccion2['monto_transaccion']*$dias_sinchofer;
				$totalahorro=$ahorrocomochofer + $ahorroSocio;
			
			$ahorroSocio = $query->getRow("SUM(h.achofer) as total","hoja_control h, movil m, linea l","where h.id_movil = m.id_movil and m.id_linea = l.id_linea and h.id_movil = ".$value['id_movil']." and h.alquiler='0' and h.fecha_falta >= '".$fechaInicio."' and h.fecha_falta <= '".$fechaFin."'");
              $ahorroSocio= $ahorroSocio['total'];
              $ahorroChofer = $query->getRow("SUM(h.asocio) as total","hoja_control h, movil m, linea l","where h.id_movil = m.id_movil and m.id_linea = l.id_linea and h.id_movil = ".$value['id_movil']." and h.alquiler='0' and h.fecha_falta >= '".$fechaInicio."' and h.fecha_falta <= '".$fechaFin."'");
            
			  $ahorrocomochofer= $ahorroChofer['total'];
			    $totalahorro=$ahorrocomochofer + $ahorroSocio;
			   
				
				
				  //de los pagos de ahorros
	   $ahorropagado = $query->getRow("SUM(a.monto_pago_ahorro) as total","pago_ahorro a, movil m","where  a.id_movil=m.id_movil and a.id_movil = ".$value['id_movil']." and a.id_chofer='0' and a.id_alquiler='0' and a.fecha_ahorro_dia >= '".$fechaInicio."' and a.fecha_ahorro_dia <= '".$fechaFin."'");
              $ahorrocancelado= $ahorropagado['total'];
			  
			$saldoahorro = ($totalahorro - $ahorrocancelado);  
      
	  $list .= '<tbody><tr '.$par.'>
                  <td>'.$soloNum[1].'</td>
                  <td>'.$soloNum[0].'</td>
				 
				  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                  <td>'.$numHojas.'</td>
				  
				  <td>'.$dias_sinchofer.'</td>
				  <td>'.$ahorrocomochofer.'</td>
                  <td>'.$ahorroSocio.'</td>
                  <td>'.$totalahorro.'</td>
				 <td>'.$ahorrocancelado.'</td>
				  <td>'.$saldoahorro.'</td>

				  
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen datos registrados</div>';
		return $list;
		return $template->Display();
	}
}
?>