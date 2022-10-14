<?php
require_once('lib/includeLibs.php');
require_once('class/moroso.class.php');

$class = new moroso;
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
}
echo $class->Display();
?>