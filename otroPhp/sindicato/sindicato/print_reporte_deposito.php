<?php
require_once('lib/includeLibs.php');
require_once('class/print_reporte_deposito.class.php');

$class = new print_prestamo;
switch ($_REQUEST['accion'])
{
     case 'listarReporte':
	    echo $class -> DiasReporte();
        exit();
	break;
	 
}
echo $class->Display();
?>