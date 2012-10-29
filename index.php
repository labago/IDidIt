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

				<div id="cpwm_hero_wrapper">
					<a href="#" class="arrow prev" id="arrowleft"></a>
				  	<div id=transleft class="trans" ></div>
				  	<div id=transright class="trans" ></div>
					<a href="#" class="next arrow" id="arrowright"></a>
					<div class="homeslider" id="cpwm_hero_slider">
						<div class="preload" id="preloadimgs"><img src="test-images/trans.png"/><img src="test-images/trans2.png"/></div>
						<ul>
							<li>
								<?php

									$goals = array();
									while($row = $db->db_fetch_row($result))
									{
										array_push($goals, $row);	
									}

									echo '<div class="intracite-wrapper">';
										echo '<div class="row">';
											echo '<div class="row-large-single">';
												echo '<img src="'.$goals[0][4].'">';
											echo '</div>';
											echo '<div class="row-large-single">';
												echo '<img src="'.$goals[1][4].'">';
											echo '</div>';
										echo '</div>';
										echo '<div class="row">';
											echo '<div class="row-large-single">';
												echo '<img src="'.$goals[2][4].'">';
											echo '</div>';
											echo '<div class="row-large-single">';
												echo '<img src="'.$goals[3][4].'">';
											echo '</div>';
										echo '</div>';
										echo '<div class="row">';
											echo '<div class="row-large-single">';
												echo '<img src="'.$goals[2][4].'">';
											echo '</div>';
											echo '<div class="row-large-single">';
												echo '<img src="'.$goals[3][4].'">';
											echo '</div>';
											echo '<div class="row-half-single">';
												echo '<img src="'.$goals[4][4].'">';
											echo '</div>';
										echo '</div>';
									echo '</div>';											
								?>
							</li>
					    </ul>
					</div>
				</div>

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