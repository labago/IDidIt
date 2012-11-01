<?php
include("resources/db.php");
include("facebook_checks.php");
record_visit();


$db = new db_functions();


function check_email($email)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM `Users` 
	WHERE `Email` LIKE '$email'
	LIMIT 0 , 30";

	$result = $db->db_query($query);

	if($row = $db->db_fetch_row($result))
		return false;
	else
		return true;

}

function is_logged_out_fb($crypt)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Users` 
	WHERE  `Crypt` LIKE  '$crypt'
	AND  `Force Logout` LIKE  'true'
	LIMIT 0 , 30";

	$result = $db->db_query($query);

	if($row = $db->db_fetch_row($result))
		return true;
	else
		return false;
}

function change_log_out_status_fb($crypt, $status)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "UPDATE `ididit`.`Users` SET `Force Logout` = '$status' WHERE `Users`.`Crypt` = '$crypt';";

	$db->db_query($query);
}


function check_crypt($crypt, $type)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `$type` 
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

function add_user($fname, $lname, $pass, $email, $picture = "", $id = "", $access_token)
{

	$db = new db_functions();
    $db->db_connect();

	$crypt = gen_rand_hex();  
	while(!check_crypt($crypt, 'Users')) {  
	$crypt = gen_rand_hex();
	} 

	$query = "INSERT INTO `ididit`.`Users` (
			`First Name` ,
			`Last Name` ,
			`Email` ,
			`Password`,
			`Crypt`,
			`Picture`,
			`Facebook ID`,
			`Access`
			)
			VALUES (
			'$fname', '$lname', '$email', '$pass', '$crypt', '$picture', '$id', '$access_token'
			);";

	$db->db_query($query);


	return $crypt;
}

function update_user_facebook_info($fname, $lname, $pass, $email, $picture = "", $id = "", $crypt, $access_token)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "UPDATE `ididit`.`Users` SET `First Name` = '$fname',
			`Last Name` = '$lname',
			`Email` = '$email',
			`Picture` = '$picture',
			`Access` = '$access_token',
			`Facebook ID` = '$id' WHERE `Users`.`Crypt` = '$crypt' LIMIT 1 ;";

	$db->db_query($query);
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

	$info = array();

	if($row = $db->db_fetch_row($result))
	{
		foreach($row as $row_item)
		{
			array_push($info, $row_item);	
		}
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

function add_new_goal($title, $date_s, $date_e, $pic, $desc, $crypt_of_user, $category, $witness, $youtube, $org = '', $prof = '', $school = '')
{

	$db = new db_functions();
    $db->db_connect();

	$crypt = gen_rand_hex();  
	while(!check_crypt($crypt, 'Goal')) {  
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
			`Youtube`,
			`School`,
			`Orginization`,
			`Company`
			)
			VALUES (
			'$title', '$date_s', '$date_e', '$desc', '$pic', '$crypt_of_user','$category', '$crypt', '$witness', '$youtube', '$school', '$org', '$prof'
			);";

	$db->db_query($query);

}

function gen_pic_name($original)
{
	$components = explode(".", $original);

	$end = $components[(sizeof($components)-1)];

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
	while(!check_crypt($crypt, 'Comments')) {  
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
	ORDER BY `Date Posted` DESC
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

function gen_large_detailed_goal($goal)
{
	echo '<div class="goal">';
		echo '<div class="goal_column">';
			echo '<a href="goal.php?id='.$goal[8].'"><h1>'.html_entity_decode($goal[0]).'</h1></a><p>'.html_entity_decode($goal[3]).'</p>';
			echo '<div class="witness">';
				echo '<h2>Witnesses</h2>';

			if($goal[6] != '')
			{
				$witnesses = explode(',', $goal[6]);

				foreach ($witnesses as $witness) 
				{
					$info = fetch_user_info_token($witness);

					if(sizeof($info) > 0)
						echo "<a href='profile.php?id=".$info[4]."'><img src='http://graph.facebook.com/".$witness."/picture?type=square' alt=''></a>";
					else
						echo "<img src='http://graph.facebook.com/".$witness."/picture?type=square' alt=''>";
				}
			}
			else
			{
					echo "No Witness Mentioned";
			}
			echo "</div>";
			echo '<div class="witness">';
			echo '<h2>Congratulators</h2>';

			if($goal[9] != '')
			{
				$congradulator = explode(',', $goal[9]);

				foreach ($congradulator as $congrats) {
					$info = fetch_user_info($congrats);

					echo "<a href='profile.php?id=".$info[4]."'><img src='".$info[5]."' alt=''></a>";
				}
			}
			else
			{
				echo "No Congratulators Yet";
			}
		echo "</div>";
		echo '</div>';
		echo '<div class="goal-column-wrapper">';
		if($goal[4] != '')
		{
			echo '<div class="goal_column_double">';
				echo '<img src="'.$goal[4].'">';
			echo '</div>';
			echo '<div class="goal_column_double">';
				echo '<img src="'.$goal[4].'">';
			echo '</div>';
		}
		echo '<div class="info">';
			echo '<h3>Stats</h3>';
			if($goal[9] != '')
				echo 'Nods: <span id="'.$goal[8].'">'.sizeof(explode(",",$goal[9]))."</span>";
			else
				echo 'Nods: <span id="'.$goal[8].'">0'."</span>";
			if($goal[6] != '')
				echo 'Validators: '.sizeof(explode(",",$goal[6]));
			else
				echo 'Validators: 0';
		echo '</div>';
		echo '</div>';
		if(isset($_COOKIE['user']) && (isset($_GET['id'])) && (strpos($goal[9], $_COOKIE['user']) === false) && ($_GET['id'] != $_COOKIE['user']))
		{
			$user = "'".$_COOKIE['user']."'";
			$goal_crypt = "'".$goal[8]."'";
			echo '<div class="congrats-button"><a onclick="congrats('.$user.', '.$goal_crypt.', this); return false;" href="">Congratulate</a></div>';
		}

		$album_info = fetch_album($goal[8]);
		if(isset($_COOKIE['user']) && ((!isset($_GET['id'])) || $_GET['id'] == $_COOKIE['user']))
		{
			if(!isset($album_info[1]))
				echo '<a href="add_album.php?g='.$goal[8].'">Add Album</a>';
			else
				echo '<a href="add_album.php?g='.$goal[8].'&id='.$album_info[6].'&mode=edit">Edit Album</a>';
		}
		else if(isset($album_info[1]))
			echo '<a href="view_album.php?g='.$goal[8].'">View Album</a>';
		echo '</div>';
		echo '<div class="space"></div>';
}

function get_notifications_html($crypt)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM `Notifications` 
	WHERE `Crypt of User` LIKE '$crypt'
	LIMIT 0 , 30";

	$result = $db->db_query($query);

	while($row = $db->db_fetch_row($result))
	{
		if($row[3] == 'false')
		{
			switch ($row[1]) 
			{
				case 'Congrats':
					$user_info = fetch_user_info($row[5]);
					echo '<tr class="notification">';
						echo '<td><a href="goal.php?id='.$row[4].'&n=true">'.$user_info[0].' Congradulated You!</a></td>';
					echo '</tr>';
					break;

				case 'Comment':
					$user_info = fetch_user_info($row[5]);
					echo '<tr class="notification">';
						echo '<td><a href="goal.php?id='.$row[4].'&n=true">'.$user_info[0].' Commented on your Achievement</a></td>';
					echo '</tr>';

				case 'Reply':
					$user_info = fetch_user_info($row[5]);
					$other_user_info = fetch_user_info($row[2]);
					echo '<tr class="notification">';
						echo '<td><a href="goal.php?id='.$row[4].'&n=true">'.$user_info[0].' also commented on '.$other_user_info[0]."'s Achievement</a></td>";
					echo '</tr>';
				
				default:
					break;
			}
		}
	}
}

function kill_notifications($object)
{
	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM `Notifications` 
	WHERE `Crypt of Object` LIKE '$object'";

	$result = $db->db_query($query);

	while($row = $db->db_fetch_row($result))
	{
		$crypt = $row[6];

		$query = "UPDATE  `ididit`.`Notifications` SET  `Seen` =  'true'
		WHERE  `Notifications`.`Crypt` =  '$crypt' LIMIT 1 ;";

		$db->db_query($query);
	}
}

function new_notification($user, $interact, $type, $object)
{
	$db = new db_functions();
    $db->db_connect();

	$crypt = gen_rand_hex();  
	while(!check_crypt($crypt, 'Notifications')) {  
	$crypt = gen_rand_hex();
	}

	$query = "INSERT INTO `ididit`.`Notifications` (
		`Date` ,
		`Type` ,
		`Crypt of User` ,
		`Seen` ,
		`Crypt of Object` ,
		`Crypt of Issuing User`,
		`Crypt`
		)
		VALUES (

		CURRENT_TIMESTAMP , '$type', '$user', 'false', '$object', '$interact', '$crypt'
		);";

	$db->db_query($query);
}

function notify_commenters($goal, $user)
{

	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Comments` 
	WHERE  `Crypt of Goal` LIKE  '$goal'
	LIMIT 0 , 30";

	$result = $db->db_query($query);

	$users = array();

	while($row = $db->db_fetch_row($result))
	{
		if(!in_array($row[2], $users) && $row[2] != $user)
			array_push($users, $row[2]);
	}

	foreach($users as $not_user) 
	{
		new_notification($not_user, $user, 'Reply', $goal);
	}
}


function delete_album($crypt)
{
	$db = new db_functions();
    $db->db_connect();

    $query = "DELETE FROM `ididit`.`Album` WHERE `Album`.`Crypt` = '$crypt' LIMIT 1";

	$db->db_query($query);    	
}


function add_album($locals, $fbs, $fb_albums, $user, $goal, $crypt)
{
	$temp = fetch_album($goal);

	if(isset($temp[0]))
	{
		$crypt = $temp[0];
		$date = $temp[1];
		delete_album($crypt);
	}

	$db = new db_functions();
    $db->db_connect();

    if(!isset($date))
		$date = date('Y-m-d g-i-s', time()+(60*60*3)); 

	$query = "INSERT INTO `ididit`.`Album` (
	`Crypt` ,
	`Date Added` ,
	`Local Pictures` ,
	`Crypt of Goal` ,
	`Crypt of User`,
	`FB Pictures`,
	`FB Album ID's`
	)
	VALUES (
	'$crypt', 
	'$date', '$locals', '$goal', '$user', '$fbs', '$fb_albums'
	);";

	$db->db_query($query);
}

function fetch_album($crypt)
{
 	$db = new db_functions();
    $db->db_connect();

	$query = "SELECT * 
	FROM  `Album` 
	WHERE  `Crypt of Goal` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = $db->db_query($query);	

	$info = array();

	if($row = $db->db_fetch_row($result))
	{
		foreach($row as $row_item)
		{
			array_push($info, $row_item);	
		}
	}

	return $info;
}

function make_thumb($src, $dest, $desired_width) {

  /* read the source image */
  $source_image = imagecreatefromjpeg($src);
  $width = imagesx($source_image);
  $height = imagesy($source_image);
  
  /* find the "desired height" of this thumbnail, relative to the desired width  */
  $desired_height = floor($height * ($desired_width / $width));
  
  /* create a new, "virtual" image */
  $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
  
  /* copy source image at a resized size */
  imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
  
  /* create the physical thumbnail image to its destination */
  imagejpeg($virtual_image, $dest);
} 
?>

