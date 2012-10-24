<?php
include("functions.php");

$crypt = $_COOKIE['user'];
change_log_out_status_fb($crypt, "true");

setcookie('user', '', time()-10000);


echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">'; 
?>