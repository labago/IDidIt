<?php
include('../../functions.php');

$comment = $_GET['c'];

$goal = $_GET['g'];

$info = fetch_user_goal($goal);

if(strlen($comment) > 0)
{
	add_comment(htmlentities(strip_tags($comment), ENT_QUOTES), $_COOKIE['user'], $goal);
	notify_commenters($goal, $_COOKIE['user']);

	if($_COOKIE['user'] != $info[5])
		new_notification($info[5], $_COOKIE['user'], 'Comment', $goal);
}

$comments = get_comments($info[8]);

foreach ($comments as $comment) 
{
	echo '<div class="comment">';

	$db->db_connect();

	$query = "SELECT * 
	FROM `Users` 
	WHERE `Crypt` LIKE '".$comment[2]."'
	LIMIT 0 , 30";

	$row = $db->db_fetch_row($db->db_query($query));

	$name = $row[0]." ".$row[1];

		echo '<a href="profile.php?id='.$row[4].'">'.html_entity_decode($name).'</a> said: <br>';
		echo html_entity_decode($comment[0]);
	echo '</div>';
	echo '<div class="space"></div>';
}
?>