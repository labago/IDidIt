<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
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

				if($_GET['n'] == 'true')
					kill_notifications($goal);

				// if a comment was posted, post it
				if(isset($_POST['submit']))
				{
					$comment = $_POST['comment'];

					$info = fetch_user_goal($goal);

					add_comment(htmlentities(strip_tags($comment), ENT_QUOTES), $_COOKIE['user'], $goal);
					if($_COOKIE['user'] != $info[5])
						new_notification($info[5], $_COOKIE['user'], 'Comment', $goal);
				}

				$user_view = is_user_goal($goal, $_COOKIE['user']);

				$goal = fetch_user_goal($goal);


				echo '<div class="space"></div>';
				echo '<div class="space"></div>';
				echo '<div class="goal">';
					echo '<div class="goal_column">';
						echo '<a href="goal.php?id='.$goal[8].'"><h1>'.html_entity_decode($goal[0]).'</h1></a><p>'.html_entity_decode($goal[3]).'</p>';
						echo '<div class="witness">';
							echo '<h2>Witnesses</h2>';

						if($goal[6] != '')
						{
							$witnesses = explode(',', $goal[6]);

							foreach ($witnesses as $witness) {
								// this makes the page load way too slowly
								//$name = json_decode(file_get_contents("https://graph.facebook.com/".$witness."?fields=name"), true);
								echo "<img src='http://graph.facebook.com/".$witness."/picture?type=square' alt=''>";
							}
						}
						else
						{
							echo "No Witness Mentioned";
						}
						echo "</div>";
					echo '</div>';
					echo '<div class="goal_column">';
						echo '<img src="'.$goal[4].'">';
					echo '</div>';
					echo '<div class="goal_column">';
						echo '<img src="'.$goal[4].'">';
					echo '</div>';
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
					if(isset($_COOKIE['user']) && (!$user_view) && (strpos($goal[9], $_COOKIE['user']) === false))
					{
						$user = "'".$_COOKIE['user']."'";
						$goal_crypt = "'".$goal[8]."'";
						echo '<div class="congrats-button"><a onclick="congrats('.$user.', '.$goal_crypt.', this); return false;" href="">Congratulate</a></div>';
					}
				echo '</div>';
				echo '<div class="space"></div>';

				$comments = get_comments($goal[8]);

				echo '<div class="goal-comments">';
					echo '<h2>Comments</h2>';
				?>	
				<form name="comment-form" method="post" action="goal.php?id=<?php echo $goal[8]; ?>">
					Post a Comment:<br>
					<textarea type="text" name="comment"></textarea><br>

					<input type="submit" name="submit" value="Post">
				</form>
				<?php

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




				 } else 
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
