<?php
data_connect();


function check_crypt_user($crypt){


	$query = "SELECT * 
	FROM  `Users` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = mysql_query($query);

	if(mysql_num_rows($result) != 0){
	return false;  
	}  
	return true;
  
}

function gen_rand_hex(){
	srand((double)microtime()*1000000);

	$decnumber = rand(0, 16777215);

	$colorcode = dechex($decnumber);

	return $colorcode;
}

function add_user($fname, $lname, $pass, $email){

	$crypt = gen_rand_hex();  
	while(!check_crypt_user($crypt)) {  
	$crypt = gen_rand_hex();
	} 

	$query = "INSERT INTO `ididit`.`Users` (
			`First Name` ,
			`Last Name` ,
			`Email` ,
			`Password`,
			`Crypt`
			)
			VALUES (
			'$fname', '$lname', '$email', '$pass', '$crypt'
			);";

	mysql_query($query);

	return $crypt;
}

function data_connect() {
  
$host = "data.justdidthat.com"; 
$user = "jlane09"; 
$pass = "counter";  
$db = "ididit";

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
    
mysql_select_db($db) or die ("Unable to select database!");    
}

function fetch_user_info($crypt){
  
$query = "SELECT * 
FROM  `Users` 
WHERE  `Crypt` LIKE  '$crypt'
LIMIT 0 , 30";  
  
$result = mysql_query($query);
$row = mysql_fetch_row($result);

$info = array();

array_push($info, $row[0]);
array_push($info, $row[1]);
array_push($info, $row[2]);
array_push($info, $row[3]);
array_push($info, $row[4]);

return $info;
}





?>