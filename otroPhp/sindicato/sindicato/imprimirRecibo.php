<?php
require_once('lib/includeLibs.php');
require_once('class/imprimirRecibo.class.php');

$class = new imprimirRecibo;

echo $class->Display();
?>