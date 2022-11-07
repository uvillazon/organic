<?php
require_once('lib/includeLibs.php');
require_once('class/contactos.php');

$class = new contactos;   
echo $class->Display();
?>
