<?php
require_once('lib/includeLibs.php');
require_once('class/prestamo_si.class.php');

$class = new prestamo;
switch ($_REQUEST['accion'])
{
	case 'buscarSocio':
	    echo $class -> buscarSocio();
        exit();
	break;
	case 'buscarChofer':
	    echo $class -> buscarChofer();
        exit();
	break;
    case 'savePrestamo':
	    $class -> savePrestamo();
	break;
    case 'saveUpdatePrestamo':
	    $class -> saveUpdatePrestamo();
	break;
    case 'delete':
	    $class -> deletePrestamo();
	break;
}
echo $class->Display();
?>