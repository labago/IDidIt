<?php include("functions.php"); ?>
<html>
	<title>IDidIt - Login</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/jquery.validate.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

	<div class="page">
		<div class="content">
			<div class="main-content">
				<h1>Login</h1>
				<br><br>
		<?php 

			$error = false;
			if(isset($_GET['error']))
				{
					$error = true;	
				}
		?>


		<?php if(!isset($_POST['submit'])) { ?>		
		    <form class="login-form" action="login.php" method="post" name="login_form" id="login_form">
		    <?php if($error){ echo "<b>Incorrect Email or Password</b><br>";} ?>
		    	Email: <br>
		    	<input type="text" name="email"><br>
		    	Password:<br>
		    	<input type="password" name="pass"><br>

		    	<input type="submit" name="submit" value="Login">
		    </form>
		    <a href="forgot.php">Forgot Password?</a>
		    <br>
		<?php } else { 

			$confirm = true;

			$email = $_POST['email'];
			$password = $_POST['pass'];

			$db->db_connect();

			$query = "SELECT * 
				FROM `Users` 
				WHERE `Email` LIKE '$email'
				LIMIT 0 , 30";

			$result = $db->db_query($query);

			if($db->db_num_rows($result) > 0)
			{
				$row = $db->db_fetch_row($result);

				if($password != $row[3])
				{
					$confirm = false;
				}
			}
			else
			{
				$confirm = false;
			}

			if($confirm){
				$crypt = $row[4];

				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login_user.php?c='.$crypt.'">'; 
			}
			else
			{
				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login.php?error=1">'; 
			}

		}

	 	?>

		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>