<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
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
		    <form action="login.php" method="post" name="login_form">
		    <?php if($error){ echo "<b>Incorrect Email or Password</b><br>";} ?>
		    	Email: <br>
		    	<input type="text" name="email"><br>
		    	Password:<br>
		    	<input type="password" name="pass"><br>

		    	<input type="submit" name="submit" value="Login">
		    </form>
		    <br>
		<?php } else { 

			$confirm = true;

			$email = $_POST['email'];
			$password = $_POST['pass'];

			$query = "SELECT * 
				FROM `Users` 
				WHERE `Email` LIKE '$email'
				LIMIT 0 , 30";

			$result = mysql_query($query);

			if(mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_row($result);

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

			</div>
		</div>

		<?php include("Components/footer.php"); ?>
	</body>
</html>