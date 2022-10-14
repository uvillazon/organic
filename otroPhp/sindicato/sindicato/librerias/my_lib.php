<?php
    $bandera=true;
	function conectarDB() {
    include("settings.inc.php");
	$link = mysql_connect($db_server,$db_user,$db_pass) or die(sql_error("Error de Conección MYSQL"));
   	mysql_select_db($db_name,$link) or die(sql_error("Existio un error al intentar seleccionar la base de datos"));
	}
	
	function consultaDB($query) {
		$result = mysql_query($query);
		if (!$result) {
		echo"".mysql_error().": ".mysql_error()."<BR>";
		sql_error("Error en la consulta!!");
		$bandera=false;
		return $result;
		}else {
		return $result;
		}
	}
	
	function desconectarDB() {
		mysql_close();
	}


	function sql_error($message) {
        $description ="";
        $error ="PHP Error : $message\n";
        $error.="Message     : $description\n";
        $error.="Date        : ".date("D, F j, Y H:i:s")."\n";
        $error.="IP          : ".getenv("REMOTE_ADDR")."\n";
        $error.="Browser     : ".getenv("HTTP_USER_AGENT")."\n";
        $error.="Referer     : ".getenv("HTTP_REFERER")."\n";
        $error.="PHP Version : ".PHP_VERSION."\n";
        $error.="OS          : ".PHP_OS."\n";
        $error.="Server      : ".getenv("SERVER_SOFTWARE")."\n";
        $error.="Server Name : ".getenv("SERVER_NAME")."\n";
        echo "<b><font size=4 face=Arial>$message</font></b><hr>";
        echo "<pre>$error</pre>";
        exit();
	}
?>
