<?php
require_once('lib/includeLibs.php');
require_once('class/tipoprestamo.class.php');

$class = new tipoprestamo;
switch ($_REQUEST['accion'])
{
    case 'saveTipoPrestamo':
	    $class -> saveTipoPrestamo();
	break;
    case 'saveUpdateTipoPrestamo':
	    $class -> saveUpdateTipoPrestamo();
	break;
    case 'delete':
	    $class -> deleteTipoPrestamo();
	break;
}
echo $class->Display();
?>