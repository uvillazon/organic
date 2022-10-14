<?php
class tipoprestamo
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
	function registrarTipoPrestamo(){
		$template = new template;
		$template->SetTemplate('html/form_tipoprestamo.html');
		$template->SetParameter('tipoprestamo','');
        $template->SetParameter('interes','');
        $template->SetParameter('accion','saveTipoPrestamo');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoPrestamo(){
        $query = new query;
        $tipoprestamo = $query -> getRow("*","tipo_prestamo","where id_tipo_prestamo = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_tipoprestamo.html');
		$template->SetParameter('tipoprestamo',$tipoprestamo["tipo_prestamo"]);
        $template->SetParameter('interes',$tipoprestamo["interes"]);
        $template->SetParameter('accion','saveUpdateTipoPrestamo&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteTipoPrestamo(){
        $query = new query;
        if($query->dbDelete("tipo_prestamo","WHERE id_tipo_prestamo = ".$_GET['id']))
            //echo "<script>alert('Tipo de prestamo elminado exitosamente')</script>";
        echo "<script>window.location.href='tipoprestamo.php'</script>";
	}
    
    function saveUpdateTipoPrestamo() //save the new Item
    {
        $query = new query;
        $update['tipo_prestamo'] = $_POST['tipo_prestamo'];
        $update['interes'] = $_POST['interes'];        
		if($query->dbUpdate($update,"tipo_prestamo","where id_tipo_prestamo = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de prestamo modificado exitosamente');</script>";
			echo "<script>window.location.href='tipoprestamo.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='tipoprestamo.php'</script>";
		}
    }
    
    function saveTipoPrestamo() //save the new Item
    {
        $query = new query;
        $insert['tipo_prestamo'] = $_POST[tipo_prestamo];
        $insert['interes'] = $_POST[interes];
		if($query->dbInsert($insert,"tipo_prestamo")){ //save in the data base
			//echo "<script>alert('Tipo de prestamo registrado exitosamente');</script>";
			echo "<script>window.location.href='tipoprestamo.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='tipoprestamo.php'</script>";
		}
    }
    
    function listarTipoPrestamos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_tipoprestamo.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este tipo de prestamo?');";
        $resultprestamo = $query->getRows("*","tipo_prestamo");
        $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 5;
        $resultprestamo1 = $query->getRows("*","tipo_prestamo","LIMIT $init , 5");
        $numprestamo = count($resultprestamo1);
        if($numprestamo > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Tipo prestamo</th>
                <th>Interes</th>
                <th>Modificar</th>
                <th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultprestamo1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$value["tipo_prestamo"].'</td>
				  <td>'.$value["interes"].'</td>
                  
                  <td><a href="tipoprestamo.php?accion=modificar&id='.$value["id_tipo_prestamo"].'" title="Modificar Tipo Prestamo"><img src="images/edit.gif"></a></td>
                  <td><a href="tipoprestamo.php?accion=delete&id='.$value["id_tipo_prestamo"].'" onClick="'.$confirm.'" title="Eliminar tipo prestamo"><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
            $list .= paging::navigation(count($resultprestamo),"tipoprestamo.php",5);
        } else $list = '<div>No existen Tipos de prestamos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'tipoprestamo.php?accion=registro\'">';
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
            $template->SetParameter('contenido',$this->listarTipoPrestamos());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarTipoPrestamo());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarTipoPrestamo());
        }
		$template->SetParameter('pie',navigation::showpie());
        
		return $template->Display();
	}
}
