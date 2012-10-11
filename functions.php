<?php
data_connect();
record_visit();
include("facebook_checks.php");


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
	$number = substr(md5(rand()), 0, 8); 

	return $number;
}

function add_user($fname, $lname, $pass, $email, $picture = "", $id = "")
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
			`Crypt`,
			`Picture`,
			`Facebook ID`
			)
			VALUES (
			'$fname', '$lname', '$email', '$pass', '$crypt', '$picture', '$id'
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

function fetch_user_info_token($token)
{
  
$query = "SELECT * 
FROM  `Users` 
WHERE  `Facebook ID` LIKE  '$token'
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

function gen_pic_name($original)
{

	$end = substr($original, (strlen($original) - 3), 3);

	$name = gen_rand_hex();

	if(file_exists("uploads/".$name.".".$end)){
		return gen_pic_name($original);
	}
	else{
		return $name.".".$end;
	}

}

function change_user_pic($crypt, $path)
{
  
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

function record_visit() 
{
	$ip_new = VisitorIP();
	$page_name = find_full_page_name();

	$query = "SELECT * 
	FROM  `Visits` 
	WHERE  `IP` LIKE  '$ip_new'
	AND  `Page Name` LIKE  '$page_name'
	LIMIT 0 , 30";

	$result = mysql_query($query);

	$visited = false;
	if($row = mysql_fetch_row($result))
	{
		$visited = true;

		$ip = $row[0];
		$times = $row[2];
		$user = $row[3];
		$page_name = $row[4]; 

		$new_times = $times + 1;
		if(strlen($user) == 0)
		{
			$new_user = $_SESSION['email'];
		}
		else 
		{
			$new_user = $user;  
		}
	}


	if($visited)
	{
		$date = date('Y-m-d g-i-s', time()+(60*60*3));  
		$query = "UPDATE  `ididit`.`Visits` SET  `Most Recent` =  '$date',
		`Times` =  '$new_times',
		`User` =  '$new_user' WHERE  
		`Visits`.`IP` =  '$ip' AND   
		`Visits`.`Times` =$times AND  
		`Visits`.`User` =  '$user' AND
		`Visits`.`Page Name` = '$page_name' LIMIT 1 ;";
	}
	else 
	{
	  
		$user = $_COOKIE['user'];  

		if(strlen($user) == 0)
		{
			$user = "Guest";  
		}

		$date = date('Y-m-d g-i-s', time()+(60*60*3));  

		$location_info = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?format=json&key=b49cd6eb6da4c0e429300fd010f02061db560d5b38c2526481abe89bc73f8b3b&ip=".$ip_new));
		
		$country = $location_info->{'countryName'};
		$city = $location_info->{'cityName'};
		$zip = $location_info->{'zipCode'};

		$query = "INSERT INTO  `ididit`.`Visits` (
		`IP` ,
		`Most Recent` ,
		`Times` ,
		`User`,
		`Page Name`,
		`Country`,
		`City`,
		`Zip`
		)
		VALUES (
		'$ip_new', 
		'$date',  '1',  '$user', '$page_name', '$country', '$city','$zip'
		);";
	}

	mysql_query($query);
}

// method to find users IP address
function VisitorIP()
{ 
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
	    $TheIp=$_SERVER['HTTP_X_FORWARDED_FOR'];
	else $TheIp=$_SERVER['REMOTE_ADDR'];

	return trim($TheIp);
}

// returns the whole page name(this means includes arguments) but minus the domain name
function find_full_page_name() 
{

	$url = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
	  
	$array = explode("/", $url);  
	$full_name = "";

	$length = sizeof($array);
	$start = 1;

	while($start < $length)
	{
		$full_name = $full_name."/".$array[$start];
		$start += 1;    
	}

	return $full_name;
}
?>