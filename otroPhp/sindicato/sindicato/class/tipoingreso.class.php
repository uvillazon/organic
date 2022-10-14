<?php
class tipoingreso
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
	function registrarTipoIngreso(){
		$template = new template;
		$template->SetTemplate('html/form_tipoingreso.html');
		$template->SetParameter('tipoingreso','');
        $template->SetParameter('monto_tipo_ingreso','');
		$template->SetParameter('monto_tipo_ingresoa','');
        $template->SetParameter('accion','saveTipoIngreso');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoIngreso(){
        $query = new query;
        $tipoingreso = $query -> getRow("*","tipo_ingreso","where id_tipo_ingreso = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_tipoingreso.html');
        $monto = '';
       /* if($tipoingreso["monto_tipo_ingreso"]==0)
            $monto = $tipoingreso["monto_tipo_dolar"];
        else
            $monto = $tipoingreso["monto_tipo_ingreso"];*/
		$template->SetParameter('tipoingreso',$tipoingreso["tipo_ingreso"]);
        $template->SetParameter('monto_tipo_ingreso',$tipoingreso["monto_tipo_ingreso"]);
		$template->SetParameter('monto_tipo_ingresoa',$tipoingreso["monto_tipo_dolar"]);
        $template->SetParameter('accion','saveUpdateTipoIngreso&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteTipoIngreso(){
        $query = new query;
        if($query->dbDelete("tipo_ingreso","WHERE id_tipo_ingreso = ".$_GET['id']))
            //echo "<script>alert('Tipo de ingreso elminado exitosamente')</script>";
        echo "<script>window.location.href='tipoingreso.php'</script>";
	}
    
    function saveUpdateTipoIngreso() //save the new Item
    {
        $query = new query;
        $update['tipo_ingreso'] = $_POST['tipo_ingreso'];
        $update['monto_tipo_ingreso'] = $_POST['monto_tipo_ingreso'];   
		  $update['monto_tipo_dolar'] = $_POST['monto_tipo_ingresoa'];        
		if($query->dbUpdate($update,"tipo_ingreso","where id_tipo_ingreso = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de ingreso modificado exitosamente');</script>";
			echo "<script>window.location.href='tipoingreso.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='tipoingreso.php'</script>";
		}
    }
    
    function saveTipoIngreso() //save the new Item
    {
        $query = new query;
        $insert['tipo_ingreso'] = $_POST[tipo_ingreso];
        $insert['monto_tipo_ingreso'] = $_POST[monto_tipo_ingreso];
		$insert['monto_tipo_dolar'] = $_POST[monto_tipo_ingresoa];
		$insert['clasificacion'] = "movil";
		if($query->dbInsert($insert,"tipo_ingreso")){ //save in the data base
			//echo "<script>alert('Tipo de ingreso registrado exitosamente');</script>";
			echo "<script>window.location.href='tipoingreso.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='tipoingreso.php'</script>";
		}
    }
    
    function listarTipoIngresos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_tipoingreso.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este tipo de ingreso?');";
        $resultingreso = $query->getRows("*","tipo_ingreso");
        $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 10;
        $resultingreso1 = $query->getRows("*","tipo_ingreso","LIMIT $init , 10");
        $numingreso = count($resultingreso1);
        if($numingreso > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Tipo ingreso</th>
                <th>Monto</th>
                <th>Modificar</th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultingreso1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $monto = '';
                if($value["monto_tipo_ingreso"]==0)
                    $monto = $value["monto_tipo_dolar"]." $";
                else 
                    $monto = $value["monto_tipo_ingreso"]." Bs";
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$value["tipo_ingreso"].'</td>
				  <td>'.$monto.'</td>
                  
                  <td><a href="tipoingreso.php?accion=modificar&id='.$value["id_tipo_ingreso"].'" title="Modificar Tipo Ingreso"><img src="images/edit.gif"></a></td>
                  <td><a href="tipoingreso.php?accion=delete&id='.$value["id_tipo_ingreso"].'" onClick="'.$confirm.'" title="Eliminar tipo ingreso"><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
            $list .= paging::navigation(count($resultingreso),"tipoingreso.php",10);
        } else $list = '<div>No existen Tipos de ingresos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'tipoingreso.php?accion=registro\'">';
        $template->SetParameter('add',$buttonAdd);
		$template->SetParameter('contenido',$list);
		return $template->Display();
	}
    
	function Display(){
		$template = new template;
		
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
        if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarTipoIngresos());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarTipoIngreso());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarTipoIngreso());
        }
        	$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
