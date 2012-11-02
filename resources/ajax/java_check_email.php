<?php
include('../../functions.php');

$email = $_GET['email'];

if(isset($_COOKIE['user']))
	$logged_in_as = fetch_user_info($_COOKIE['user']);

$bypass = false;
if(isset($logged_in_as[2]))
{
	if($logged_in_as[2] == $email)
		$bypass = true;
}

$db->db_connect();

$query_check = "SELECT * 
FROM  `Users` 
WHERE  `Email` LIKE  '$email'
LIMIT 0 , 30";

$result_check = $db->db_query($query_check);

if(mysql_num_rows($result_check) == 0 || $bypass){
echo 'true';
}
else{
echo 'false';
}
?>