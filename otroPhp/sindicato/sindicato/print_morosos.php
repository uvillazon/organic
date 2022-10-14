<?php
require_once('lib/includeLibs.php');
require_once('class/print_morosos.class.php');

$class = new print_morosos;
switch ($_REQUEST['accion'])
{
     case 'listarReporte':
	    echo $class -> DiasReporte();
        exit();
	break;
	 
}
echo $class->Display();
?>