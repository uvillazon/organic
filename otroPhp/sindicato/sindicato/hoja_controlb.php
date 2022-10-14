<?php
require_once('lib/includeLibs.php');
require_once('class/hoja_controlb.class.php');

$class = new hoja_control;
switch ($_REQUEST['accion'])
{
    case 'buscarMovil':
	    echo $class -> buscarMovil();
        exit();
	break;
    case 'buscarChofer':
	    echo $class -> buscarChofer();
        exit();
	break;
    case 'filtroFecha':
	    echo $class -> filtroFecha();
        exit();
	break;
    case 'saveHoja':
	    $class -> saveHoja();
	break;
    case 'recibir':
	    $class -> recibirHoja();
	break;
    case 'saveUpdateHoja':
	    $class -> saveUpdateHoja();
	break;
    case 'delete':
	    $class -> deleteHoja();
	break;
}
echo $class->Display();
?>