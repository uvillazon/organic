<?php
require_once('lib/includeLibs.php');
require_once('class/chofer.class.php');

$class = new chofer;
switch ($_REQUEST['accion'])
{
    case 'saveChofer':
	    $class -> saveChofer();
	break;
    case 'saveUpdateChofer':
	    $class -> saveUpdateChofer();
	break;
    case 'delete':
	    $class -> deleteChofer();
	break;
}
echo $class->Display();
?>