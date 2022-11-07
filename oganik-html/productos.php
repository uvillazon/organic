<?php
require_once('lib/includeLibs.php');
require_once('class/productos.php');

$class = new productos;   
echo $class->Display();
?>
