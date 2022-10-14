<?php
require_once('lib/includeLibs.php');
require_once('class/tipotransaccion.class.php');

$class = new tipotransaccion;
switch ($_REQUEST['accion'])
{
    case 'saveTipoTransaccion':
	    $class -> saveTipoTransaccion();
	break;
    case 'saveUpdateTipoTransaccion':
	    $class -> saveUpdateTipoTransaccion();
	break;
    case 'delete':
	    $class -> deleteTipoTransaccion();
	break;
}
echo $class->Display();
?>