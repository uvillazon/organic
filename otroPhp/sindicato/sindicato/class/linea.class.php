<?php
class linea
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
	function registrarLinea(){
        $query = new query;
		$template = new template;
		$template->SetTemplate('html/form_linea.html');
        $template->SetParameter('titulo','REGISTRO DE LINEA');
		$template->SetParameter('linea','');
		$template->SetParameter('descripcion','');
		$template->SetParameter('fecha_creacion','');
		$template->SetParameter('costo','');
		$template->SetParameter('accion','saveLinea');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarLinea(){
        $query = new query;
        $chofer = $query->getRow("*","linea","where id_linea = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_linea.html');
		$template->SetParameter('titulo','MODIFICAR LINEA');
		$template->SetParameter('linea',$chofer['linea']);
		$template->SetParameter('descripcion',$chofer['descripcion']);
		$template->SetParameter('fecha_creacion',$chofer['fecha_creacion']);
		$template->SetParameter('costo',$chofer['costo_adquisision']);
		$template->SetParameter('accion','saveUpdateLinea&id='.$_GET['id']);
		$template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteLinea(){
        $query = new query;
        if($query->dbDelete("linea","WHERE id_linea = ".$_GET['id']))
            echo "<script>alert('Linea elminado exitosamente')</script>";
        echo "<script>window.location.href='linea.php'</script>";
	}
    
    function saveUpdateLinea() //save the new Item
    {
        $query = new query;
        $update['linea'] = $_POST[linea];
        $update['descripcion'] = $_POST[descripcion];
        $update['fecha_creacion'] = $_POST[fecha_creacion];
        $update['fecha_modificacion'] = date("Y-m-d");
        $update['costo_adquisision'] = $_POST[costo];
        if($query->dbUpdate($update,"linea","where id_linea = ".$_GET['id'])){ //save in the data base
            echo "<script>alert('Linea modificado exitosamente');</script>";
        }
        else{ //error
            echo "<script>alert('Error en la modificación');</script>";
        }
        echo "<script>window.location.href='linea.php'</script>";
    }
    
    function saveLinea() //save the new Item
    {
        $query = new query;
        $insert['linea'] = $_POST[linea];
        $insert['descripcion'] = $_POST[descripcion];
        $insert['fecha_creacion'] = $_POST[fecha_creacion];
        $insert['fecha_modificacion'] = date("Y-m-d");
        $insert['costo_adquisision'] = $_POST[costo];
        $resti = $query->getRows("*","linea","WHERE linea = '".$insert['linea']."'");
        if(count($resti) == 0) {
            if($query->dbInsert($insert,"linea")){ //save in the data base
                echo "<script>alert('Linea registrado exitosamente');</script>";
                echo "<script>window.location.href='linea.php'</script>";
            }
            else{ //error
                echo "<script>alert('Error en el registro');</script>";
                echo "<script>window.location.href='linea.php'</script>";
            }
        } echo "<script>window.location.href='linea.php'</script>";
    }
    
    function listarLinea() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_linea.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar linea?');";
        $resultlinea = $query->getRows("*","linea");
        $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resultlinea1 = $query->getRows("*","linea","LIMIT $init , 20");
        $numlinea = count($resultlinea1);
        if($numlinea > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Linea</th>
                <th>Descripción</th>
                <th>Fecha creación</th>
                <th>Costo adquisición</th>
                <th>Modificar</th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultlinea1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$value["linea"].'</td>
                  <td>'.$value["descripcion"].'</td>
                  <td>'.$value["fecha_creacion"].'</td>
                  <td>'.$value["costo_adquisision"].' $</td>
                  <td><a href="linea.php?accion=modificar&id='.$value["id_linea"].'" title="Modificar linea"><img src="images/edit.gif"></a></td>
                  </tr></tbody>';
            }
	       //<td><a href="linea.php?accion=delete&id='.$value["id_linea"].'" onClick="'.$confirm.'" title="Eliminar linea"><img src="images/delete.gif"></a></td>
               
            $list.='</table>';
            $list .= paging::navigation(count($resultlinea),"linea.php",20);
        } else $list = '<div>No existen lineas registradas</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'linea.php?accion=registro\'">';
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
		if($_GET['accion']==""){
            $template->SetParameter('contenido',$this->listarLinea());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarLinea());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarLinea());
        }
		$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
?>
