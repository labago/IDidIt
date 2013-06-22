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
				<a href="#"><img src="styles/images/notifications.png" style="height: 70px;"></a>
				<a href="#"><img src="styles/images/filter.png" style="height: 70px;"></a>
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
						<a href="#"><img src="styles/images/layout1.png" style="height: 20px;"></a>
						<a href="#"><img src="styles/images/layout2.png" style="height: 20px;"></a>
					</div>
					<br>
					<ul id="slider">
						<li>
							<div class="panel">
								<div class="feature-achievement">
									<img src="s<?php echo $goals[1][16]; ?>">
									<div class="feature-achievement-text">
										<a href="<?php echo 'goal.php?id='.$goals[1][8]; ?>"><h2><?php echo $goals[1][3]; ?></h2></a>
										<p>by: Jon Lane</p>
										<i><?php echo $goals[1][7]; ?></i>
									</div>
								</div>
								<div class="quad-achievement">
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
								</div>
								<div class="bottom-achievements">
									<div class="narrow-achievement">
										<img src="<?php echo $goals[2][16]; ?>">
										<div class="narrow-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[2][8]; ?>"><h2><?php echo $goals[2][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[2][7]; ?></i>
										</div>
									</div>
									<div class="wide-achievement">
										<img src="styles/images/joni-grad.png">
										<div class="wide-achievement-text">
											<h2>Graduated Radford University</h2>
											<p>by: Joni Lane | With: Edward Coles, Maggie Gordon, Whitney Farrar, see more...</p>
											<i>Academic Achievement</i>
										</div>
									</div>
								</div>
							</div>
						</li>
												<li>
							<div class="panel">
								<div class="feature-achievement">
									<img src="s<?php echo $goals[1][16]; ?>">
									<div class="feature-achievement-text">
										<a href="<?php echo 'goal.php?id='.$goals[1][8]; ?>"><h2><?php echo $goals[1][3]; ?></h2></a>
										<p>by: Jon Lane</p>
										<i><?php echo $goals[1][7]; ?></i>
									</div>
								</div>
								<div class="quad-achievement">
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
									<div class="standard-achievement">
										<img src="<?php echo $goals[0][16]; ?>">
										<div class="standard-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[0][8]; ?>"><h2><?php echo $goals[0][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[0][7]; ?></i>
										</div>
									</div>
								</div>
								<div class="bottom-achievements">
									<div class="narrow-achievement">
										<img src="<?php echo $goals[2][16]; ?>">
										<div class="narrow-achievement-text">
											<a href="<?php echo 'goal.php?id='.$goals[2][8]; ?>"><h2><?php echo $goals[2][3]; ?></h2></a>
											<p>by: Jon Lane</p>
											<i><?php echo $goals[2][7]; ?></i>
										</div>
									</div>
									<div class="wide-achievement">
										<img src="styles/images/joni-grad.png">
										<div class="wide-achievement-text">
											<h2>Graduated Radford University</h2>
											<p>by: Joni Lane | With: Edward Coles, Maggie Gordon, Whitney Farrar, see more...</p>
											<i>Academic Achievement</i>
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