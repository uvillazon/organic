<?php
require_once('lib/includeLibs.php');
require_once('class/imprimirReciboahorro.class.php');

$class = new imprimirRecibo;

echo $class->Display();
?>