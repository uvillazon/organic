<?php
require_once('lib/includeLibs.php');
require_once('class/saldoingreso.class.php');

$class = new tipoingreso;
switch ($_REQUEST['accion'])
{
    case 'saveTipoIngreso':
	    $class -> saveTipoIngreso();
	break;
    case 'saveUpdateTipoIngreso':
	    $class -> saveUpdateTipoIngreso();
	break;
    case 'delete':
	    $class -> deleteTipoIngreso();
	break;
}
echo $class->Display();
?>