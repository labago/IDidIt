<html>
	<title>IDidIt</title>
	<head>
		<link href="../../styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<?php include("../Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Sign Up</h1>

		<?php if(!isset($_POST['submit'])) { ?>		
		    <form action="sign-up.php" method="post" name="sign-up-form">
		    	First Name:<br>
		    	<input type="text" name="fname"><br>
		    	Last Name:<br>
		    	<input type="text" name="lname"><br>
		    	Email:<br>
		    	<input type="text" name="email_first"><br>
		    	Email Confirmation:<br>
		    	<input type="text" name="email_second"><br>
		    	Password:<br>
		    	<input type="password" name="pass_first"><br>
		    	Password Confirmation:<br>
		    	<input type="password" name="pass_second"><br>

		    	<input type="submit" name="submit" value="Sign Up">
		    </form>
		    <br>
		<?php } else { 

			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$email_1 = $_POST['email_first'];
			$email_2 = $_POST['email_second'];
			$pass_1 = $_POST['pass_first'];
			$pass_2 = $_POST['pass_second'];

			$confirm = true;

			if($email_1 != $email_2)
			{
				$confirm = false;
				echo "Emails do not match, please go back and try again";
			}
			if($pass_2 != $pass_1)
			{
				$confirm = false;
				echo "Passwords do not match, please go back and try again";
			}

			if($confirm){
				$crypt = add_user($fname, $lname, $pass_1, $email_1);

				// set login cookie for a month's time	
				setcookie("user", $crypt, time()+2592000);

				echo "Thanks for signing up! You are now logged into IDidIT.com";
			}







		}
	 	?>

			</div>
		</div>

		<?php include("../Components/footer.php"); ?>
	</body>
</html>