<?php
require_once('lib/includeLibs.php');
require_once('class/print_reporte_socio1.class.php');

$class = new print_socio;

echo $class->Display();
?>