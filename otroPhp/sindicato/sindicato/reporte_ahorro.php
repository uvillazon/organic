<?php
require_once('lib/includeLibs.php');
require_once('class/reporte_ahorro.class.php');

$class = new reporte_movil;
switch ($_REQUEST['accion'])
{
    case 'listarReporte':
	    echo $class -> DiasReporte();
        exit();
	break;
	 case 'saveUpdatePermiso':
	    $class -> saveUpdatePermiso();
	break;
}
echo $class->Display();
?>