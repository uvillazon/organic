<?php
require_once('lib/includeLibs.php');
require_once('class/facturacion.php');

$class = new facturacion;   
echo $class->Display();
?>