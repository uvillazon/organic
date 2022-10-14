<?php
require_once('lib/includeLibs.php');
require_once('class/print_repo_socio.class.php');

$class = new print_socio;
switch ($_REQUEST['accion'])
{
     case 'listarReporte':
	    echo $class -> DiasReporte();
        exit();
	break;
	 
}
echo $class->Display();
?>