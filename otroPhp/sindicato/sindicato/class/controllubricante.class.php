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
		$template->SetTemplate('html/form_controllubricante.html');
		$hoy=date("Y-m-d");
		$template->SetParameter('descripcion','');
        $template->SetParameter('monto_tipo_ingreso','0.00');
		$template->SetParameter('monto_tipo_ingresoa','0.00');
        $template->SetParameter('fecha_registro_saldo',$hoy);
		$template->SetParameter('monto_a','0.00');
        $template->SetParameter('monto_b','0.00');
        $template->SetParameter('monto_c','0.00');
        $template->SetParameter('monto_d','0.00');
        $template->SetParameter('monto_e','0.00');
        $template->SetParameter('monto_f','0.00');
        
        $template->SetParameter('accion','saveTipoIngreso');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoIngreso(){
        $query = new query;
        $tipoingreso = $query -> getRow("*","control_lubricante","where id_control_lubricante = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_controllubricante.html');
       
       $template->SetParameter('descripcion',$tipoingreso["nombre"]);
        $template->SetParameter('monto_tipo_ingreso',$tipoingreso["monto_tipo_lubricante"]);
		$template->SetParameter('monto_tipo_ingresoa',$tipoingreso["aporte"]);
        $template->SetParameter('fecha_registro_saldo',$tipoingreso["fecha"]);
        $template->SetParameter('monto_a',$tipoingreso["preciocomprabidon"]);
        $template->SetParameter('monto_b',$tipoingreso["preciocomprafiltro"]);
        $template->SetParameter('monto_c',$tipoingreso["preciocompralubricante"]);
        $template->SetParameter('monto_d',$tipoingreso["precioventabidon"]);
        $template->SetParameter('monto_e',$tipoingreso["precioventafiltro"]);
        $template->SetParameter('monto_f',$tipoingreso["precioventalubricante"]);
        
		$template->SetParameter('accion','saveUpdateTipoIngreso&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteTipoIngreso(){
        $query = new query;
        if($query->dbDelete("control_lubricante","WHERE id_control_lubricante = ".$_GET['id']))
            //echo "<script>alert('saldo de ingreso elminado exitosamente')</script>";
        echo "<script>window.location.href='controllubricante.php'</script>";
	}
    
    function saveUpdateTipoIngreso() //save the new Item
    {
        $query = new query;
        $update['nombre'] = $_POST['descripcion'];
        $update['monto_tipo_lubricante'] = $_POST['monto_tipo_ingreso'];   
		  $update['aporte'] = $_POST['monto_tipo_ingresoa'];        
		$update['fecha'] = $_POST['fecha_registro_saldo'];        
		  $update['preciocomprabidon'] = $_POST['monto_a'];        
		$update['preciocomprafiltro'] = $_POST['monto_b'];        
		$update['preciocompralubricante'] = $_POST['monto_c'];        
		$update['precioventabidon'] = $_POST['monto_d'];        
		$update['precioventafiltro'] = $_POST['monto_e'];        
		$update['precioventalubricante'] = $_POST['monto_f'];        
		
		if($query->dbUpdate($update,"control_lubricante","where id_control_lubricante = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de ingreso modificado exitosamente');</script>";
			echo "<script>window.location.href='controllubricante.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='controllubricante.php'</script>";
		}
    }
    
    function saveTipoIngreso() //save the new Item
    {
        $query = new query;
        $insert['nombre'] = $_POST[descripcion];
        $insert['monto_tipo_lubricante'] = $_POST[monto_tipo_ingreso];
		$insert['aporte'] = $_POST[monto_tipo_ingresoa];
		$insert['fecha'] = $_POST[fecha_registro_saldo];
		
		$insert['preciocomprabidon'] = $_POST[monto_a];
		$insert['preciocomprafiltro'] = $_POST[monto_b];
		$insert['preciocompralubricante'] = $_POST[monto_c];
		$insert['precioventabidon'] = $_POST[monto_d];
		$insert['precioventafiltro'] = $_POST[monto_e];
		$insert['precioventalubricante'] = $_POST[monto_f];
		$insert['tipo'] = $_POST[tipo];
		
		
		if($query->dbInsert($insert,"control_lubricante")){ //save in the data base
			//echo "<script>alert('Tipo de ingreso registrado exitosamente');</script>";
			echo "<script>window.location.href='controllubricante.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='controllubricante.php'</script>";
		}
    }
    
    function listarTipoIngresos() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_controllubricante.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este saldo?');";
        //$resultingreso = $query->getRows("*","saldo");
  $resultingreso1 = $query->getRows("*","control_lubricante");
             
	  // $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $numingreso = count($resultingreso1);
        if($numingreso > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Descripcion</th>
				 <th>Monto Asignado.</th>
                 <th>Monto Aporte</th>
				 <th>Tipo Precio</th>
				 
                 <th>Costo compra bidon</th>
				 <th>Costo compra filtro</th>
				 <th>costo compra total</th>
				<th>Precio venta bidon</th>
				 <th>Precio venta filtro</th>
				 <th>Precio venta total</th>
				  				 
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
                $tipoeg ='';
				if($value['tipo'] == 0)
				{ $tipoeg="Lubricantes";}
				 else{
				 				  			  
				$tipoeg="Lavadero";}
				
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$value["nombre"].'</td>
				  <td>'.$value["monto_tipo_lubricante"].'</td>
				  <td>'.$value["aporte"].'</td>
                  <td>'.$tipoeg.'</td>
                                    
				  <td>'.$value["preciocomprabidon"].'</td>
				  <td>'.$value["preciocomprafiltro"].'</td>
				  <td>'.$value["preciocompralubricante"].'</td>
				  <td>'.$value["precioventabidon"].'</td>
				  <td>'.$value["precioventafiltro"].'</td>
				  <td>'.$value["precioventalubricante"].'</td>
				   				  
				  <td>'.$value["fecha"].'</td>
				 
                  <td><a href="controllubricante.php?accion=modificar&id='.$value["id_control_lubricante"].'" title="Modificar saldo "><img src="images/edit.gif"></a></td>
                  <td><a href="controllubricante.php?accion=delete&id='.$value["id_control_lubricante"].'" onClick="'.$confirm.'" title="Eliminar saldo"><img src="images/delete.gif"></a></td>
                  </tr></tbody>';
            }
            $list.='</table>';
           // $list .= paging::navigation(count($resultingreso),"controllubricante.php",20);
        } else $list = '<div>No existen datos registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'controllubricante.php?accion=registro\'">';
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
