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

$result = $db->db_query($query);

$no_account = true;

if($db->db_num_rows($result) > 0)
{
	$no_account = false;	
	$row = $db->db_fetch_row($result);
	$crypt = $row[4];
}

if($no_account)
	$crypt = add_user($fname, $lname, $password, $email, $pic, $id);
else
	update_user_facebook_info($fname, $lname, $password, $email, $pic, $id, $crypt);


setcookie("user", $crypt, time()+2592000);

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
?>