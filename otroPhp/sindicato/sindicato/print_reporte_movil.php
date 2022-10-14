<?php
require_once('lib/includeLibs.php');
require_once('class/print_reporte_movil.class.php');

$class = new print_movil;

echo $class->Display();
?>