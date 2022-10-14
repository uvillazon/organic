<?php
require_once('lib/includeLibs.php');
require_once('class/socio.class.php');

$class = new socio;
switch ($_REQUEST['accion'])
{
    case 'saveSocio':
	    $class -> saveSocio();
	break;
    case 'saveUpdateSocio':
	    $class -> saveUpdateSocio();
	break;
    case 'delete':
	    $class -> deleteSocio();
	break;
    /*case 'showMontos':
	    echo $class -> mostrarMontos();
        exit();
	break;*/
}
echo $class->Display();
?>