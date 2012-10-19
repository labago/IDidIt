<?php
include('functions.php'); 
$user_profile = $facebook->api('/me', 'GET');

$fname = $user_profile['first_name'];
$lname = $user_profile['last_name'];
$email = $user_profile['email'];
$id = $facebook->getUser();
$password = "changeme";
$pic = "http://graph.facebook.com/".$id."/picture?type=large";

$db->db_connect();

$query = "SELECT * 
FROM  `Users` 
WHERE  `Email` LIKE  '$email'
LIMIT 0 , 30";

$result = mysql_query($query);

$no_account = true;

if(mysql_num_rows($result) > 0)
{
	$no_account = false;	
	$row = mysql_fetch_row($result);
	$crypt = $row[4];
}


if($no_account){

$crypt = add_user($fname, $lname, $password, $email, $pic, $id);

}

setcookie("user", $crypt, time()+2592000);

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
?>