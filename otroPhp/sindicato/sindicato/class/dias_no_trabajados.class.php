<?php
class dias_no_trabajados
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
   function modificarPermiso(){
        $query = new query;
        $movil = $query -> getRow("*","movil","where id_movil = ".$_GET[id]);
        $pertenece = $query -> getRow("*","pertenece","where id_movil = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
		$template = new template;
		$template->SetTemplate('html/form_permiso.html');
		$template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','movil.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\" value=\"".$socio['num_licencia']."\">");
        $nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',$nombreSocio);
        /*$lineas = '<select name="linea" id="select">';
        $lineasBd = $query -> getRows("*","linea");
        foreach($lineasBd as $key=>$value) {
            $check = "";
            if($movil['id_linea'] == $value['id_linea'])
                $check = "selected";
            $lineas .= '<option '.$check.' value="'.$value['id_linea'].'">Linea '.$value['linea'].'</option>';
        }
        $lineas .= '</select>';
        $template->SetParameter('lineas',$lineas);*/
        $soloNum = split("_",$movil['num_movil']);
        $template->SetParameter('titulo','PERMISOS ESPECIALES');
        $template->SetParameter('lineas',$soloNum[0]);
		$template->SetParameter('numeroMovil',$soloNum[1]);
		$template->SetParameter('numeroPlaca',$pertenece['razon_permiso']);
        //$tipoIngreso = $query->getRow("id_tipo_ingreso, monto_tipo_dolar","tipo_ingreso","where tipo_ingreso = 'Cambio de Nombre'");
        //$ingreso = $query -> getRow("*","ingreso","where id_socio = ".$socio['id_socio']." and id_tipo_ingreso = ".$tipoIngreso['id_tipo_ingreso']);
		//$template->SetParameter('montoIngreso',$ingreso['monto_ingreso_dolar']);
        $template->SetParameter('numeroPlaca2',$pertenece['num_dias_permiso']);
        $template->SetParameter('accion','saveUpdatePermiso&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    function buscarSocio(){
        $query = new query;
        $nombreSocio = $query->getRow("id_socio, nombre_socio, apellido1_socio, apellido2_socio","socio","where num_licencia = ".$_GET['licencia']);
        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$nombreSocio['id_socio']."\">";
	}
	function saveUpdatePermiso() //save the new Item
    {
        $query = new query;
		
		$insert['id_movil'] = $_GET['id'];
        $id_movil3 = $query->getRow("*","pertenece","where id_movil = ".$_GET['id']);
		$insert['id_socio'] = $id_movil3['id_socio'];    
		
        $insert['razon_permiso'] = $_POST[razon];
        $insert['num_dias_permiso'] = $_POST[dias];
		$insert['fecha_permiso'] = date("Y-m-d");
        if($query->dbInsert($insert,"permiso","where id_movil = ".$_GET['id'])){ //save in the data base
                echo "<script>alert('el registro de permiso fue realizado con exito');</script>";
                echo "<script>window.location.href='dias_no_trabajados.php'</script>";
            }
        
        else{ //error
            echo "<script>alert('Error en la modificacion');</script>";
            echo "<script>window.location.href='dias_no_trabajados.php'</script>";
        }
        echo "<script>window.location.href='dias_no_trabajados.php'</script>";
    }
    
	
	
	function workingdaycount($date1, $date2) 
{ 
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
    return $workdays; 
}  

    
    function DiasNoTrabajados() //list for default the all items
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
                <th>Dias laborables</th>
                
                <th>Dias Trabajados</th>
				<th>Faltas</th>
				<th>Dias Concedidos</th>
				<th>Dias Por cobrar por faltas</th>
				<th></th>
              </tr></thead>';
            $x = 0;
            foreach ($resultsocio as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
                $hojasUsadas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_de_compra >= '".$fechaInicio."' and fecha_de_compra <= '".$fechaFin."'");
                $movil = $query->getRow("num_movil","movil","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio, num_licencia","socio","where id_socio = ".$value['id_socio']);
                $separa = split('_',$movil['num_movil']);
                $numHojas = count($hojas);
                $numHojasUsadas = count($hojasUsadas);
				
                $numTrabajados = $numHojas - $numHojasUsadas;
				//$pertenece = $query -> getRow("num_dias_permiso","permiso","where id_movil = ".$value['id_movil']);
				$pertenece = $query->getRow("num_dias_permiso","permiso","where id_movil = ".$value['id_movil']." and fecha_permiso >= '".$fechaInicio."' and fecha_permiso <= '".$fechaFin."'");
				$numPermiso = count($pertenece);
				
				//para verificar dias laborables sin fines de semana
				/* $dia=$this->workingdaycount($fechaInicio,$fechaFin);
				 if ($dia =10)
				    $dia=$dia +1;
					else
					   if($dia = 20)
					$dia=$dia +2;
					    else  
					$dia=$dia ;*/
				
			//$dia=$dia +1;
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

				 
				 
				/////////////////////////////////////////////////////////////fin dias laborables 
					$faltas = $query->getRows("*","dia_no_trabajado","where id_movil = ".$value['id_movil']." and observacion_falta = 'Falta' and fecha_no_trabajo >= '".$fechaInicio."' and fecha_no_trabajo <= '".$fechaFin."'");
					$numFaltas = count($faltas);
				  $no_trabajo=$dia-$numHojasUsadas;
				/*
				//correcto  $faltaDiaTrabajo = $dia- $numHojasUsadas; // reemplazar '.$numFaltas.'  con '.$faltaDiaTrabajo.'
				*/
				$numcobrar = $numFaltas - $pertenece["num_dias_permiso"];
				
                $list .= '<tbody><tr '.$par.'>
				<td>'.$separa[1].'</td>
				 <td>'.$separa[0].'</td>
                 
                  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                 <td>'.$dia.'</td>
                  
                  <td>'.$numHojasUsadas.'</td>
				  <td>'.$numFaltas.'</td>
				  <td>'.$pertenece["num_dias_permiso"].'</td>
				  <td>'.$numcobrar.'</td>
				  <td><a href="dias_no_trabajados.php?accion=modificar&id='.$value["id_movil"].'" title="Modificar Permiso">[Dias de Permiso]</a></td>
                                  </tr></tbody>';
            }
            $list.='</table>';
        } else $list = '<div>No existen socios registrados</div>';
		return $list;
	}
    
    function FiltrarFechas() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_dias_no_trabajados.html'); //sets the template for this function
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