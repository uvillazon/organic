<?php
require_once('lib/includeLibs.php');
require_once('class/no_trabajaron.class.php');

$class = new no_trabajaron;
switch ($_REQUEST['accion'])
{
    case 'filtroFecha':
	    echo $class -> filtroFecha();
        exit();
	break;
    case 'recibir':
	    $class -> recibirHoja($_GET['fechaFiltro']);
	break;
   
    
}
echo $class->Display();
?>