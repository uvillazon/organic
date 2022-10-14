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
		 $fecha=$fechaInicio; // El formato que te entrega MySQL es Y-m-d 
             $fechaIni=date("d-m-Y",strtotime($fecha)); 
		
		$fecha2=$fechaFin; // El formato que te entrega MySQL es Y-m-d 
             $fechaF=date("d-m-Y",strtotime($fecha2)); 
        
        $numsocio = count($resultsocio);
        //$list = '<div>N° Dias Hábiles de Trabajo: </div><br />';
        if($numsocio > 0) {
            $list .='<table border = "1">
              <thead>
			  <tr><b>REPORTE DE FALTAS</b></tr></br>
			  <tr>Del :<tr>'.$fechaIni.'</tr> <b>Al:<tr>'.$fechaF.'</tr>
			  
			  <tr>
			   <th>Movil</th>
			  <th>Linea</th>
                 <th>Nombre Socio</th>
                <th>Num minimo de dias</th>
                <th>Nro de Hojas Compradas</th>
                <th>Faltas</th>
             
              </tr></thead>';
            $x = 0;
            foreach ($resultsocio as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_falta >= '".$fechaInicio."' and fecha_falta <= '".$fechaFin."'");
                //$hojasUsadas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and hoja_usada = 'Recibido' and fecha_a_usar >= '".$fechaInicio."' and fecha_a_usar <= '".$fechaFin."'");
                $movil = $query->getRow("num_movil","movil","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio, num_licencia","socio","where id_socio = ".$value['id_socio']);
                $separa = split('_',$movil['num_movil']);
                $numHojas = count($hojas);
				 $dia = '18';
				 $diad = '19';
				 $deuda = '0';
				 if($numHojas<$diad) 
                   { 
                     $deuda = $dia - $numHojas; 
                     }
				else {
				     $deuda = $deuda;
					 }	  
                //$numHojasUsadas = count($hojasUsadas);
                //$numTrabajados = $numHojas - $numHojasUsadas;
                $list .= '<tbody><tr '.$par.'>
                <td>'.$separa[1].'</td>
                 <td>'.$separa[0].'</td>
                  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                   <td>'.$dia.'</td>
				  <td>'.$numHojas.'</td>
                  <td>'.$deuda.'</td>
                
                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
     }
}

?>