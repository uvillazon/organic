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
    
	function saveUpdatePermiso() //save the new Item
    {
        $query = new query;
        $update['razon_permiso'] = $_POST[razon];
        $update['num_dias_permiso'] = $_POST[dias];
        if($query->dbUpdate($update,"pertenece","where id_movil = ".$_GET['id'])){ //save in the data base
                echo "<script>alert('La modificacion fue realizada con exito');</script>";
                echo "<script>window.location.href='dias_no_trabajados.php'</script>";
            }
        
        else{ //error
            echo "<script>alert('Error en la modificacion');</script>";
            echo "<script>window.location.href='dias_no_trabajados.php'</script>";
        }
        echo "<script>window.location.href='dias_no_trabajados.php'</script>";
    }
    
	
	 function saveSocio() //save the new Item
    {
        $query = new query;
        $insert['nombre_socio'] = $_POST[nombre_socio];
        $insert['apellido1_socio'] = $_POST[ape1];
        $insert['apellido2_socio'] = $_POST[ape2];
        $insert['num_licencia'] = $_POST[numero_licencia];
        $insert['direccion_socio'] = $_POST[direccion];
        $insert['telefono_socio'] = $_POST[telefono];
        $insert['fecha_registro_socio'] = date("Y-m-d");
        $insert['estado_socio'] = 'activo';
        $insert['tipo_socio'] = $_POST[tipoSocio];
        $insert['fecha_inicio'] = date("Y-m-d");
        if($insert['tipo_socio'] == "Alquiler")
            $insert['fecha_fin'] = $_POST[fecha_fin];
        if($query->dbInsert($insert,"socio")){ //save in the data base
            echo "<script>alert('Socio registrado exitosamente');</script>";
            echo "<script>window.location.href='socio.php'</script>";
        }
        else{ //error
            echo "<script>alert('Error en el registro');</script>";
            echo "<script>window.location.href='socio.php'</script>";
        }
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
                <th>Licencia</th>
                <th>Nombre Socio</th>
                <th>Linea</th>
                <th>Movil</th>
                <th>N° Dias No Trabajados</th>
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
                $hojas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and fecha_a_usar >= '".$fechaInicio."' and fecha_a_usar <= '".$fechaFin."'");
                $hojasUsadas = $query->getRows("*","hoja_control","where id_movil = ".$value['id_movil']." and hoja_usada = 'Recibido' and fecha_a_usar >= '".$fechaInicio."' and fecha_a_usar <= '".$fechaFin."'");
                $movil = $query->getRow("num_movil","movil","where id_movil = ".$value['id_movil']);
                $socio = $query->getRow("nombre_socio, apellido1_socio, apellido2_socio, num_licencia","socio","where id_socio = ".$value['id_socio']);
                $separa = split('_',$movil['num_movil']);
                $numHojas = count($hojas);
                $numHojasUsadas = count($hojasUsadas);
				
                $numTrabajados = $numHojas - $numHojasUsadas;
				$pertenece = $query -> getRow("num_dias_permiso","pertenece","where id_movil = ".$value['id_movil']);
				$numfalta = count($pertenece);
                
				$numcobrar = $numTrabajados - $pertenece["num_dias_permiso"];
				
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$socio["num_licencia"].'</td>
                  <td>'.$socio["nombre_socio"].' '.$socio["apellido1_socio"].' '.$socio["apellido2_socio"].'</td>
                  <td>'.$separa[0].'</td>
                  <td>'.$separa[1].'</td>
                  <td>'.$numTrabajados.'</td>
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