<?php include("functions.php"); ?>
<html>
	<title>IDidIt - Home</title>
	<head>
		<link rel="stylesheet" href="scripts/slideshow/demos/css/page.css">
		<link rel="stylesheet" href="scripts/slideshow/css/anythingslider.css">
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script src="scripts/slideshow/js/jquery.anythingslider.js"></script>
	<script src="scripts/slideshow/js/jquery.anythingslider.fx.min.js"></script>
	<script src="scripts/slideshow/js/jquery.easing.1.2.js"></script> 
	<?php

    	$db->db_connect();

		$query = "SELECT * 
				FROM `Goal`
				ORDER BY `Date Posted` DESC";

		$result = $db->db_query($query);
	?>

	<body>
		<?php include("Components/header.php"); ?>

		<div class="content">
			<br>
			<div class="notification-filter">
				<a href="#"><img src="styles/images/notifications.png"></a>
				<a href="#"><img src="styles/images/filter.png"></a>
			</div>
			<div class="main-content">
				<br>
				<?php

						$goals = array();
						while($row = $db->db_fetch_row($result))
						{
							array_push($goals, $row);	
						}
				?>
				<style>
				#slider { 
					width: 888px; 
					height: 1000px; 
				}
				.anythingSlider-default {
					padding: 0 0 0 0 !important;
					border: none;
				}
				.anythingSlider-default .anythingWindow{
					border: none;
				}
				</style>

				<script>
					// DOM Ready
				$(function(){
					$('#slider').anythingSlider({toggleArrows: true, expand: false, buildNavigation: false, buildStartStop: false});
				});
				</script>

				<div class="horizontal-shift">
					<div class="layout-selector">
						<a href="#"><img src="styles/images/layout1.png"></a>
						<a href="#"><img src="styles/images/layout2.png"></a>
					</div>
					<br>
					<ul id="slider">
						<li>
							<div class="panel">
								<div class="feature-achievement">
									<img src="styles/images/graduation-image.png">
									<div class="feature-achievement-text">
										<h2>St. John's Prep Award</h2>
										<p>by: Jon Lane</p>
										<i>Academic Achievement</i>
									</div>
									<div class="standard-achievement-stats">
										<img src="styles/images/thumbs-up.png">
										<span>458</span>
										<img src="styles/images/eye.png">
										<span>7076</span>
									</div>
								</div>
								<div class="quad-achievement">
									<div class="standard-achievement">
										<img src="styles/images/water-ski.png">
										<div class="standard-achievement-text">
											<h2>Got Up Water-Skiing</h2>
											<p>by: Jon Lane</p>
											<i>Athletic Achievement</i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="styles/images/rafting.png">
										<div class="standard-achievement-text">
											<h2>White Water Rafting</h2>
											<p>by: Jon Lane</p>
											<i>Life Event</i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="styles/images/working.png">
										<div class="standard-achievement-text">
											<h2>Built a house</h2>
											<p>by: Jon Lane</p>
											<i>Philanthropic Achievement</i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="styles/images/painting.png">
										<div class="standard-achievement-text">
											<h2>My First Painting</h2>
											<p>by: Joni Lane</p>
											<i>Personal Achievement</i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
								</div>
								<div class="bottom-achievements">
									<div class="narrow-achievement">
										<img src="styles/images/kid.png">
										<div class="narrow-achievement-text">
											<h2>Took my first Steps!</h2>
											<p>by: Carter Lee Sam</p>
											<i>Personal Achievement</i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="wide-achievement">
										<img src="styles/images/joni-grad.png">
										<div class="wide-achievement-text">
											<h2>Graduated Radford University</h2>
											<p>by: Joni Lane | With: Edward Coles, Maggie Gordon, Whitney Farrar, see more...</p>
											<i>Academic Achievement</i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
								</div>
							</div>
						</li>
						<li>
							<div class="panel">
								<div class="feature-achievement">
									<img src="<?php echo $goals[1][16]; ?>">
									<div class="feature-achievement-text">
										<a href="<?php echo 'goal.php?id='.$goals[1][8]; ?>"><h2><?php echo $goals[1][0]; ?></h2></a>
										<p>by: Jon Lane</p>
										<i><?php echo $goals[1][7]; ?></i>
									</div>
									<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
								</div>
								<div class="quad-achievement">
									<div class="standard-achievement">
										<img src="<?php echo $goals[4][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][0]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[4][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][0]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[4][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][0]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[4][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][0]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
								</div>
								<div class="bottom-achievements">
									<div class="narrow-achievement">
										<img src="<?php echo $goals[2][16]; ?>">
										<div class="narrow-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[2][8]; ?>"><h2><?php echo $goals[2][0]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[2][7]; ?></i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
									<div class="wide-achievement">
										<img src="styles/images/joni-grad.png">
										<div class="wide-achievement-text">
											<h2>Graduated Radford University</h2>
											<p>by: Joni Lane | With: Edward Coles, Maggie Gordon, Whitney Farrar, see more...</p>
											<i>Academic Achievement</i>
										</div>
										<div class="standard-achievement-stats">
											<img src="styles/images/thumbs-up.png">
											<span>458</span>
											<img src="styles/images/eye.png">
											<span>7076</span>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>