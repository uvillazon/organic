<?php

switch($_SERVER['HTTP_HOST'])
{
	case 'localhost':
		$_cfg['host'] = '194.195.84.1';
		$_cfg['user'] = 'u726787443_organic';
		$_cfg['pass'] = '5190630cI.c...';
		$_cfg['db'] = 'u726787443_organic';
		break;
	default:
		ini_set("session.cache_expire","180");
		ini_set("session.gc_maxlifetime","3600");
		$_cfg['host'] = 'localhost';
		$_cfg['user'] = 'techicco_webuser';
		$_cfg['pass'] = 'Control$2022';
		$_cfg['db'] = 'techicco_facturasdb';
		break;
}
define('cgf', $_cfg);   // RIGHT - Works OUTSIDE of a class definition.

// mysqli_connect($_cfg['host'],$_cfg['user'],$_cfg['pass']) or die(mysqli_connect_errno());
// $mysqli = new mysqli($_cfg['host'],$_cfg['user'],$_cfg['pass']);

//  mysqli_select_db($mysqli,$_cfg['db']) or die(mysqli_connect_errno());
// 

require_once('template.lib.php');
require_once('query.lib.php');
?>