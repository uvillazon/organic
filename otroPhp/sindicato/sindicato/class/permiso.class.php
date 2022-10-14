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
		$template->SetTemplate('html/form_permiso_falta.html');
		$template->SetParameter('transaccion','');
        $template->SetParameter('monto_transaccion','');
		$template->SetParameter('radio','<input name="estado" type="checkbox" checked value="Activo"/><label>Linea 132</label> <input type="checkbox" value="Inactivo"/><label>Linea 131</label>');
        $template->SetParameter('accion','saveTipoTransaccion');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    function modificarTipoTransaccion(){
        $query = new query;
       // $tipotransaccion = $query -> getRow("*","tipo_transaccion","where id_tipo_transaccion = ".$_GET[id]);
		 $movil = $query -> getRow("*","movil","where id_movil = ".$_GET[id]);
        $movilpermitido = $query -> getRow("*","movil_permitido","where id_movil_permitido = ".$_GET[id]);
        
		$pertenece = $query -> getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
		$template = new template;
		$template->SetTemplate('html/form_permiso_falta.html');
		$template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) \" size=\"8\" value=\"".$socio['num_licencia']."\">");
        //$template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','movil.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\" value=\"".$socio['num_licencia']."\">");
        
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
        $template->SetParameter('lineas',$soloNum[0]);
		$template->SetParameter('numeroMovil',$soloNum[1]);
		
		$check1 = "";
        $check2 = "";
       if($movilpermitido['concepto'] == "normal"){
            $check1 = "checked";
        } elseif($movilpermitido['concepto'] == "permitido"){
            $check2 = "checked";
        }
        $template->SetParameter('radio','<input name="tipoChofer" type="radio" '.$check1.' value="normal"/><label>Sin Autorizacion</label> <input name="tipoChofer" type="radio" '.$check2.' value="permitido"/><label>Autorizado</label>');
		
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
		     $hoy = date('Y-m-d');
		   $update['concepto'] = $_POST[tipoChofer];
        $update['fecha_permiso'] = $hoy;
             
		if($query->dbUpdate($update,"movil_permitido","where id_movil_permitido = ".$_GET['id'])){ //save in the data base
			//echo "<script>alert('Tipo de transaccion modificado exitosamente');</script>";
			echo "<script>alert('La autorizacion fue realizada con exito');</script>";
         	echo "<script>window.location.href='permiso.php'</script>";
		}
		else{ //error
			echo "<script>alert('Error en el registro');</script>";
			echo "<script>window.location.href='permiso.php'</script>";
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
		$template->SetTemplate('html/lista_permiso.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $resultmovil1 = $query->getRows("*","movil","order by id_movil");
        $nummovil = count($resultmovil1);
        if($nummovil > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Linea</th>
                <th>Numero de movil</th>
                <th>Socio</th>                 
			   <th>Autorizacion</th>
                <th>Fecha autorizacion</th>
                <th>Modificar</th>
                </tr></thead>';
            //<th>Eliminar</th>
              
	    $x = 0;
          foreach ($resultmovil1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $pertenece = $query->getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$value['id_movil']);
                
				$permitido = $query->getRow("concepto, fecha_permiso","movil_permitido","where id_movil_permitido = ".$value['id_movil']);
                $socio = $query->getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
                //$socio = $query->getRow("*","socio","where id_socio = 1");
                $nombreCompleto = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
                $linea = $query -> getRow("linea","linea","where id_linea = ".$value['id_linea']);
                $idTipoIngreso = $query->getRow("id_tipo_ingreso","tipo_ingreso","where tipo_ingreso = 'Cambio de Nombre'");
                
				/*Ingreso para ..........
				 <th>Monto cancelado</th>
				$monto = $query -> getRow("monto_ingreso_dolar","ingreso i, pertenece p","where i.id_socio = ".$socio['id_socio']." and i.id_tipo_ingreso = ".$idTipoIngreso['id_tipo_ingreso']." and p.id_socio = i.id_socio and p.id_movil = ".$value['id_movil']);
				<td>'.$monto['monto_ingreso_dolar'].'$</td>
*/                
				$soloNum = split("_",$value['num_movil']);
                $list .= '<tbody><tr '.$par.'>
                  <td>'.$linea['linea'].'</td>                  
				  <td>'.$soloNum[1].'</td>
				  <td>'.$nombreCompleto.'</td>
                  
                  <td>'.$permitido["concepto"].'</td>
				  <td>'.$permitido["fecha_permiso"].'</td>
                  <td><a href="permiso.php?accion=modificar&id='.$value["id_movil"].'" title="Modificar autorizacion"><img src="images/edit.gif"></a></td>
                  </tr></tbody>';
            }
	      //<td><a href="movil.php?accion=delete&id='.$value["id_movil"].'" onClick="'.$confirm.'" title="Eliminar movil"><img src="images/delete.gif"></a></td>
                
            $list.='</table>';
           // $list .= paging::navigation(count($resultmovil),"movil.php",20);
        } else $list = '<div>No existen moviles registrados</div>';
//        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'tipotransaccion.php?accion=registro\'">';
 //       $template->SetParameter('add',$buttonAdd);
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
