<?php
require_once('lib/includeLibs.php');
require_once('class/perfil.php');

$class = new perfil;
if($_GET['action']=="updateperfil"){
	$class->updateperfil();
}
if($_GET['action']=="updatepassword"){
	$class->updatepassword();
}
echo $class->Display();
?>