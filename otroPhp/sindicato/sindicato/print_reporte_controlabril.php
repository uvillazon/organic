<?php
require_once('lib/includeLibs.php');
require_once('class/print_reporte_controlabril.class.php');

$class = new print_falta;
switch ($_REQUEST['accion'])
{
     case 'listarReporte':
	    echo $class -> DiasReporte();
        exit();
	break;
	 
}
echo $class->Display();
?>