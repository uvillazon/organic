<?php
class print_socio
{
	function Display(){
        $fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		
        $query = new query;
       $chofer = $query -> getRow("*","chofer","where id_chofer = ".$_GET[id]);
        //$pertenece = $query -> getRow("*","pertenece","where id_movil = ".$_GET[id]);
        //$socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
		$template = new template;
		$template->SetTemplate('html/form_ahorro_chofer.html');
		$fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		$template->SetParameter('fechainicio',$fechaIni);
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        $template->SetParameter('fechafin',$fechaF);
        
		$template->SetParameter('licencia',$chofer['num_chofer']);
$template->SetParameter('nombreSocio',$chofer['nombre_chofer']);
                
		$template->SetParameter('titulo','REPORTE AHORRO DEL ALQUILER');
        $hojas = $query->getRows("*","hoja_control h, chofer c","where h.id_chofer=c.id_chofer and h.id_chofer = ".$chofer['id_chofer']."  and h.fecha_falta >= '".$fechaInicio."' and h.fecha_falta <= '".$fechaFin."'");
				$numHojas = count($hojas);
                
				$transaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = '3'");
				$interes = $transaccion['monto_transaccion']*$numHojas;
               $interes=$interes*2;
						//de los pagos de ahorros
	   $ahorropagado = $query->getRow("SUM(a.monto_pago_ahorro) as total","pago_ahorro a, chofer c","where a.id_chofer=c.id_chofer and a.id_chofer = ".$chofer['id_chofer']." and a.id_movil='0' and a.id_alquiler='0' and a.fecha_ahorro_dia >= '".$fechaInicio."' and a.fecha_ahorro_dia <= '".$fechaFin."'");
              $ahorrocancelado= $ahorropagado['total'];
			  
			$saldoahorro = ($interes - $ahorrocancelado);    
			    //fin
				//de los pagos de ahorros
	   	$template->SetParameter('diastrabajados',$numHojas);
        $template->SetParameter('hojas',$numHojas);
		
		
		
		
		$template->SetParameter('diasconchofer',$diaschofer);
		
		        //control de hojas     
//$ahorrocobrado

			    //$totalahorro=$ahorroCho + $ahorroSo;
			    
			    //de los pagos de ahorros
$template->SetParameter('totalahorro',$interes);
		$template->SetParameter('ahorrocancelado',$ahorrocancelado);
		$template->SetParameter('saldoahorro',$saldoahorro);
		
//
				
	$resultplan = $query->getRows("*","hoja_control","where id_chofer = ".$chofer['id_chofer']."  and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
         $numcp='15';
		$ini='0';
		$hojax='1';
		$mostrarsolo=$_GET["numcp"];
$iniciarde=$_GET["ini"];		 
$numerarcpx=$iniciarde;
		   
	   $numplan = count($resultplan);
        if($numplan > 0) {
            $list ='<center><table border = "1">
              <thead><tr>
			  <th>Nro</th>
				
                <th>Fecha Compra</th>
				 <th>Numero</th>
                <th>Linea</th>
                <th>Movil</th>
                <th>Nombre Chofer</th>
                <th>Hora Compra</th>
                <th>Monto</th>
                
                <th>Fecha Control</th>
                
              </tr></thead>';
            $x = 0;
            foreach ($resultplan as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $linea = $query->getRow("linea, num_movil","linea l, movil m","where m.id_movil = ".$value['id_movil']." and m.id_linea = l.id_linea");
                $nombreChofer = "";
                if($value['id_chofer'] == 0) {
                    $nombreSocio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio","socio s, pertenece p","where p.id_movil = ".$value['id_movil']." and p.id_socio = s.id_socio");
                    $nombreChofer = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
                } else {
                    $nombre = $query->getRow("nombre_chofer","chofer","where id_chofer = ".$value['id_chofer']);
                    $nombreChofer = $nombre['nombre_chofer'];
                }
                $numMovil = split('_',$linea["num_movil"]);
                $numero=($numerarcpx+1);
              
				$list .= '<tbody><tr '.$par.'>
  <td>'.$numero.'</td>
				              
			  <td>'.$value["fecha_de_compra"].'</td>
                                  
				 <td>'.$value["numero_hoja"].'</td>
                  <td>'.$linea["linea"].'</td>
                  <td>'.$numMovil[1].'</td>
                  <td>'.$nombreChofer.'</td>
                  <td>'.$value["hora_compra"].'</td>
                  <td>'.$value["total_hoja"].'</td>
                  <td>'.$value["fecha_falta"].'</td>
				  </tr></tbody>';
              
$numerarcpx=$numerarcpx+1;

			}
            $list.='</table></center>';
        } else $list = '<div>No existen hojas compradas en este rango de fechas</div>';
//fin lista hojas		
		$template->SetParameter('contenido',$list);
		
		
		return $template->Display();
	}
}
?>