<?php
include("facebook_checks.php");
include("resources/db.php");
record_visit();


$db = new db_functions();


function check_crypt_user($crypt)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Users` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);

	if($db->db_num_rows($result) != 0)
	{
		return false;  
	}  
	return true;
}

function check_crypt_goal($crypt)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Goal` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);

	if($db->db_num_rows($result) != 0)
	{
		return false;  
	}  

	return true;
}

function check_crypt_comment($crypt)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Comments` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);

	if($db->db_num_rows($result) != 0)
	{
		return false;  
	}  

	return true;
}

function gen_rand_hex()
{
	$number = substr(md5(rand()), 0, 10); 

	return $number;
}

function add_user($fname, $lname, $pass, $email, $picture = "", $id = "")
{

	$db = new db_functions();
    $db->db_connect();

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

	$db->db_query($query);


	return $crypt;
}

function fetch_user_info($crypt)
{
 	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Users` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);
	$row = $db->db_fetch_row($result);

	$info = array();

	foreach($row as $row_item)
	{
		array_push($info, $row_item);	
	}


	return $info;
}

function fetch_user_info_token($token)
{
  
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Users` 
	WHERE  `Facebook ID` LIKE  '$token'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);
	$row = $db->db_fetch_row($result);

	$info = array();

	foreach($row as $row_item)
	{
		array_push($info, $row_item);	
	}


	return $info;
}

function fetch_user_goals($crypt)
{
	$db = new db_functions();
    $db->db_connect();
	  
	$query = "SELECT * 
	FROM  `Goal` 
	WHERE  `Crypt of User` LIKE  '$crypt'
	ORDER BY `Date Posted` DESC
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);

	$goals = array();

	while($row = $db->db_fetch_row($result))
	{
		array_push($goals, $row);	
	}


	return $goals;
}

function fetch_user_goal($crypt)
{
	$db = new db_functions();
    $db->db_connect();
  
	$query = "SELECT * 
	FROM  `Goal` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);

	$row = $db->db_fetch_row($result);


	return $row;
}

function is_user_goal($crypt, $user)
{
	$db = new db_functions();
    $db->db_connect();
  
	$query = "SELECT * 
	FROM  `Goal` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);

	$goals = array();

	$row = $db->db_fetch_row($result);

	return $row[5] == $user;

}

function add_new_goal($title, $date_s, $date_e, $pic, $desc, $crypt_of_user, $category, $witness, $youtube)
{

	$db = new db_functions();
    $db->db_connect();

	$crypt = gen_rand_hex();  
	while(!check_crypt_goal($crypt)) {  
	$crypt = gen_rand_hex();
	}

	$query =  "INSERT INTO `ididit`.`Goal` (
			`Title` ,
			`Date Started` ,
			`Date Achieved` ,
			`Description` ,
			`Picture` ,
			`Crypt of User`,
			`Category`,
			`Crypt`,
			`Witness`,
			`Youtube`
			)
			VALUES (
			'$title', '$date_s', '$date_e', '$desc', '$pic', '$crypt_of_user','$category', '$crypt', '$witness', '$youtube'
			);";

	$db->db_query($query);

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
  	$db = new db_functions();
    $db->db_connect();

	 $query = "UPDATE  `ididit`.`Users` SET  
	`Picture` =  '$path'
	WHERE  `Users`.`Crypt` =  '$crypt' 
	LIMIT 1 ;";

	$db->db_query($query);

}

function update_user_info($fname, $lname, $email, $password, $crypt)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "UPDATE `ididit`.`Users` SET `First Name` = '$fname',
			`Last Name` = '$lname',
			`Email` = '$email',
			`Password` = '$password' WHERE `Users`.`Crypt` = '$crypt' LIMIT 1 ;";

	$db->db_query($query);

}

function record_visit() 
{
	$db = new db_functions();
    $db->db_connect();

	$ip_new = VisitorIP();
	$page_name = find_full_page_name();

	$query = "SELECT * 
	FROM  `Visits` 
	WHERE  `IP` LIKE  '$ip_new'
	AND  `Page Name` LIKE  '$page_name'
	LIMIT 0 , 30";

	$result = $db->db_query($query);

	$visited = false;
	if($row = $db->db_fetch_row($result))
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
	  	if(isset($_COOKIE['user']))
			$user = $_COOKIE['user'];  
		else
			$user = '';

		if(strlen($user) == 0)
		{
			$user = "Guest";  
		}

		$date = date('Y-m-d g-i-s', time()+(60*60*3));  

		$location_info = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?format=json&key=b49cd6eb6da4c0e429300fd010f02061db560d5b38c2526481abe89bc73f8b3b&ip=".$ip_new));
		
		@$country = @$location_info->{'countryName'};
		@$city = @$location_info->{'cityName'};
		@$zip = @$location_info->{'zipCode'};
		@$state = @$location_info->{'regionName'};

		$query = "INSERT INTO  `ididit`.`Visits` (
		`IP` ,
		`Most Recent` ,
		`Times` ,
		`User`,
		`Page Name`,
		`Country`,
		`City`,
		`Zip`,
		`State`
		)
		VALUES (
		'$ip_new', 
		'$date',  '1',  '$user', '$page_name', '$country', '$city','$zip', '$state'
		);";
	}

	$db->db_query($query);

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

function add_comment($comment, $crypt_user, $crypt_goal)
{
	$db = new db_functions();
    $db->db_connect();

	$comment = strip_tags($comment);

	$date = date('Y-m-d g-i-s', time()+(60*60*3)); 

	$crypt = gen_rand_hex();  
	while(!check_crypt_comment($crypt)) {  
	$crypt = gen_rand_hex();
	}

	$query = "INSERT INTO `ididit`.`Comments` (
	`Comment` ,
	`Date Posted` ,
	`Crypt of User` ,
	`Crypt of Goal` ,
	`Crypt`
	)
	VALUES (
	'$comment', 
	'$date', '$crypt_user', '$crypt_goal', '$crypt'
	);";

	$db->db_query($query);

}

function get_comments($goal)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM `Comments` 
	WHERE `Crypt of Goal` LIKE '$goal'
	LIMIT 0 , 30";

	$result = $db->db_query($query);

	$comments = array();

	while($row = $db->db_fetch_row($result))
	{
		array_push($comments, $row);
	}


	return $comments;
}

function gen_small_goal($row, $float)
{
	if($float)
		echo '<div class="stream-goal-small" style="float: right;">';
	else
		echo '<div class="stream-goal-small" style="float: left;">';

		echo '<a href="goal.php?id='.$row[8].'"><h2>'.html_entity_decode($row[0])."</h2></a>";
		echo '<img src="'.$row[4].'">';
		echo '<div class="small-space"></div>';
	echo '</div>';
}

function gen_large_goal($row)
{
	echo '<div class="stream-goal">';
		echo '<a href="goal.php?id='.$row[8].'"><h2>'.html_entity_decode($row[0])."</h2></a>";
		echo '<img src="'.$row[4].'">';
		echo '<div class="small-space"></div>';
	echo '</div>';
	echo '<div class="space"></div>';
}

function get_notifications_html($crypt)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM `Goal` 
	WHERE `Crypt of User` LIKE '$crypt'
	LIMIT 0 , 30";

	$result = $db->db_query($query);

	while($row = $db->db_fetch_row($result))
	{
		if(strpos($row[9], ",") || $row[9] != "")
			$congrats = explode(",", $row[9]);
		else
			$congrats = array();

		if(strpos($row[13], ",") || $row[13] != "")
			$congrats_seen = explode(",", $row[13]);
		else
			$congrats_seen = array();

		if(sizeof($congrats) != sizeof($congrats_seen)){
			echo '<tr class="notification">';
				echo '<td><a href="goal.php?id='.$row[8].'&n=true">New Congratulations!</a></td>';
			echo '</tr>';
		}
	}
}

function kill_notification($type, $crypt)
{
	$db = new db_functions();
    $db->db_connect();

    if($type == "Goal")
    {

		$query = "SELECT * 
		FROM `Goal` 
		WHERE `Crypt` LIKE '$crypt'
		LIMIT 0 , 30";

		$result = $db->db_query($query);

		$row = $db->db_fetch_row($result);

		$congrats = $row[9];

		$query = "UPDATE  `ididit`.`Goal` SET  `Congradulators Seen` =  '$congrats'
		WHERE  `Goal`.`Crypt` =  '$crypt' LIMIT 1 ;";

		$db->db_query($query);
	}
}
?>