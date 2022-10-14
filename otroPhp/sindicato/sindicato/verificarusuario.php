<?php
session_start();
include("funciones/funciones.php");
$res=VerificarPassword($_REQUEST['Login'],$_REQUEST['Password']);
if($res==5){
	header("Location: index.php?error=mal");
	exit;
}
if($res=="administrador"){
	$id=ObtenerID($_REQUEST['Login']);
	$_SESSION['id']=$id;
	$_SESSION['tipo']=1;
	header("Location: index.php");
	exit;
}
if($res=="coperativa"){
	$id=ObtenerID($_REQUEST['Login']);
	$_SESSION['id']=$id;
	$_SESSION['tipo']=2;
	header("Location: index.php");
	exit;
}
if($res=="superadministrador"){
	$id=ObtenerID($_REQUEST['Login']);
	$_SESSION['id']=$id;
	$_SESSION['tipo']=3;
	header("Location: index.php");
	exit;
}
if($res=="auxiliar"){
	$id=ObtenerID($_REQUEST['Login']);
	$_SESSION['id']=$id;
	$_SESSION['tipo']=4;
	header("Location: index.php");
	exit;
}





?>