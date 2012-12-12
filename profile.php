<?php include("functions.php"); ?>
<html>
	<title>IDidIt - Profile View</title>
	<head>
		<link rel="stylesheet" href="scripts/slideshow/demos/css/page.css">
		<link rel="stylesheet" href="scripts/slideshow/css/anythingslider.css">
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script src="scripts/slideshow/js/jquery.anythingslider.js"></script>
	<script src="scripts/slideshow/js/jquery.anythingslider.fx.min.js"></script>
	<script src="scripts/slideshow/js/jquery.easing.1.2.js"></script> 
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
				<h1><?php echo html_entity_decode($user_info[0])." ".html_entity_decode($user_info[1]); ?></h1>
				<div class="profile-pic">
					<img src="<?php echo $picture; ?>" alt="profile-picture">
				</div>

			<?php 

				if(isset($_GET['id']))
				   	$goals = fetch_user_goals($_GET['id']);
				else
					$goals = fetch_user_goals($_COOKIE['user']);
			?>

				<style>
				#slider { width: 960px; height: 450px; }
				</style>

				<script>
					// DOM Ready
				$(function(){
					$('#slider').anythingSlider({toggleArrows: true, expand: false, buildNavigation: false, buildStartStop: false});
				});
				</script>

				<ul id="slider">
					<?php
						foreach($goals as $goal)
						{
							echo "<li>";
								gen_large_detailed_goal($goal);
							echo "</li>";
						}
					?>
			    </ul>
			<?php
			} 
			else 
			{ 
				echo "Please <a href='login.php'>login</a> to view your profile";
			}
			?>
			</div>
		</div>

		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>
<?php $db->db_close(); ?>