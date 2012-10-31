<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
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


		<div class="page">
			<div class="content">
				<h1>Welcome to IDidIt.com!</h1>
				<br><br><br>

				<style>
				#slider { width: 960px; height: 450px; }
				#slider .panel { position: relative; } 
				 #slider .caption-top, #slider .caption-right, 
				 #slider .caption-bottom, #slider .caption-left { 
				  background: #000; 
				  color: #fff; 
				  padding: 10px; 
				  margin: 0; 
				  position: relative; 
				  z-index: 10; 
				  opacity: .8; 
				  filter: alpha(opacity=80); 
				 } 
				#slider .caption-right { 
				  right: 0 !important;
				  bottom: 0; 
				  width: 130px; 
				  height: 180px; 
				 } 
				 #slider .caption-left { 
				  right: 0; 
				  bottom: 0; 
				  width: 130px; 
				  height: 180px; 
				 } 
				  #slider .caption-top { 
				  left: 0; 
				  top: 0; 
				  width: 480px; 
				  height: 30px; 
				 } 
				 .caption-top .close, .caption-right .close, 
				 .caption-bottom .close, .caption-left .close { 
				  font-size: 80%; 
				  cursor: pointer; 
				  float: right; 
				  display: inline-block; 
				 }
				</style>

				<script>
					// DOM Ready
				$(function(){
					$('#slider').anythingSlider({toggleArrows: true, expand: false, buildNavigation: false, buildStartStop: false})
						.anythingSliderFx({
							'.caption-right'  : [ 'caption-Right', '130px', '1000', 'easeOutBounce' ],
							'.caption-top'    : [ 'caption-Top', '50px' ],
							'.caption-left'   : [ 'caption-Left', '130px', '1000', 'easeOutBounce' ]
						})
					});
				</script>

				<ul id="slider">

					<li>
						<?php

						$goals = array();
						while($row = $db->db_fetch_row($result))
						{
							array_push($goals, $row);	
						}
							echo '<div class="row">';
								echo '<div class="row-half-single-wrapper">';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
									echo '</div>';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
									echo '</div>';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
								echo '</div>';
							echo '</div>';
							echo '<div class="row">';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
								echo '</div>';
								echo '<div class="row-half-single-wrapper">';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>';
									echo '</div>';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>'; 
									echo '</div>';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';

									echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
									echo '</span></a>';
								echo '</div>';
							echo '</div>';
							echo '<div class="row">';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
									echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
									echo '</span></a>';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
									echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
									echo '</span></a>';
								echo '</div>';
								echo '<div class="row-half-single-wrapper">';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>';
									echo '</div>';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>';
									echo '</div>';
								echo '</div>';
							echo '</div>';										
					?>
						<div class="caption-top"> 
					    	These are the top achievements
					   </div> 
					</li>
					<li>
						<?php				
							echo '<div class="row">';
								echo '<div class="row-half-single-wrapper">';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
									echo '</div>';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
									echo '</div>';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
								echo '</div>';
							echo '</div>';
							echo '<div class="row">';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
								echo '</div>';
								echo '<div class="row-half-single-wrapper">';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>';
									echo '</div>';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>'; 
									echo '</div>';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';

									echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
									echo '</span></a>';
								echo '</div>';
							echo '</div>';
							echo '<div class="row">';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
									echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
									echo '</span></a>';
								echo '</div>';
								echo '<div class="row-large-single">';
									echo '<img src="'.$goals[0][4].'">';
									echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
									echo '</span></a>';
								echo '</div>';
								echo '<div class="row-half-single-wrapper">';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>';
									echo '</div>';
									echo '<div class="row-half-single">';
										echo '<img src="'.$goals[0][4].'">';
										echo '<a href="goal.php?id='.$goals[0][8].'"><span class="panel-content">';
											echo $goals[0][3];
										echo '</span></a>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
					?>
						<div class="caption-right"> 
					    These are the top achievements
					   </div> 
					</li>

				</ul>

				<br><br><br>

				<div id="stream" class="stream">

				</div>

				<div class="users">
					<?php
						$query = "SELECT * 
								FROM `Users` ";
						$result = $db->db_query($query);

						while($row = $db->db_fetch_row($result))
						{
							echo '<a href="profile.php?id='.$row[4].'"><h2>'.html_entity_decode($row[0])." ".html_entity_decode($row[1])."</h2></a>";
						}
					?>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>