<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Welcome to IDidIt.com!</h1>
				<br><br><br>
				
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

		<?php include("Components/footer.php"); ?>
	</body>
</html>