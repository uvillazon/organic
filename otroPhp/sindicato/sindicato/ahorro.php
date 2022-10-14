<?php
require_once('lib/includeLibs.php');
require_once('class/ahorros.class.php');

$class = new ahorro;
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
	  case 'filtroFecha':
	    echo $class -> filtroFecha();
        exit();
	break;
  
	case 'deleteP':
	    $class -> deletePago();
	break;
}
echo $class->Display();
?>