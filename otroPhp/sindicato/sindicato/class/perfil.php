<?php
class perfil
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
	function perfil(){
		$template=new template;
		$template->SetTemplate('html/perfil.html');
		$query=new query;
		$id=$_SESSION['id'];
		$row=$query->getRow("*","usuario","Where id_usuario=$id");
		$template->SetParameter('username',$row['username']);
		$template->SetParameter('ci',$row['ci_usuario']);
		$template->SetParameter('nombre',$row['nombre_usuario']);
		$template->SetParameter('ape1',$row['apellido1_usuario']);
		$template->SetParameter('ape2',$row['apeliido2_usuario']);
		$template->SetParameter('direccion',$row['direccion_usuario']);
		$template->SetParameter('telefono',$row['telefono_usuario']);
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
	function updateperfil(){
		$query=new query;
		$cliente['nombre_usuario']=strtoupper($_POST['name']);
		$cliente['apellido1_usuario']=strtoupper($_POST['ape1']);
		$cliente['apeliido2_usuario']=strtoupper($_POST['ape2']);
		$cliente['direccion_usuario']=$_POST['direccion'];
		$cliente['telefono_usuario']=$_POST['telefono'];
		
		$query->dbUpdate($cliente,"usuario","where id_usuario=".$_SESSION['id']);
		echo '<script language="javascript">alert(\'Inserción Exitosa\'); window.location = \'perfil.php\';</script>';
			
	}
	function password(){
		$template=new template;
		$template->SetTemplate('html/password.html');
		$id=$_SESSION['id'];
		$query=new query;
		$row=$query->getRow("*","usuario","where id_usuario=$id");
		$template->SetParameter('password',$row['contrasena']);
		return $template->Display();
	}
	function updatepassword(){
		$query=new query;
		$cliente['contrasena']=MD5($_POST['pass1']);
		
		
		$query->dbUpdate($cliente,"usuario","where id_usuario=".$_SESSION['id']);
		echo '<script language="javascript">alert(\'Inserted Successfully\'); window.location = \'perfil.php\';</script>';
			
	}	
	function Display(){
		$admin=new admin;
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
		if($_GET['opc']==""){
			$template->SetParameter('contenido',$this->perfil());
		}
		if($_GET['opc']=="permisomovil"){
			$template->SetParameter('contenido',$admin->permisomovil());
		}
		if($_GET['opc']=="password"){
			$template->SetParameter('contenido',$this->password());
		}
		return $template->Display();
	}
}
