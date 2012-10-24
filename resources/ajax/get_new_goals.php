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
	$float = false;
	$small = true;
	$break = false;
	while($row = $db->db_fetch_row($result))
	{
		if($count != $diff)
		{
			if($small)
			{
				for ($i=0; $i < 2; $i++) 
				{ 
					if(!$float)
						echo '<div class="stream-goal-small-wrapper">';

					gen_small_goal($row, $float);

					if($float)
					{
						echo '<div style="display: block; clear: both;"></div>';
						echo '</div>';
						echo '<div class="space"></div>';
					}

					$float = !$float;

					if($i != 1 && !($row = $db->db_fetch_row($result)))
					{
						break 2;
					}
				}
			}
			else
			{
				gen_large_goal($row);
			}

			$small = !$small;
			$count = $count + 1;
		}
		else
		{
			break;
		}
	}
}
?>