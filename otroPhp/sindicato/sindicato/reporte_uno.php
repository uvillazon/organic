<?php
require_once('lib/includeLibs.php');
require_once('class/reporte_uno.php');


$class = new reporte_uno;
switch ($_REQUEST['accion'])
{
    case 'buscarReporte':
	    echo $class -> buscarReporte();
        exit();
	break;
   
}
echo $class->Display();
?>