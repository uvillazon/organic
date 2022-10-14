<?php
require_once('lib/includeLibs.php');
require_once('class/print_reporte_socio.class.php');

$class = new print_socio;

echo $class->Display();
?>