<?php include("functions.php"); ?>
<html>
	<title>IDidIt - Forgot Password</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/jquery.validate.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="content">
			<div class="main-content">
				<h1>Recover Password</h1>
				<br><br>
		<?php 

			$error = false;
			if(isset($_GET['error']))
				{
					$error = true;	
				}
		?>


		<?php if(!isset($_POST['submit'])) { ?>		
		    <form class="login-form" action="forgot.php" method="post" name="login_form" id="login_form">
		    <?php if($error){ echo "<b>Email not found in our system</b><br>";} ?>
		    	Email: <br>
		    	<input type="text" name="email"><br>

		    	<input type="submit" name="submit" value="Send">
		    </form>
		    <br>
		<?php } else { 

			$email = $_POST['email'];

			$db->db_connect();

			$query = "SELECT * 
				FROM `Users` 
				WHERE `Email` LIKE '$email'
				LIMIT 0 , 30";

			$result = $db->db_query($query);

			if($db->db_num_rows($result) > 0)
			{
				$row = $db->db_fetch_row($result);

				$password = $row[3];

				$header = 'From: password-service \r\n';
				$message = "Your password for i-did-it.net is: '".$password."' \n \n if you have recieved this emal in error, please disregard";

				// sent a notification to them
				if(mail($email, "Your Password", $message, $header))
					echo 'Check your email for your password, if its not there also check your spam folder'; 
				else
					echo 'Something has gone wrong.';
			}
			else
			{
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=forgot.php?error=1">'; 
			}
		}

	 	?>
			</div>
		</div>

		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>