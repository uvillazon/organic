<?php
require_once('lib/includeLibs.php');
require_once('class/fertilizantes.php');

$class = new fertilizantes;   
echo $class->Display();
?>
