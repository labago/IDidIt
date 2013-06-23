<?php
include('functions.php'); 

$user_info = fetch_user_info_token($fb_user);

$token = $user_info[7];
if(!(strlen($token) > 0))
	$token = $facebook->getAccessToken();

$user_profile = $facebook->api('/me', array('access_token' => $token));

$fname = $user_profile['first_name'];
$lname = $user_profile['last_name'];
$email = $user_profile['email'];
$id = $facebook->getUser();
$access_token = $facebook->getAccessToken();
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
{
	$crypt = add_user($fname, $lname, $password, $email, $pic, $id, $access_token);

	$header = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
	$header .= 'From: I Did It <do-not-reply@i-did-it.net>'."\r\n"; 

	$message = "Dear ".$fname.", <br><br>";
	$message .= "Welcome to I Did It, where you can share with the world all the awesome things you have done ";
	$message .= "in your life. Better yet, think of this site as a real time achievement tracker, making sure you will";
	$message .= " never forget the things you have accomplished. Be sure to add as much as you want, but keep in mind ";
	$message .= "that this site is intended only for valuable posts documenting your life. ";

	mail($email, "Welcome!", $message, $header);
}
else
	update_user_facebook_info($fname, $lname, $email, $pic, $id, $crypt, $access_token);


setcookie("user", $crypt, time()+2592000);
change_log_out_status_fb($crypt, "false");

echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
?>