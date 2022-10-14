<?php
class reporte_faltas
{
	var $parameter=array();
	function SetParameter($name,$value)
	{
		$this->parameter[$name]=$value;
	}
	function mostrarRegistro(){
		$template=new template;
		$template->SetTemplate('html/registro.html');
		return $template->Display();
	}
	function mostrarregistro1(){
		$template=new template;
		$template->SetTemplate('html/logen.html');
		$query=new query;
		$id=$_SESSION['id'];
		$row=$query->getRow("*","usuario","where id_usuario=$id");
		$nombre=" ".$row['nombre_usuario']." ".$row['apellido1_usuario'];
		$template->SetParameter('name',$nombre);
		
		return $template->Display();
	}    


function workingdaycount($date1, $date2) 
{ 
////////////////////////pARA FERIADOS
/*$tDate = explode("-",$date1);
$dateToMySQL = $tDate[2]."-".$tDate[1]."-".$tDate[0];
$tDate2 = explode("-",$date2);
$dateToMySQL = $tDate2[2]."-".$tDate2[1]."-".$tDate2[0];
	
$date3=$this->fHoliday($tDate[2],$tDate[1],$tDate[0]);
$date4=$this->fHoliday($tDate[2],$tDate[1],$tDate[0]);
*/
//////////////////////////



    #####    init result value 
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

    #####    return result 
	/*if (m==1&&d==1)
		r=[" Ene 1, "+y+" \n Feliz Año Nuevo! ",gsAction,"skyblue","red"];
	else if (m==1&&d==6)
		r=[" Ene 6, "+y+" \n Santos Reyes ",gsAction,"skyblue","red"];
	else if (m==3&&d==19)
		r=[" Mar 19, "+y+" \n Día del Padre ",gsAction,"skyblue","red"];
	else if (m==5&&d==1)
		r=[" May 1, "+y+" \n Día del Trabajador Boliviano ",gsAction,"skyblue","red"];
	else if (m==5&&d==27)
		r=[" May 27, "+y+" \n Día de la Madre Boliviana ",gsAction,"skyblue","red"];
	else if (m==6&&d==6)
		r=[" Jun 6, "+y+" \n Día del Maestro, Docente ",gsAction,"skyblue","red"];
	else if (m==8&&d==6)
		r=[" Ago 6, "+y+" \n Día de la Patria ",gsAction,"skyblue","red"];
	else if (m==8&&d==17)
		r=[" Ago 17, "+y+" \n Día de la Bandera Boliviana ",gsAction,"skyblue","red"];
	else if (m==9&&d==14)
		r=[" Sep 14, "+y+" \n Efemérides de Cochabamba ",gsAction,"skyblue","red"];
	else if (m==11&&d==1)
		r=[" Nov 1, "+y+" \n Día de los Difuntos ",gsAction,"skyblue","red"];
	else if (m==12&&d==25)
		r=[" Dic 25, "+y+" \n Feliz Navidad! ",gsAction,"skyblue","red"];
	
*/    /////////////////
	return $workdays; 
}  

    function DiasReporte() //list for default the all items
	{
        $fechaInicio = $_GET[fechaInicio];
        $fechaFin = $_GET[fechaFin];
		//DataBase Conexion//
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
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/reporte_faltas.html'); //sets the template for this function
		$template->SetParameter('fecha_fin',date('Y-m-d'));
		$template->SetParameter('contenido','');
        /*$primera = "2008-12-01";
        $segunda = date("Y-m-d");
        echo "<script> alert('".$this->compararFechas ($primera,$segunda)."');</script>";*/
		return $template->Display();
	}
    
function compararFechas($primera, $segunda)
{
   $valoresPrimera = explode ("-", $primera);
   $valoresSegunda = explode ("-", $segunda);
   $anyoPrimera   = $valoresPrimera[0];
   $mesPrimera  = $valoresPrimera[1];
   $diaPrimera    = $valoresPrimera[2];
   $anyoSegunda  = $valoresSegunda[0];
   $mesSegunda = $valoresSegunda[1];
   $diaSegunda   = $valoresSegunda[2];
   $diasPrimeraJuliano = gregoriantojd($mesPrimera, $diaPrimera, $anyoPrimera);
   $diasSegundaJuliano = gregoriantojd($mesSegunda, $diaSegunda, $anyoSegunda);
   if(!checkdate($mesPrimera, $diaPrimera, $anyoPrimera)){
   // "La fecha ".$primera." no es válida";
    return 0;
   }elseif(!checkdate($mesSegunda, $diaSegunda, $anyoSegunda)){
    // "La fecha ".$segunda." no es válida";
    return 0;
   }else{
    return  $diasSegundaJuliano - $diasPrimeraJuliano;
  }
}
    
	function Display(){
		$template=new template;
		if(!$_SESSION['tipo']){
		
			$template->SetTemplate('html/home12.html');
			$template->SetParameter('registro',$this->mostrarregistro());
		}
		if($_SESSION['tipo']==1){
			$template->SetTemplate('html/home1.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_SESSION['tipo']==2){
			$template->SetTemplate('html/home2.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_SESSION['tipo']==3){
			$template->SetTemplate('html/home.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
		if($_SESSION['tipo']==4){
			$template->SetTemplate('html/home3.html');
			$template->SetParameter('registro',$this->mostrarregistro1());
		}
        
        $template->SetParameter('pie',navigation::showpie());
		if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->FiltrarFechas());
        }
		if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarPermiso());
        }
		return $template->Display();
	}
}
?>