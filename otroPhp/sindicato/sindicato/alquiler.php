<?php
require_once('lib/includeLibs.php');
require_once('class/alquiler.class.php');

$class = new alquiler;
switch ($_REQUEST['accion'])
{
    case 'saveAlquiler':
	    $class -> saveAlquiler();
	break;
    case 'saveUpdateAlquiler':
	    $class -> saveUpdateAlquiler();
	break;
    case 'delete':
	    $class -> deleteAlquiler();
	break;
}
echo $class->Display();
?>