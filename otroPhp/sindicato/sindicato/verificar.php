<?php
require_once('lib/includeLibs.php');
require_once('class/verificar.php');

$class = new verificar;
if($_GET['action']=="verificarlicencia"){
	echo $class->verificarlicencia();
	exit;
}
if($_GET['action']=="verificarmovil"){
	echo $class->verificarmovil();
	exit;
}
echo $class->Display();
?>