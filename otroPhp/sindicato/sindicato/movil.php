<?php
require_once('lib/includeLibs.php');
require_once('class/movil.class.php');

$class = new movil;
switch ($_REQUEST['accion'])
{
	case 'buscarSocio':
	    echo $class -> buscarSocio();
        exit();
	break;
    case 'saveMovil':
	    $class -> saveMovil();
	break;
    case 'saveUpdateMovil':
	    $class -> saveUpdateMovil();
	break;
	case 'saveUpdateAhorro':
	    $class -> saveUpdateAhorro();
	break;
    case 'delete':
	    $class -> deleteMovil();
	break;
}
echo $class->Display();
?>