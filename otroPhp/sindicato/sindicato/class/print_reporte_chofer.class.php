<?php
class print_chofer
{

function Display(){
        
		$fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		$query = new query;
       // $resultsocio= $query->getRows("*","pertenece p","order by p.id_movil");
		//$resultmovil1 = $query->getRows("*","chofer","order by id_chofer ");
$resultmovil1 = $query->getRows("*","chofer","WHERE tipo_chofer = 'Permanente'");
                
		$hoy = date("Y-m-d");
			   $fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        
               $numsocio = count($resultmovil1);
       		//$list = '<div>N° Dias Hábiles de Trabajo: </div><br />';
		$list = '<form name="formPermiso" method="POST" action="print_reporte_chofer.php?accion=saveUpdatePermiso">';
		   
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			  <tr>Reporte de Ahorros Choferes</tr></br>
			  <tr>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
			  <tr>
                <th>Numero de Chofer</th>
				<th>Nombre Chofer</th>
                <th> Dias trabajados</th>
                <th>Ahorro en Bolivianos</th>
				 <th>Pagado</th>
      			<th>Ahorro Disponible</th>
				
                <th></th>
       
	          </tr></thead>';
            $x = 0;
            
            foreach ($resultmovil1 as $key=>$value) {
            
			    $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				
				 $pertenece = $query->getRow("*","hoja_control h, chofer c","where h.id_chofer = ".$value['id_chofer']);
				 
               $hojas = $query->getRows("*","hoja_control h,movil m,linea l","where h.id_movil=m.id_movil and id_chofer = ".$value['id_chofer']."  and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
				$numHojas = count($hojas);
                
				//$transaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '3'");
					$transaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '3'");
				$interes = $transaccion['monto_transaccion']*$numHojas;
					   $ahorropagado = $query->getRow("SUM(a.monto_pago_ahorro) as total","pago_ahorro a, chofer c","where a.id_chofer=c.id_chofer and a.id_chofer = ".$value['id_chofer']." and a.id_movil='0' and a.id_alquiler='0' and a.fecha_ahorro_dia >= '".$fechaInicio."' and a.fecha_ahorro_dia <= '".$fechaFin."'");
              $ahorrocancelado= $ahorropagado['total'];
			  
			$saldoahorro = ($interes - $ahorrocancelado);    

                $list .= '<tbody><tr '.$par.'>
				   
                 
                  <td>'.$value["num_chofer"].'</td>
				   <td>'.$value["nombre_chofer"].'</td>
				  <td align="center">'.$numHojas.'</td>
                  <td align="center">'.$interes.'</td>
                  <td>'.$ahorrocancelado.'</td>
				  <td>'.$saldoahorro.'</td>
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen choferes registrados</div>';
		
		return $list;
		
		
		return $template->Display();
	}
}
?>