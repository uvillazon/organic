<?php
require_once('lib/includeLibs.php');
require_once('class/atraso_trabajo.class.php');

$class = new atraso_asamblea;
switch ($_REQUEST['accion'])
{
    case 'saveAtraso':
	    $class -> saveAtraso();
	break;
}
echo $class->Display();
?>