<?php
include('../db.php');

$email = $_GET['email'];

$db->db_connect();

$query_check = "SELECT * 
FROM  `Users` 
WHERE  `Email` LIKE  '$email'
LIMIT 0 , 30";

$result_check = $db->db_query($query_check);

if(mysql_num_rows($result_check) == 0){
echo 'true';
}
else{
echo 'false';
}
?>
