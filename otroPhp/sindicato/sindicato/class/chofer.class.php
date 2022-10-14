<?php
class chofer
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
	function registrarChofer(){
        $query = new query;
		$template = new template;
		$template->SetTemplate('html/form_chofer.html');
        $mayor = $query->getRow("MAX(num_chofer) as mayor","chofer");
        if($mayor['mayor'] == null) {
            $num_chofer = 401;
        }
        else {
            $num_chofer = $mayor['mayor']+1;
        }
        $template->SetParameter('titulo','REGISTRO DE CHOFER y/o ALQUILER');
		$template->SetParameter('numChofer',$num_chofer);
		//$template->SetParameter('validate','onsubmit="return validaChofer();"');
		$template->SetParameter('numLicencia','');
		$template->SetParameter('nombreChofer','');
		$template->SetParameter('direccion','');
		$template->SetParameter('telefono','');
		$template->SetParameter('radio','<input name="tipoChofer" type="radio" checked value="Permanente"/><label>CHOFER</label> <input name="tipoChofer" type="radio" value="alquiler"/><label>ALQUILER</label>');
		$template->SetParameter('observacion','');
		$template->SetParameter('accion','saveChofer');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarChofer(){
        $query = new query;
        $chofer = $query->getRow("*","chofer","where id_chofer = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_chofer.html');
		$template->SetParameter('titulo','MODIFICAR DATOS');
		//$template->SetParameter('validate','onsubmit="return validaChofer();"');
		$template->SetParameter('numChofer',$chofer['num_chofer']);
		$template->SetParameter('numLicencia',$chofer['licencia']);
		$template->SetParameter('nombreChofer',$chofer['nombre_chofer']);
		$template->SetParameter('direccion',$chofer['direccion_chofer']);
		$template->SetParameter('telefono',$chofer['telefono_chofer']);
        $check1 = "";
        $check2 = "";
        if($chofer['tipo_chofer'] == "Permanente"){
            $check1 = "checked";
        } elseif($chofer['tipo_chofer'] == "alquiler"){
            $check2 = "checked";
        }
        $template->SetParameter('radio','<input name="tipoChofer" type="radio" '.$check1.' value="Permanente"/><label>Chofer</label> <input name="tipoChofer" type="radio" '.$check2.' value="alquiler"/><label>Alquiler</label>');
		$template->SetParameter('observacion',$chofer['observacion']);
		$template->SetParameter('accion','saveUpdateChofer&id='.$_GET['id']);
		$template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteChofer(){
        $query = new query;
        if($query->dbDelete("chofer","WHERE id_chofer = ".$_GET['id']))
            echo "<script>alert('Chofer elminado exitosamente')</script>";
        echo "<script>window.location.href='chofer.php'</script>";
	}
    
    function saveUpdateChofer() //save the new Item
    {
        $query = new query;
        $update['num_chofer'] = $_POST[numero_chofer];
        $update['licencia'] = $_POST[numero_licencia];
        $update['nombre_chofer'] = $_POST[nombre_chofer];
        $update['telefono_chofer'] = $_POST[telefono];
        $update['direccion_chofer'] = $_POST[direccion];
        $update['tipo_chofer'] = $_POST[tipoChofer];
        $update['observacion'] = $_POST[observacion];
        if($query->dbUpdate($update,"chofer","where id_chofer = ".$_GET['id'])){ //save in the data base
            echo "<script>alert('Chofer modificado exitosamente');</script>";
        }
        else{ //error
            echo "<script>alert('Error en el registro');</script>";
        }
        echo "<script>window.location.href='chofer.php'</script>";
    }
    
    function saveChofer() //save the new Item
    {
        $query = new query;
        $insert['num_chofer'] = $_POST[numero_chofer];
        $insert['licencia'] = $_POST[numero_licencia];
        $insert['nombre_chofer'] = $_POST[nombre_chofer];
        $insert['fecha_registro_chofer'] = date("Y-m-d");
        $insert['telefono_chofer'] = $_POST[telefono];
        $insert['direccion_chofer'] = $_POST[direccion];
        $insert['observacion'] = $_POST[observacion];
        $insert['tipo_chofer'] = $_POST[tipoChofer];
        $resti = $query->getRows("*","chofer","WHERE nombre_chofer = '".$insert['nombre_chofer']."'");
        if(count($resti) == 0) {
            if($query->dbInsert($insert,"chofer")){ //save in the data base
                echo "<script>alert('Chofer registrado exitosamente');</script>";
                echo "<script>window.location.href='chofer.php'</script>";
            }
            else{ //error
                echo "<script>alert('Error en el registro');</script>";
                echo "<script>window.location.href='chofer.php'</script>";
            }
        } echo "<script>window.location.href='chofer.php'</script>";
    }
    
    function listarChofer() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_chofer.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar chofer?');";
        $resultchofer = $query->getRows("*","chofer");
       // $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resultchofer1 = $query->getRows("*","chofer");
        $numchofer = count($resultchofer1);
        if($numchofer > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Numero</th>
                <th>Licencia</th>
                <th>Nombre</th>
                <th>Direccion</th>
                <th>Tipo chofer</th>
                <th>Observaciones</th>
                <th>Modificar</th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultchofer1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["num_chofer"].'</td>
                  <td>'.$value["licencia"].'</td>
                  <td>'.$value["nombre_chofer"].'</td>
                  <td>'.$value["direccion_chofer"].'</td>
                  <td>'.$value["tipo_chofer"].'</td>
                  <td>'.$value["observacion"].'</td>
                  <td><a href="chofer.php?accion=modificar&id='.$value["id_chofer"].'" title="Modificar chofer"><img src="images/edit.gif"></a></td>
                  </tr></tbody>';
            }
	    //  <td><a href="chofer.php?accion=delete&id='.$value["id_chofer"].'" onClick="'.$confirm.'" title="Eliminar chofer"><img src="images/delete.gif"></a></td>
                
            $list.='</table>';
            //$list .= paging::navigation(count($resultchofer),"chofer.php",20);
        } else $list = '<div>No existen choferes registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'chofer.php?accion=registro\'">';
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
              $template->SetParameter('pie',navigation::showpie());
		
		if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarChofer());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarChofer());
		}
		/*if($_GET['accion']=="registro"){
        	$template->SetParameter('','script/valida.js');
        }*/
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarChofer());
        }
		return $template->Display();
	}
}
?>
