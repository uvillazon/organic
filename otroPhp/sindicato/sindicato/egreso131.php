<?php
require_once('lib/includeLibs.php');
require_once('class/egreso131.class.php');

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
	case 'filtroFecha':
	    echo $class -> filtroFecha();
        exit();
	break;
}
echo $class->Display();
?>