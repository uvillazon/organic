<?php
session_start();
//Unsetallofthe
session_unset();
//Finally,destroy
session_destroy();
header("Location: index.php");
exit;
?>