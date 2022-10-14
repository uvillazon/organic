<?php
require_once('lib/includeLibs.php');
require_once('class/control_trabajo.class.php');

$class = new dias_trabajados;
switch ($_REQUEST['accion'])
{
    case 'listarDiasTrabajados':
	    echo $class -> DiasTrabajados();
        exit();
	break;
}
echo $class->Display();
?>