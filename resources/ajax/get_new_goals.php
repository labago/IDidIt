<?php
include('../../functions.php');

$count = $_GET['count'];

$db->db_connect();

$query = "SELECT * 
		FROM  `Goal`
		ORDER BY `Date Posted` DESC"; 

$result = $db->db_query($query);

$new_count = $db->db_num_rows($result);

if($new_count > $count)
{
	$diff = $new_count - $count;
	$count = 0;
	while($row = $db->db_fetch_row($result))
	{
		if($count != $diff)
		{
			echo '<div class="stream-goal">';
				echo '<a href="goal.php?id='.$row[8].'"><h2>'.$row[0]."</h2></a>";
				echo '<img src="'.$row[4].'">';
			echo '</div>';
			echo '<div class="space"></div>';
			$count = $count + 1;
		}
		else
		{
			break;
		}
	}
}
?>
