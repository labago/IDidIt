<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/functions.js"></script>
	<?php
		$query = "SELECT * 
				FROM `Goal`
				ORDER BY `Date Posted` DESC";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
	?>

	<!-- <body onload="check = setInterval(function (){ get_new_goals();}, 5000);"> -->
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Welcome to IDidIt.com!</h1>
				<br><br><br>
				<div id="stream" class="stream">
					<?php

						function gen_small_goal($row, $float)
						{
							if($float)
								echo '<div class="stream-goal-small" style="float: right;">';
							else
								echo '<div class="stream-goal-small" style="float: left;">';

								echo '<a href="goal.php?id='.$row[8].'"><h2>'.html_entity_decode($row[0])."</h2></a>";
								echo '<img src="'.$row[4].'">';
							echo '</div>';
							echo '<div class="space"></div>';
						}

						$float = false;
						while($row = mysql_fetch_row($result))
						{
							if(!$float)
								echo '<div class="stream-goal-small-wrapper">';

							gen_small_goal($row, $float);

							if($float)
								echo '</div>';

							$float = !$float;
						}
					?>
				</div>

				<div class="users">
					<?php
						$query = "SELECT * 
								FROM `Users` ";
						$result = mysql_query($query);

						while($row = mysql_fetch_row($result))
						{
							echo '<a href="profile.php?id='.$row[4].'"><h2>'.html_entity_decode($row[0])." ".html_entity_decode($row[1])."</h2></a>";
						}
					?>
				</div>
			</div>
		</div>
		<?php include("Components/footer.php"); ?>
	</body>
</html>