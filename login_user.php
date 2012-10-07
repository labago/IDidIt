<?php

$crypt = $_GET['c'];

setcookie("user", $crypt, time()+2592000);

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
?>