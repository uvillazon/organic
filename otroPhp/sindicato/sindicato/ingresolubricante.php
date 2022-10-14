<?php
require_once('lib/includeLibs.php');
require_once('class/ingresolubricante.class.php');

$class = new ingreso;
switch ($_REQUEST['accion'])
{
    case 'buscarMovil':
	    echo $class -> buscarMovil();
        exit();
	break;
    case 'calculo':
	    echo $class -> calculoMontoDias();
        exit();
	break;
    case 'buscarChofer':
	    echo $class -> buscarChofer();
        exit();
	break;
    case 'buscarPago':
	    echo $class -> buscarPago();
        exit();
	break;
    case 'filtroFecha':
	    echo $class -> filtroFecha();
        exit();
	break;
    case 'saveHoja':
	    $class -> saveHoja();
	break;
    
    case 'delete':
	    $class -> deleteHoja();
	break;
}
echo $class->Display();
?>
