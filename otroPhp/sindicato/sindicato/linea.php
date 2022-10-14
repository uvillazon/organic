<?php
require_once('lib/includeLibs.php');
require_once('class/linea.class.php');

$class = new linea;
switch ($_REQUEST['accion'])
{
    case 'saveLinea':
	    $class -> saveLinea();
	break;
    case 'saveUpdateLinea':
	    $class -> saveUpdateLinea();
	break;
    case 'delete':
	    $class -> deleteLinea();
	break;
}
echo $class->Display();
?>