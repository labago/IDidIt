<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="jquery.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
			<?php if(isset($_COOKIE['user']))
				   {
					$picture = $user_info[5]; ?>
				<h1><?php echo $user_info[0]." ".$user_info[1]; ?></h1>
				<div class="profile-pic">
					<img src="<?php echo $picture; ?>" alt="profile-picture">
				</div>

			<?php $goals = fetch_user_goals($_COOKIE['user']);

				foreach($goals as $goal)
				{
					echo '<div class="goal">';
						echo '<div class="goal_column">';
							echo '<h1>'.$goal[0].'</h1><p>'.$goal[3].'</p>';
						echo '</div>';
						echo '<div class="goal_column">';
							echo '<img src="'.$goal[4].'">';
						echo '</div>';
						echo '<div class="goal_column">';
							echo '<img src="'.$goal[4].'">';
						echo '</div>';
					echo '</div>';
					echo '<div class="space"></div>';
				}
			?>
			<a href="add-goal.php">Add New Goal</a>


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