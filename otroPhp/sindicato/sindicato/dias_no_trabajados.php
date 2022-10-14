<?php
require_once('lib/includeLibs.php');
require_once('class/dias_no_trabajados.class.php');

$class = new dias_no_trabajados;
switch ($_REQUEST['accion'])
{
    case 'listarDiasNoTrabajados':
	    echo $class -> DiasNoTrabajados();
        exit();
	break;
	 case 'saveUpdatePermiso':
	    $class -> saveUpdatePermiso();
	break;
}
echo $class->Display();
?>