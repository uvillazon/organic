<?php
class print_falta
{
function workingdaycount($date1, $date2) 
{ 

    $workdays = 0; 

    #####    get unix timestamps (input must be formatted yyyy-mm-dd) 
    $unixdate1 = mktime(0,0,0, intval(substr($date1, 5, 2)), intval(substr($date1, 8, 2)), intval(substr($date1, 0, 4))); 
    $unixdate2 = mktime(0,0,0, intval(substr($date2, 5, 2)), intval(substr($date2, 8, 2)), intval(substr($date2, 0, 4))); 
     
    #####    make sure order of stamps is correct 
    if($unixdate2<$unixdate1) 
    { 
        $temp = $unixdate1; 
        $unixdate1 = $unixdate2; 
        $unixdate2 = $temp; 
    } 

    #####    get time difference 
    $timediff = $unixdate2 - $unixdate1; 

    $weekseconds = 604800;         # 60*60*24*7 = amount of seconds in a week 
     
    #####    get number of complete weeks, multiply by 5 for number of working days. 
    $workdays += (5 * floor($timediff / $weekseconds)); 

    #####    get day of week for both entries (0 => sunday, 6 => saturday) 
    $weekday1 = date('w', $unixdate1); 
    $weekday2 = date('w', $unixdate2); 

    #####    calculate amount of days in between, weekwise 
    if($weekday1 < $weekday2)    # no weekend in between  
    { 
        if($weekday2 > 5) 
            $weekday2 = 5; 
        $workdays += $weekday2 - $weekday1; 
    }                # weekend in between 
    else 
        $workdays += 5 + $weekday2 - $weekday1; 

  
	return $workdays; 
}  

function Display(){
     $fechaInicio = $_GET[fi];
        $fechaFin = $_GET[ff];
		$query = new query;
		    $resultsocio= $query->getRows("*","pertenece p","order by p.id_movil");
        $hoy = date("Y-m-d");
        $numsocio = count($resultsocio);
        //$list = '<div>N° Dias Hábiles de Trabajo: </div><br />';
		$list = '<form name="formPermiso" method="POST" action="dias_no_trabajados.php?accion=saveUpdatePermiso">';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead><tr>
			  <th>Movil</th>
                <th>Linea</th>
                <th>Nombre Socio</th>
                <th>Dias laborales</th>
                <th>Dias Trabajados</th>
				<th>Faltas</th>
				<th>Dias Concedidos</th>
				<th>Dias por cobrar </th>
				<th>Ingreso dias de Permiso</th>
                <th>Dias no cancelados</th>
				<th>Monto Adeudado [Bs.]</th>          
			  </tr></thead>';
            $x = 0;
            foreach ($resultsocio as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				//para contar dias trabajados con hojas de control<td>'.$diatrabajado.'</td>
				  
                $hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
                $hojasUsadas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
                $numHojas = count($hojas);
                $numHojasUsadas = count($hojasUsadas);
				
                $numTrabajados = $numHojas - $numHojasUsadas;
				////////////////////////////////////////////////////
				$pertenece = $query -> getRow("num_dias_permiso","permiso","where id_movil = ".$value['id_movil']);
				$numfalta = count($pertenece);
                $movil = $query->getRow("id_movil, num_movil","movil","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("id_socio, nombre_socio, apellido1_socio, apellido2_socio, num_licencia","socio","where id_socio = ".$value['id_socio']);
                $separa = split('_',$movil['num_movil']);
                
				//$date="25/10/2007"; // dato de prueba
/*$tDate = explode("-",$fechaFin);
$dateToMySQL = $tDate[2]."-".$tDate[1]."-".$tDate[0];
$tDate2 = explode("-",$fechaInicio);
$dateToMySQL = $tDate2[2]."-".$tDate2[1]."-".$tDate2[0];
				  $dia=$tDate[2]-$tDate2[2];
				  if ($dia< 10)
				    $dia=$dia -2;
					else
					   if($dia<20)
					$dia=$dia -4;
					    else  
					$dia=$dia -6;
				
			$dia=$dia +1;*/
		$tDate = explode("-",$fechaInicio);
$dateToMySQL = $tDate[2]."-".$tDate[1]."-".$tDate[0];
$tDate2 = explode("-",$fechaFin);
$dateToMySQL = $tDate2[2]."-".$tDate2[1]."-".$tDate2[0];
	

					///////////////////////////////////////////////
					$dia=$this->workingdaycount($fechaInicio,$fechaFin);
			        if ($dia < 11)
				    $dia=$dia +1;
					else
					 if ($dia > 19)
					    $dia=$dia +2;
					 else 
					 if(($dia = 20)&&($tDate2[1]== "05"))
					       $dia=$dia +3;
						 else
						 if(($dia = 20)&&($tDate2[1]== 08))
					       $dia=$dia +3;
						  else
						  if(($dia = 21)&&($tDate2[1]== 11))
					       $dia=$dia +3; 
	                      else  				
					$dia = $dia + 2;
					
	
					///////////////////////////////////////////////
					$faltas = $query->getRows("*","dia_no_trabajado","where id_movil = ".$value['id_movil']." and observacion_falta = 'Falta' and fecha_no_trabajo >= '".$fechaInicio."' and fecha_no_trabajo <= '".$fechaFin."'");
					$numFaltas = count($faltas);
				  //$no_trabajo=$dia-$numHojasUsadas;
				  $diatrabajado=$dia-$numFaltas;
				/*$numcobrar = $numTrabajados - $pertenece["num_dias_permiso"];
				*/$numcobrar = $numFaltas - $pertenece["num_dias_permiso"];
				///////////////////////////////////////////////////////////////////////////////para ingresos
				$totalPago = $query->getRow("SUM(monto_pago_ingreso) as total","ingreso ","where id_tipo_ingreso='2' and id_movil= ".$value['id_movil']." and fecha_ingreso >= '".$fechaInicio."' and fecha_ingreso <= '".$fechaFin."'");
        $totalmonto=$totalPago['total'];
		$montopermiso = $query->getRow("monto_tipo_ingreso","tipo_ingreso","where id_tipo_ingreso = '2'");
		$diaspermiso = $totalmonto / $montopermiso["monto_tipo_ingreso"];
		$deudadias=$numcobrar - $diaspermiso;
		$deudamonto=$deudadias*$montopermiso["monto_tipo_ingreso"];
                
		//////////////////////////////////////////////////////////////////////////////fin ingresos////<td>'.$numHojasUsadas.'</td>
				/*
				//correcto  $faltaDiaTrabajo = $dia- $numHojasUsadas; // reemplazar '.$numFaltas.'  con '.$faltaDiaTrabajo.'
				*/
                $list .= '<tbody><tr '.$par.'>
				<td>'.$separa[1].'</td>
				 <td>'.$separa[0].'</td>
                 
                  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                 <td>'.$dia.'</td>
				 <td>'.$numHojasUsadas.'</td>
                  
                  <td>'.$numFaltas.'</td>
				  <td>'.$pertenece["num_dias_permiso"].'</td>
				  <td>'.$numcobrar.'</td>
				  <td>'.$diaspermiso.'</td>
				  <td>'.$deudadias.'</td>
				  <td>'.$deudamonto.'</td>
                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
}
}

?>