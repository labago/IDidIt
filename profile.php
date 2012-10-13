<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="functions.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
			<?php if(isset($_GET['id']) || isset($_COOKIE['user']))
				   {
				   	   if(isset($_GET['id']))
				   	   		$user_info = fetch_user_info($_GET['id']);

					$picture = $user_info[5]; 
			?>
				<h1><?php echo $user_info[0]." ".$user_info[1]; ?></h1>
				<div class="profile-pic">
					<img src="<?php echo $picture; ?>" alt="profile-picture">
				</div>

			<?php 

				if(isset($_GET['id']))
				   	$goals = fetch_user_goals($_GET['id']);
				else
					$goals = fetch_user_goals($_COOKIE['user']);

				foreach($goals as $goal)
				{
					echo '<div class="goal">';
						echo '<div class="goal_column">';
							echo '<h1>'.$goal[0].'</h1><p>'.$goal[3].'</p>';
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
						if(isset($_COOKIE['user']) && (isset($_GET['id'])) && (strpos($goal[9], $_COOKIE['user']) === false))
						{
							$user = "'".$_COOKIE['user']."'";
							$goal_crypt = "'".$goal[8]."'";
							echo '<div class="congrats-button"><a onclick="congrats('.$user.', '.$goal_crypt.', this); return false;" href="">Congratulate</a></div>';
						}
					echo '</div>';
					echo '<div class="space"></div>';
				}
				if(isset($_COOKIE['user']) && (!isset($_GET['id'])))
				{ ?>
					<a href="add-goal.php"><input type="button" value="Add New Goal"></a>
				<?php } ?>


			<?php } else 
					{ 

						echo "Please <a href='login.php'>login</a> to view your profile";

					}
			?>
			</div>
		</div>

		<?php include("Components/footer.php"); ?>
	</body>
</html>