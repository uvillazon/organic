<?php
class tipotransaccion
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
	function registrarTipoTransaccion(){
		$template = new template;
		$template->SetTemplate('html/form_tipotransaccion.html');
		$template->SetParameter('transaccion','');
        $template->SetParameter('monto_transaccion','');
		$template->SetParameter('radio','<input name="estado" type="checkbox" checked value="Activo"/><label>Linea 132</label> <input type="checkbox" value="Inactivo"/><label>Linea 131</label>');
        $template->SetParameter('accion','saveTipoTransaccion');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoTransaccion(){
        $query = new query;
        $tipotransaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = ".$_GET[id]);
		$tener = $query -> getRow("*","tener","where id_tipo_transaccion = ".$_GET[id]);
		$template = new template;
		$template->SetTemplate('html/form_tipotransaccion.html');
		$template->SetParameter('transaccion',$tipotransaccion["transaccion"]);
        $template->SetParameter('monto_transaccion',$tipotransaccion["monto_transaccion"]);
		$check1 = "";
        $check2 = "";
        if($tener['estado'] == "Activo"){
            $check1 = "checked";
             } elseif($tener['estado'] == "Inactivo"){
            $check2 = "checked";
            //echo "<script>Show('showFechaFin');</script>";
        }
        $template->SetParameter('radio',"<input ".$check1." name=\"tipo\" id=\"tipo\" type=\"checkbox\" checked value=\"2\" /><label>Linea 132</label> <input ".$check2." name=\"tipo\" id=\"tipo\" type=\"checkbox\" value=\"1\"/><label>Linea 131</label>");

        $template->SetParameter('accion','saveUpdateTipoTransaccion&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    
    function deleteTipoTransaccion(){
        $query = new query;
        if($query->dbDelete("tipo_transaccion","WHERE id_tipo_transaccion = ".$_GET['id']))
            //echo "<script>alert('Tipo de transaccion elminado exitosamente')</script>";
        echo "<script>window.location.href='tipotransaccion.php'</script>";
	}
    
    function saveUpdateTipoTransaccion() //save the new Item
    {
        $query = new query;
        $update['transaccion'] = $_POST['tipo_transaccion'];
        $update['monto_transaccion'] = $_POST['monto_transaccion'];        
		if($query->dbUpdate($update,"tipo_transaccion","where id_tipo_transaccion = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de transaccion modificado exitosamente');</script>";
			echo "<script>window.location.href='tipotransaccion.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='tipotransaccion.php'</script>";
		}
    }
    
    function saveTipoTransaccion() //save the new Item
    {
        $query = new query;
        $insert['transaccion'] = $_POST[tipo_transaccion];
        $insert['monto_transaccion'] = $_POST[monto_transaccion];
	
		if($query->dbInsert($insert,"tipo_transaccion")){ //save in the data base
			$id_tipo_transaccion = $query->getRow("id_tipo_transaccion","tipo_transaccion","where transaccion = '".$insert['transaccion']."' and monto_transaccion = '".$insert['monto_transaccion']."'");
			
			$insert2['id_linea'] = "2";
       // $linea = $query->getRow("linea","linea","where id_linea = ".$insert2['id_linea']);
			$insert2['id_tipo_transaccion'] = $id_tipo_transaccion['id_tipo_transaccion'];
			
		$insert2['estado'] = $_POST[estado];
		if($query->dbInsert($insert2,"tener")){
             echo "<script>alert('Tipo de transaccion registrado exitosamente');</script>";
			echo "<script>window.location.href='tipotransaccion.php'</script>";
		  
                }
              
		
		else{ //error
                //echo "<script>alert('Error en el registro de ');</script>";
                echo "<script>window.location.href='tipotransaccion.php'</script>";
            }
        }
  }
    
    
    function listarTipoTransaccion() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_tipotransaccion.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar este tipo de transaccion?');";
        $resulttransaccion = $query->getRows("*","tipo_transaccion");
        $init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 10;
        $resulttransaccion1 = $query->getRows("*","tipo_transaccion","LIMIT $init , 10");
        
		$numtransaccion = count($resulttransaccion1);
        if($numtransaccion > 0) {
            $list ='<table border = "1"><thead><tr>
                <th>Tipo transaccion</th>
                <th>Monto</th>
				<th>Linea 131</th>
				<th>Linea 132</th>
                <th>Modificar</th>
                </tr></thead>';
            //<th>Eliminar</th>
              
	    $x = 0;
            foreach ($resulttransaccion1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
				//prueba de linea y monto
				 $tener = $query -> getRow("*","tener","where id_linea = '1' and id_tipo_transaccion = ".$value['id_tipo_transaccion']);
				 $tener2 = $query -> getRow("*","tener","where id_linea = '2' and id_tipo_transaccion = ".$value['id_tipo_transaccion']);
				 //fin prueba
				 
				$list .= '<tbody><tr '.$par.'>
                  <td>'.$value["transaccion"].'</td>
				  <td>'.$value["monto_transaccion"].'</td>
                  <td>'.$tener["estado"].'</td>
				   <td>'.$tener2["estado"].'</td>
                  
                  <td><a href="tipotransaccion.php?accion=modificar&id='.$value["id_tipo_transaccion"].'" title="Modificar Tipo Transaccion"><img src="images/edit.gif"></a></td>
                  </tr></tbody>';
            }
	     //<td><a href="tipotransaccion.php?accion=delete&id='.$value["id_tipo_transaccion"].'" onClick="'.$confirm.'" title="Eliminar tipo transaccion"><img src="images/delete.gif"></a></td>
                 
            $list.='</table>';
            $list .= paging::navigation(count($resulttransaccion),"tipotransaccion.php",10);
        } else $list = '<div>No existen Tipos de transacciones registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'tipotransaccion.php?accion=registro\'">';
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
            $template->SetParameter('contenido',$this->listarTipoTransaccion());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarTipoTransaccion());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarTipoTransaccion());
        }
		$template->SetParameter('pie',navigation::showpie());
        
		return $template->Display();
	}
}
