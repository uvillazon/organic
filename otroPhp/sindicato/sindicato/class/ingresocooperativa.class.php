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
		$template->SetTemplate('html/form_ingresocooperativa.html');
		$hoy=date("Y-m-d");
		$template->SetParameter('descripcion','');
        $template->SetParameter('monto_tipo_ingreso','0.00');
		//$template->SetParameter('monto_tipo_ingresoa','0.00');
        $template->SetParameter('fecha_registro_saldo',$hoy);
        $template->SetParameter('accion','saveTipoIngreso');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoIngreso(){
        $query = new query;
        $tipoingreso = $query -> getRow("*","saldo","where id_saldo = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_ingresocooperativa.html');
       
       $template->SetParameter('descripcion',$tipoingreso["descripcion"]);
        $template->SetParameter('monto_tipo_ingreso',$tipoingreso["saldo_tipo_bs"]);
		//$template->SetParameter('monto_tipo_ingresoa',$tipoingreso["saldo_tipo_dolar"]);
        $template->SetParameter('fecha_registro_saldo',$tipoingreso["fecha_registro_saldo"]);
        
		$template->SetParameter('accion','saveUpdateTipoIngreso&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteTipoIngreso(){
        $query = new query;
        if($query->dbDelete("saldo","WHERE id_saldo = ".$_GET['id']))
            //echo "<script>alert('saldo de ingreso elminado exitosamente')</script>";
        echo "<script>window.location.href='ingresocooperativa.php'</script>";
	}
    
    function saveUpdateTipoIngreso() //save the new Item
    {
        $query = new query;
        $update['descripcion'] = $_POST['descripcion'];
        $update['saldo_tipo_bs'] = $_POST['monto_tipo_ingreso'];   
		  //$update['saldo_tipo_dolar'] = $_POST['monto_tipo_ingresoa'];        
		$update['fecha_registro_saldo'] = $_POST['fecha_registro_saldo'];        
		
		if($query->dbUpdate($update,"saldo","where id_saldo = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de ingreso modificado exitosamente');</script>";
			echo "<script>window.location.href='ingresocooperativa.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='ingresocooperativa.php'</script>";
		}
    }
    
    function saveTipoIngreso() //save the new Item
    {
        $query = new query;
        $insert['descripcion'] = $_POST[descripcion];
        $insert['saldo_tipo_bs'] = $_POST[monto_tipo_ingreso];
		$insert['saldo_tipo_dolar'] = "0.00";
		$insert['fecha_registro_saldo'] = $_POST[fecha_registro_saldo];
		
		$insert['tipo_saldo'] = "cooperativa";
		if($query->dbInsert($insert,"saldo")){ //save in the data base
			//echo "<script>alert('Tipo de ingreso registrado exitosamente');</script>";
			echo "<script>window.location.href='ingresocooperativa.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='ingresocooperativa.php'</script>";
		}
    }
    
    function listarTipoIngresos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_tipocooperativa.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este ingreso?');";
           
		//$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resultingreso1 = $query->getRows("*","saldo","where tipo_saldo='cooperativa'");
        
		$numingreso = count($resultingreso1);
        if($numingreso > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Descripcion</th>
				 <th>Monto Bs.</th>
                  <th>Fecha registro</th>
                
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
                
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$value["descripcion"].'</td>
				  <td>'.$value["saldo_tipo_bs"].'</td>
				   <td>'.$value["fecha_registro_saldo"].'</td>
				 
                  <td><a href="ingresocooperativa.php?accion=modificar&id='.$value["id_saldo"].'" title="Modificar saldo "><img src="images/edit.gif"></a></td>
                  <td><a href="ingresocooperativa.php?accion=delete&id='.$value["id_saldo"].'" onClick="'.$confirm.'" title="Eliminar saldo"><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
      //      $list .= paging::navigation(count($resultingreso),"ingresocooperativa.php",20);
        } else $list = '<div>No existen saldos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'ingresocooperativa.php?accion=registro\'">';
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
