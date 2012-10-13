<?php
include('../../functions.php');

$count = $_GET['count'];

$query = "SELECT * 
		FROM  `Goal`"; 

$result = mysql_query($query);

$new_count = mysql_num_rows($result);

if($new_count > $count)
{
	while($row = mysql_fetch_row($result))
	{
		if($count == 0)
		{
			echo '<div class="stream-goal">';
				echo '<a href="profile.php?id='.$row[5].'"><h2>'.$row[0]."</h2></a>";
				echo '<img src="'.$row[4].'">';
			echo '</div>';
			echo '<div class="space"></div>';
		}
		else
		{
			$count = $count - 1;
		}
	}
}
?>
