<?php
class movil
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
	function registrarMovil(){
		$query = new query;
		$template = new template;
		$template->SetTemplate('html/form_movil_socio.html');
        $template->SetParameter('titulo',"REGISTRO DE MOVIL PARA SOCIO YA REGISTRADO");
        $template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','movil.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\">");
		$lineas = '<select name="linea" id="select">';
        $lineasBd = $query -> getRows("*","linea");
        foreach($lineasBd as $key=>$value) {
            $lineas .= '<option value="'.$value['id_linea'].'">Linea '.$value['linea'].'</option>';
        }
        $lineas .= '</select>';
        $template->SetParameter('lineas',$lineas);
		$template->SetParameter('nombreSocio','');
		$template->SetParameter('numeroMovil',"<input name=\"movil\" type=\"text\" id=\"movil\" onKeyPress=\"return numeral(event)\" size=\"5\">");
		$template->SetParameter('numeroPlaca','');
        $montoIngreso = $query->getRow("monto_tipo_dolar","tipo_ingreso","where tipo_ingreso = 'Cambio de Nombre'");
		$template->SetParameter('accion','saveMovil');
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
	 function saveMovil() //save the new Item
    {
        $query = new query;
        $insert['id_linea'] = $_POST[linea];
        $linea = $query->getRow("linea","linea","where id_linea = ".$insert['id_linea']);
        $insert['num_movil'] = $linea['linea']."_".$_POST[movil];
        $insert['fecha_registro_movil'] = date("Y-m-d");
        
        $resti = $query->getRows("*","movil","WHERE num_movil = '".$insert['num_movil']."' and id_linea = ".$insert['id_linea']."");
        if(count($resti) == 0) {
            if($query->dbInsert($insert,"movil")){ //save in the data base
                $id_movil = $query->getRow("id_movil","movil","where id_linea = ".$insert['id_linea']." and num_movil = '".$insert['num_movil']."' and fecha_registro_movil = '".$insert['fecha_registro_movil']."'");
                $insert2['id_socio'] = $_POST[idSocio];
                $insert2['id_movil'] = $id_movil['id_movil'];
                $insert2['fecha_pertenece'] = date("Y-m-d");
                $insert2['placa_movilidad'] = $_POST[placa];
                $tipoSocio = $query->getRow("tipo_socio","socio","where id_socio = ".$insert2['id_socio']);
                $estado = "";
                if($tipoSocio['tipo_socio'] == "Propietario")
                    $estado = "Activo";
                $insert2['estado_funcion'] = $estado;
                if($query->dbInsert($insert2,"pertenece"))
				
				{
				$insert3['id_linea'] = $_POST[linea];
				$insert3['num_movil'] = $linea['linea']."_".$_POST[movil];
				$insert3['fecha_registro_permiso'] = date("Y-m-d");
                
				$insert3['concepto'] = "normal";
				$insert3['detalle'] = "ninguno";
				   if($query->dbInsert($insert3,"movil_permitido")){
                        echo "<script>alert('Movil registrado exitosamente');</script>";
                        echo "<script>window.location.href='movil.php'</script>";
                    }
                   
                else{ //error
                    echo "<script>alert('Error en el registro de pertenece');</script>";
                    echo "<script>window.location.href='movil.php'</script>";
                }
				
				}
            }
           
        }
        echo "<script>window.location.href='movil.php'</script>";
    }
    function modificarMovil(){
        $query = new query;
        $movil = $query -> getRow("*","movil","where id_movil = ".$_GET[id]);
        $pertenece = $query -> getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
		$template = new template;
		$template->SetTemplate('html/form_movil_socio.html');
		$template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','movil.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\" value=\"".$socio['num_licencia']."\">");
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
        $template->SetParameter('titulo','CAMBIO DE NOMBRE');
        $template->SetParameter('lineas',$soloNum[0]);
		$template->SetParameter('numeroMovil',$soloNum[1]);
		$template->SetParameter('numeroPlaca',$pertenece['placa_movilidad']);
        $tipoIngreso = $query->getRow("id_tipo_ingreso, monto_tipo_dolar","tipo_ingreso","where tipo_ingreso = 'Cambio de Nombre'");
        //$ingreso = $query -> getRow("*","ingreso","where id_socio = ".$socio['id_socio']." and id_tipo_ingreso = ".$tipoIngreso['id_tipo_ingreso']);
		//$template->SetParameter('montoIngreso',$ingreso['monto_ingreso_dolar']);
        /*$template->SetParameter('montoIngreso',"<input name=\"ingreso_movil_nuevo\" type=\"text\" id=\"ingreso_movil_nuevo\" size=\"7\" value=\"".$tipoIngreso['monto_tipo_dolar']."\">");*/
        $template->SetParameter('accion','saveUpdateMovil&id='.$_GET['id']);
        $template->SetParameter('boton','MODIFICAR');
		return $template->Display();
	}
    function modificarAhorro(){
        $query = new query;
        $movil = $query -> getRow("*","movil","where id_movil = ".$_GET[id]);
        $pertenece = $query -> getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$_GET[id]);
        $socio = $query -> getRow("*","socio","where id_socio = ".$pertenece['id_socio']);
		$template = new template;
		$template->SetTemplate('html/form_movil_ahorro.html');
		$template->SetParameter('licencia',"<input name=\"licencia\" type=\"text\" id=\"licencia\" onblur=\"if(document.mframe.licencia.value > 0) {ajax('nombreSocio','movil.php?accion=buscarSocio&licencia=' + document.mframe.licencia.value, '');}\" size=\"8\" value=\"".$socio['num_licencia']."\">");
        $nombreSocio = $socio['nombre_socio']." ".$socio['apellido1_socio']." ".$socio['apellido2_socio'];
		$template->SetParameter('nombreSocio',$nombreSocio);
       
        $soloNum = split("_",$movil['num_movil']);
        $template->SetParameter('titulo','REGISTRO DE AHORRO INICIAL');
        $template->SetParameter('lineas',$soloNum[0]);
		$template->SetParameter('numeroMovil',$soloNum[1]);
		$template->SetParameter('numeroPlaca',$pertenece['placa_movilidad']);
        //$tipoIngreso = $query->getRow("id_tipo_ingreso, monto_tipo_dolar","tipo_ingreso","where tipo_ingreso = 'Cambio de Nombre'");
        $template->SetParameter('fecha_ahorro','2009-02-27');
		        
	   $template->SetParameter('accion','saveUpdateAhorro&id='.$_GET['id']);
        $template->SetParameter('boton','REGISTRAR');
		return $template->Display();
	}
    
	
    function buscarSocio(){
        $query = new query;
        $nombreSocio = $query->getRow("id_socio, nombre_socio, apellido1_socio, apellido2_socio","socio","where num_licencia = ".$_GET['licencia']);
        $nombreCompleto = $nombreSocio['nombre_socio']." ".$nombreSocio['apellido1_socio']." ".$nombreSocio['apellido2_socio'];
		return "<span>".$nombreCompleto."</span><input type=\"hidden\" name=\"idSocio\" value=\"".$nombreSocio['id_socio']."\">";
	}
    
    function deleteMovil(){
        $query = new query;
        if($query->dbDelete("movil","WHERE id_movil = ".$_GET['id']))
            echo "<script>alert('Movil elminado exitosamente')</script>";
        echo "<script>window.location.href='movil.php'</script>";
	}
    
    function saveUpdateMovil() //save the new Item
    {
        $query = new query;
        $update['id_socio'] = $_POST[idSocio];
        $update['placa_movilidad'] = $_POST[placa];
        if($query->dbUpdate($update,"pertenece","where id_movil = ".$_GET['id']))
		{
		       echo "<script>alert('La modificacion fue realizada con exito');</script>";
                echo "<script>window.location.href='movil.php'</script>";
            
        }
        else{ //error
            echo "<script>alert('Error en la modificacion');</script>";
            echo "<script>window.location.href='movil.php'</script>";
        }
        echo "<script>window.location.href='movil.php'</script>";
    }
    
   function saveUpdateAhorro() //save the new Item
    {
        $query = new query;
        $update['ahorro_inicial'] = $_POST['deposito'];
        $update['fecha_ahorro_inicial'] =$_POST['fecha_ahorro'];
		
        if($query->dbUpdate($update,"movil","where id_movil = ".$_GET['id']))
		{
		       echo "<script>alert('El registro del ahorro fue realizado exitosamente');</script>";
                echo "<script>window.location.href='movil.php'</script>";
            
        }
        else{ //error
            echo "<script>alert('Error en la modificacion');</script>";
            echo "<script>window.location.href='movil.php'</script>";
        }
        echo "<script>window.location.href='movil.php'</script>";
    }
    
    
    function listarMovil() //list for default the all items
	{
		$template = new template;
		$template->SetTemplate('html/lista_movil.html'); //sets the template for this function
		
		//DataBase Conexion//
		$query = new query;
        $confirm="javascript:return confirm('Esta seguro de eliminar movil?');";
        $resultmovil = $query->getRows("*","movil order by num_movil");
        //$init = (($_GET['page'] == "" ? 1 : $_GET['page']) - 1) * 20;
        $resultmovil1 = $query->getRows("*","movil","order by id_movil");
        $nummovil = count($resultmovil1);
        if($nummovil > 0) {
            $list ='<table border = "1">
              <thead><tr>
                <th>Linea</th>
                <th>Numero de movil</th>
                <th>Socio</th>                 
			   <th>Numero de placa</th>
                <th>Cambio de nombre</th>
                <th>Registrar Ahorro inicial</th>
               <th>Ahorro inicial</th>
               <th>Fecha ahorro inicial</th>
                
				<th>Eliminar</th>
              </tr></thead>';
            $x = 0;
            foreach ($resultmovil1 as $key=>$value) {
                $x++;
                if(($x%2)==0)
                    $par = "class='TdAlt'";
                else $par = "";
                $pertenece = $query->getRow("id_socio, placa_movilidad","pertenece","where id_movil = ".$value['id_movil']);
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
                  
                  <td>'.$pertenece["placa_movilidad"].'</td>
                  <td><a href="movil.php?accion=modificar&id='.$value["id_movil"].'" title="Modificar movil"><img src="images/edit.gif"></a></td>
                  <td><a href="movil.php?accion=ahorro&id='.$value["id_movil"].'" title="Registrar ahorro"><img src="images/plan.gif"></a></td>
                  <td>'.$value["ahorro_inicial"].'</td>
                  <td>'.$value["fecha_ahorro_inicial"].'</td>
                  
				  </tr></tbody>';
            }
	      //<td><a href="movil.php?accion=delete&id='.$value["id_movil"].'" onClick="'.$confirm.'" title="Eliminar movil"><img src="images/delete.gif"></a></td>
                
            $list.='</table>';
           // $list .= paging::navigation(count($resultmovil),"movil.php",20);
        } else $list = '<div>No existen moviles registrados</div>';
        $buttonAdd = '<input type="button" value="Nuevo" onclick="window.location.href=\'movil.php?accion=registro\'">';
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
            $template->SetParameter('contenido',$this->listarMovil());
        }
        if($_GET['accion']=="registro"){
            $template->SetParameter('contenido',$this->registrarMovil());
        }
        if($_GET['accion']=="modificar"){
            $template->SetParameter('contenido',$this->modificarMovil());
        }
      if($_GET['accion']=="ahorro"){
            $template->SetParameter('contenido',$this->modificarAhorro());
        }

		$template->SetParameter('pie',navigation::showpie());
		return $template->Display();
	}
}
?>
