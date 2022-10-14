<?php
class socio
{
	var $parameter=array();
	function SetParameter($name,$value)
	{
		$this->parameter[$name]=$value;
	}
	function mostrarregistro(){
		$template=new template;
		$template->SetTemplate('html/registro.html');
		if($_GET['error']){
			$template->SetParameter('error',"DATOS MALOS INGRESADOS");
		}
		else{
			$template->SetParameter('error',"");
		}
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
	function registrarSocio(){
        $query = new query;
		$template = new template;
		$template->SetTemplate('html/form_socio.html');
        $template->SetParameter('titulo','REGISTRO DE SOCIO');
        $template->SetParameter('licencia','');
		$template->SetParameter('nombreSocio','');
		$template->SetParameter('apellido1','');
		$template->SetParameter('apellido2','');
		$template->SetParameter('direc','');
		$template->SetParameter('telef','');
		$template->SetParameter('radio',"<input name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" checked value=\"Propietario\" onchange=\"Hide('showFechaFin');\"/><label>Propietario</label> <input name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" value=\"Alquiler\" onchange=\"Show('showFechaFin');\"/><label>Alquiler</label>");
		//$template->SetParameter('radio',"<input name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" checked value=\"Propietario\" onchange=\"Hide('showFechaFin'); Hide('montoAlquiler'); Show('montoPropietario');\"/><label>Propietario</label> <input name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" value=\"Alquiler\" onchange=\"Show('showFechaFin'); Show('montoAlquiler'); Hide('montoPropietario');\"/><label>Alquiler</label>");
        /*$lineas = '<select name="linea" id="select"><option value="">--Seleccione--</option>';
        $lineasBd = $query -> getRows("*","linea");
        $montoPropietario = 0;
        $montoAlquilado = 0;
        foreach($lineasBd as $key=>$value) {
            $lineas .= '<option value="'.$value['id_linea'].'" onclick="ajax(\'showMontoFormulario\',\'socio.php?accion=showMontos&montoPropietario='.$value['costo_adquisision'].'&montoAlquiler='.$value['costo_alquiler'].'&radioOpc=\' + document.mframe.tipoSocio.value,\'\');">Linea '.$value['linea'].'</option>';
        }
        $lineas .= '</select>';
        $template->SetParameter('lineas',$lineas);*/
		$template->SetParameter('caractFecha','id="showFechaFin" style="display:none;"');
		$template->SetParameter('fecha_fin','');
		$montoRegistro = $query->getRow("monto_tipo_dolar","tipo_ingreso","where id_tipo_ingreso = '10'");
		/*$template->SetParameter('montoRegistro',"<input name=\"ingreso_socio_nuevo\" type=\"text\" id=\"ingreso_socio_nuevo\" size=\"7\" value=\"".$montoRegistro['monto_tipo_dolar']."\">");*/
		$template->SetParameter('accion','saveSocio');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    
    /*function mostrarMontos(){
        return "<td id=\"montoPropietario\" style=\"display:;\"><input name=\"ingreso_socio_nuevo\" type=\"text\" id=\"ingreso_socio_nuevo\" size=\"7\" value=\"".$_GET[montoPropietario]."\"></td><td id=\"montoAlquiler\" style=\"display:none;\"><input name=\"ingreso_socio_nuevo\" type=\"text\" id=\"ingreso_socio_nuevo\" size=\"7\" value=\"".$_GET[montoAlquiler]."\"></td>";
    }*/
	 function buscarSocio(){
        $query = new query;
        $nombreSocio = $query->getRow("id_socio, nombre_socio, apellido1_socio, apellido2_socio","socio","where num_licencia = ".$_GET['licencia']);
        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$nombreSocio['id_socio']."\">";
	}
    
    function modificarSocio(){
        $query = new query;
        $socio = $query->getRow("*","socio","where id_socio = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_socio.html');
		$template->SetParameter('titulo','MODIFICAR SOCIO');
		$template->SetParameter('licencia',$socio['num_licencia']);
		$template->SetParameter('nombreSocio',$socio['nombre_socio']);
		$template->SetParameter('apellido1',$socio['apellido1_socio']);
		$template->SetParameter('apellido2',$socio['apellido2_socio']);
		$template->SetParameter('direc',$socio['direccion_socio']);
		$template->SetParameter('telef',$socio['telefono_socio']);
        $check1 = "";
        $check2 = "";
        if($socio['tipo_socio'] == "Propietario"){
            $check1 = "checked";
            $template->SetParameter('caractFecha','id="showFechaFin" style="display:none;"');
            $template->SetParameter('fecha_fin','');
        } elseif($socio['tipo_socio'] == "Alquiler"){
            $check2 = "checked";
            $template->SetParameter('fecha_fin',$socio['fecha_fin']);
            $template->SetParameter('caractFecha','id="showFechaFin" style="display:;"');
            //echo "<script>Show('showFechaFin');</script>";
        }
        $template->SetParameter('radio',"<input ".$check1." name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" checked value=\"Propietario\" onchange=\"Hide('showFechaFin');\"/><label>Propietario</label> <input ".$check2." name=\"tipoSocio\" id=\"tipoSocio\" type=\"radio\" value=\"Alquiler\" onchange=\"Show('showFechaFin');\"/><label>Alquiler</label>");
		$template->SetParameter('accion','saveUpdateSocio&id='.$_GET['id']);
		$template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteSocio(){
        $query = new query;
        if($query->dbDelete("socio","WHERE id_socio = ".$_GET['id']))
            echo "<script>alert('Socio eliminado exitosamente')</script>";
        echo "<script>window.location.href='socio.php'</script>";
	}
    
    function saveUpdateSocio() //save the new Item
    {
        $query = new query;
        $update['nombre_socio'] = $_POST[nombre_socio];
        $update['apellido1_socio'] = $_POST[ape1];
        $update['apellido2_socio'] = $_POST[ape2];
        $update['num_licencia'] = $_POST[numero_licencia];
        $update['direccion_socio'] = $_POST[direccion];
        $update['telefono_socio'] = $_POST[telefono];
        $update['estado_socio'] = 'activo';
        $update['tipo_socio'] = $_POST[tipoSocio];
        if($update['tipo_socio'] == "Alquiler")
            $update['fecha_fin'] = $_POST[fecha_fin];
        if($query->dbUpdate($update,"socio","where id_socio = ".$_GET['id'])){ //save in the data base
            echo "<script>alert('Socio modificado exitosamente');</script>";
        }
        else{ //error
            echo "<script>alert('Error en la modificacion');</script>";
        }
        echo "<script>window.location.href='socio.php'</script>";
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
        if($query->dbInsert($insert,"socio")){
            echo "<script>alert('Socio registrado exitosamente');</script>";
            echo "<script>window.location.href='socio.php'</script>";
        }
        else{ //error
            echo "<script>alert('Error en el registro');</script>";
            echo "<script>window.location.href='socio.php'</script>";
        }
    
	}
    
    function listarSocio() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_socio.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar socio?');";
        $resultsocio= $query->getRows("*","socio order by nombre_socio");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resultsocio1 = $query->getRows("*","socio","order by num_licencia ");
        $numsocio = count($resultsocio1);
        if($numsocio > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Licencia</th>
                <th>Nombre Socio</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Tipo socio</th>
                <th>Modificar</th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultsocio1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["num_licencia"].'</td>
                  <td>'.$value["nombre_socio"].' '.$value["apellido1_socio"].' '.$value["apellido2_socio"].'</td>
                  <td>'.$value["direccion_socio"].'</td>
                  <td>'.$value["telefono_socio"].'</td>
                  <td>'.$value["tipo_socio"].'</td>
                  <td><a href="socio.php?accion=modificar&id='.$value["id_socio"].'" title="Modificar socio"><img src="images/edit.gif"></a></td>
                  </tr></tbody>';
            }
	     //<td><a href="socio.php?accion=delete&id='.$value["id_socio"].'" onClick="'.$confirm.'" title="Eliminar socio"><img src="images/delete.gif"></a></td>
                 
            $list.='</table>';
            //$list .= paging::navigation(count($resultsocio),"socio.php",20);
        } else $list = '<div>No existen socios registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'socio.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
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
		if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarSocio());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarSocio());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarSocio());
        }
		$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
?>
