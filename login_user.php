<?php
include("functions.php");

$crypt = $_GET['c'];

change_log_out_status_fb($crypt, "false");
setcookie("user", $crypt, time()+2592000);

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
?>