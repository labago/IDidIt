<?php
include("functions.php");
setcookie('user', '', time()-10000);
setcookie('fbs_'.$facebook->getAppId(), '', time()-100, '/', 'domain.com');

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">'; 
?>