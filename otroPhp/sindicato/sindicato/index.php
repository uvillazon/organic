<?php
require_once('lib/includeLibs.php');
require_once('class/index.php');

$class = new index;
$clas1= new admin;	
if($_GET['action']=="registermulta"){
	$clas1->registermulta();
}

echo $class->Display();
?>