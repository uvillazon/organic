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
		$template->SetTemplate('html/form_egreso.html');
		$hoy=date("Y-m-d");
		$template->SetParameter('descripcion','');
        $template->SetParameter('monto_tipo_ingreso','');
		$template->SetParameter('monto_tipo_ingresoa','');
        $template->SetParameter('fecha_registro_saldo',$hoy);
        $template->SetParameter('accion','saveTipoIngreso');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoIngreso(){
        $query = new query;
        $tipoingreso = $query -> getRow("*","egreso_lubricante","where id_egreso = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_egreso.html');
       
       $template->SetParameter('descripcion',$tipoingreso["concepto"]);
        $template->SetParameter('monto_tipo_ingreso',$tipoingreso["monto_egreso"]);
		$template->SetParameter('monto_tipo_ingresoa',$tipoingreso["numero"]);
        $template->SetParameter('fecha_registro_saldo',$tipoingreso["fecha"]);
        
		$template->SetParameter('accion','saveUpdateTipoIngreso&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteTipoIngreso(){
        $query = new query;
        if($query->dbDelete("egreso_lubricante","WHERE id_egreso = ".$_GET['id']))
            //echo "<script>alert('saldo de ingreso elminado exitosamente')</script>";
        echo "<script>window.location.href='egreso.php'</script>";
	}
    
    function saveUpdateTipoIngreso() //save the new Item
    {
        $query = new query;
        $update['concepto'] = $_POST['descripcion'];
        $update['monto_egreso'] = $_POST['monto_tipo_ingreso'];   
		  $update['numero'] = $_POST['monto_tipo_ingresoa'];        
		$update['fecha'] = $_POST['fecha_registro_saldo'];        
		
		if($query->dbUpdate($update,"egreso_lubricante","where id_egreso = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de ingreso modificado exitosamente');</script>";
			echo "<script>window.location.href='egreso.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='egreso.php'</script>";
		}
    }
    
    function saveTipoIngreso() //save the new Item
    {
        $query = new query;
        $insert['concepto'] = $_POST[descripcion];
        $insert['monto_egreso'] = $_POST[monto_tipo_ingreso];
		$insert['numero'] = $_POST[monto_tipo_ingresoa];
		$insert['fecha'] = $_POST[fecha_registro_saldo];
		$insert['tipo'] = $_POST[tipo];
		
		$insert['monto_dolar'] = "0";
		if($query->dbInsert($insert,"egreso_lubricante")){ //save in the data base
			//echo "<script>alert('Tipo de ingreso registrado exitosamente');</script>";
			echo "<script>window.location.href='egreso.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='egreso.php'</script>";
		}
    }
    
    function listarTipoIngresos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_egreso.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este saldo?');";
        //$resultingreso = $query->getRows("*","saldo");
  $resultingreso1 = $query->getRows("*","egreso_lubricante");
             
	  // $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $numingreso = count($resultingreso1);
        if($numingreso > 0) {
            $list ='<table border = "1">
              <thead><tr>
			     <th>Numero</th>
                <th>Recibo</th>
				
				<th>Detalle</th>
				 <th>Monto Bs.</th>
                  <th>Fecha registro</th>
				   <th>Tipo egreso</th>
                
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
                $tipoeg ='';
				if($value['tipo'] == 0)
				{ $tipoeg="Lubricantes";}
				 else{
				 				  			  
				$tipoeg="Lavadero";}
				
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$value["id_egreso"].'</td>
				 <td>'.$value["numero"].'</td>
				 <td>'.$value["concepto"].'</td>
				  <td>'.$value["monto_egreso"].'</td>
				   <td>'.$value["fecha"].'</td>
				   <td>'.$tipoeg.'</td>
				 
                  <td><a href="egreso.php?accion=modificar&id='.$value["id_egreso"].'" title="Modificar  "><img src="images/edit.gif"></a></td>
                  <td><a href="egreso.php?accion=delete&id='.$value["id_egreso"].'" onClick="'.$confirm.'" title="Eliminar "><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resultingreso),"egreso.php",20);
        } else $list = '<div>No existen datos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'egreso.php?accion=registro\'">';
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
