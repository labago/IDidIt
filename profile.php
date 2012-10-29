<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="scripts/slideshow-test/css.css?20121002-1" rel="stylesheet" type="text/css" />
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/slideshow-test/second.js?20121016-1"></script>
	<script type="text/javascript" src="scripts/slideshow-test/first.js?20121016-2"></script>
	<script type="text/javascript" src="scripts/slideshow-test/easing.js"></script>
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

				<div id="cpwm_hero_wrapper">
					<a href="#" class="arrow prev" id="arrowleft"></a>
				  	<div id=transleft class="trans" ></div>
				  	<div id=transright class="trans" ></div>
					<a href="#" class="next arrow" id="arrowright"></a>
					<div class="homeslider" id="cpwm_hero_slider">
						<div class="preload" id="preloadimgs"><img src="test-images/trans.png"/><img src="test-images/trans2.png"/></div>
						<ul>
							<?php
								foreach($goals as $goal)
								{
									echo "<li>";
										gen_large_detailed_goal($goal);
									echo "</li>";
								}
							?>
					   </ul>
					</div>
				</div>
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