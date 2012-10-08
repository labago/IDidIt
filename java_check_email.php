<?php
include('functions.php');

$email = $_GET['email'];

$query_check = "SELECT * 
FROM  `Users` 
WHERE  `Email` LIKE  '$email'
LIMIT 0 , 30";

$result_check = mysql_query($query_check);

if(mysql_num_rows($result_check) == 0){
echo 'true';
}
else{
echo 'false';
}
?>
