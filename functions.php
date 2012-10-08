<?php
data_connect();


function check_crypt_user($crypt)
{
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

function gen_rand_hex()
{
	srand((double)microtime()*1000000);

	$decnumber = rand(0, 16777215);

	$colorcode = dechex($decnumber);

	return $colorcode;
}

function add_user($fname, $lname, $pass, $email)
{

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

function data_connect() 
{
  
$host = "data.justdidthat.com"; 
$user = "jlane09"; 
$pass = "counter";  
$db = "ididit";

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
    
mysql_select_db($db) or die ("Unable to select database!");    
}

function fetch_user_info($crypt)
{
  
$query = "SELECT * 
FROM  `Users` 
WHERE  `Crypt` LIKE  '$crypt'
LIMIT 0 , 30";  
  
$result = mysql_query($query);
$row = mysql_fetch_row($result);

$info = array();

foreach($row as $row_item)
{
	array_push($info, $row_item);	
}

return $info;
}

function fetch_user_goals($crypt)
{
  
$query = "SELECT * 
FROM  `Goal` 
WHERE  `Crypt of User` LIKE  '$crypt'
LIMIT 0 , 30";  
  
$result = mysql_query($query);

$goals = array();

while($row = mysql_fetch_row($result))
{
	array_push($goals, $row);	
}

return $goals;
}

function add_new_goal($title, $date_s, $date_e, $pic, $desc, $crypt)
{

	$query =  "INSERT INTO `ididit`.`Goal` (
			`Title` ,
			`Date Started` ,
			`Date Achieved` ,
			`Description` ,
			`Picture` ,
			`Crypt of User`
			)
			VALUES (
			'$title', '$date_s', '$date_e', '$desc', '$pic', '$crypt'
			);";

	mysql_query($query);
}

function gen_pic_name($original){

	$end = substr($original, (strlen($original) - 3), 3);

	$name = gen_rand_hex();

	if(file_exists("uploads/".$name.".".$end)){
		return gen_pic_name($original);
	}
	else{
		return $name.".".$end;
	}

}

function change_user_pic($crypt, $path){
  
	 $query = "UPDATE  `ididit`.`Users` SET  
	`Picture` =  '$path'
	WHERE  `Users`.`Crypt` =  '$crypt' 
	LIMIT 1 ;";

	mysql_query($query);
}

function update_user_info($fname, $lname, $email, $password, $crypt)
{
	$query = "UPDATE `ididit`.`Users` SET `First Name` = '$fname',
			`Last Name` = '$lname',
			`Email` = '$email',
			`Password` = '$password' WHERE `Users`.`Crypt` = '$crypt' LIMIT 1 ;";

	mysql_query($query);
}





?>