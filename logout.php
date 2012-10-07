<?php
setcookie('user', '', time()-10000);
header('Location: index.php');
?>