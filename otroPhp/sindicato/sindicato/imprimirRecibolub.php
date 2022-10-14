<?php
require_once('lib/includeLibs.php');
require_once('class/imprimirRecibolub.class.php');

$class = new imprimirRecibo;

echo $class->Display();
?>