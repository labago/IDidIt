<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="functions.js"></script>
	<?php
		$query = "SELECT * 
				FROM `Goal`";
		$result = mysql_query($query);
		$count = mysql_num_rows($result);
	?>

	<body onload="check = setInterval(function (){ get_new_goals();}, 5000);">
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Welcome to IDidIt.com!</h1>
				<br><br><br>
				<div id="stream" class="stream">
					<?php
						while($row = mysql_fetch_row($result))
						{
							echo '<div class="stream-goal">';
								echo '<a href="profile.php?id='.$row[5].'"><h2>'.$row[0]."</h2></a>";
								echo '<img src="'.$row[4].'">';
							echo '</div>';
							echo '<div class="space"></div>';
						}
					?>
				</div>

				<div class="users">
					<?php
						$query = "SELECT * 
								FROM `Users`";
						$result = mysql_query($query);

						while($row = mysql_fetch_row($result))
						{
							echo '<a href="profile.php?id='.$row[4].'"><h2>'.$row[0]." ".$row[1]."</h2></a>";
						}
					?>
				</div>
			</div>
		</div>
		<?php include("Components/footer.php"); ?>
	</body>
</html>