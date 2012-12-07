<?php include("functions.php"); ?>
<html>
	<title>IDidIt - Achievement</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
			<?php 
			
			// see if the user has a cookie
			if(isset($_COOKIE['user']))
			{
				$goal = $_GET['id'];

				if(isset($_GET['n']) && $_GET['n'] == 'true')
					kill_notifications($goal);

				// if a comment was posted, post it
				if(isset($_POST['submit']))
				{
					$comment = $_POST['comment'];

					$info = fetch_user_goal($goal);

					add_comment(htmlentities(strip_tags($comment), ENT_QUOTES), $_COOKIE['user'], $goal);
					notify_commenters($goal, $_COOKIE['user']);
					
					if($_COOKIE['user'] != $info[5])
						new_notification($info[5], $_COOKIE['user'], 'Comment', $goal);
				}

				$user_view = is_user_goal($goal, $_COOKIE['user']);

				$goal = fetch_user_goal($goal);


				echo '<div class="space"></div>';
				echo '<div class="space"></div>';
					gen_large_detailed_goal($goal);
				echo '<div class="space"></div>';

				// fb_pics view
				$album_info = fetch_album($goal[8]);

				if(isset($album_info[5]))
					$fb_pics = $album_info[5];
				else
					$fb_pics = '';

				if($fb_pics != '')
				{
		            
		            $fb_pics = str_replace('"', "", substr($fb_pics, 4));
              		$fb_pics = substr($fb_pics, 0, (strlen($fb_pics)-1));
              		$fb_pics = explode(",", $fb_pics);

              		$local_pics = $album_info[2];
		            $local_pics = str_replace('"', "", substr($local_pics, 4));
		            $local_pics = substr($local_pics, 0, (strlen($local_pics)-1));
		            $local_pics = explode(",", $local_pics);

		            echo '<div class="goal-photo-selector">';
		            foreach ($fb_pics as $image)
		            {
		            	echo "<div class='photo-select'><img src='".$image."' class='not-selected'></div>";
		            }
		            foreach ($local_pics as $image) 
		            {
		                echo "<div class='photo-select'><img src='".$image."' class='not-selected'></div>";
		            }
		           	echo '</div>'; 
		           	echo '<div class="space"></div>';
		        }

				$comments = get_comments($goal[8]);

				echo '<div class="goal-comments">';
					echo '<h2>Comments</h2>';
				?>	
				<form class="comment-form" name="comment-form" method="post" action="goal.php?id=<?php echo $goal[8]; ?>">
					Post a Comment:<br>
					<textarea id="comment-text" type="text" name="comment"></textarea><br>

					<input type="submit" name="submit" value="Post" onclick="return add_comment('<?php echo $goal[8]; ?>');">
				</form>
				<?php

				echo '<div id="comment-content" class="comment-content">';
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

				echo '</div>';
				echo '</div>';

				 } 
				 else 
				{ 
					echo "Please <a href='login.php'>login</a> to view this page";
				}
			?>
			</div>
		</div>
		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>
