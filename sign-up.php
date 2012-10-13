<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/functions.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Sign Up</h1>
				<br><br>

		<?php if(!isset($_POST['submit'])) { ?>		
		    <form action="sign-up.php" method="post" name="sign_up_form">
		    	First Name: <span id="first" ></span><br>
		    	<input type="text" name="fname" onChange="check_first();"><br>
		    	Last Name:<span id="last" ></span><br>
		    	<input type="text" name="lname" onChange="check_last();"><br>
		    	<b id="email4"></b> 
		    	Email: <span id="email1" ></span><br>
		    	<input type="text" name="email_first" onChange="check_email();"><br><span id="first" ></span>
		    	Email Confirmation: <span id="email2" ></span> <br>
		    	<input type="text" name="email_second" onChange="check_emails();"><br>     
	            <b id="email3"></b>
		    	Password:<span id="pass1" ></span><br>
		    	<input type="password" name="pass_first"><br><b id="pass1"></b>
		    	Password Confirmation:<span id="pass2" ></span><br>
		    	<input type="password" name="pass_second" onChange="check_passwords();"><br>
		    	<b id="pass3"></b>

		    	<input type="submit" name="submit" value="Sign Up">
		    </form>
		    <br>
		<?php } else { 

			$fname = htmlentities(strip_tags($_POST['fname']), ENT_QUOTES);
			$lname = htmlentities(strip_tags($_POST['lname']), ENT_QUOTES);
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
			if($pass_2 != $pass_1 || (str_replace('"', '', str_replace("'", "", strip_tags($pass_1))) != $pass_1))
			{
				$confirm = false;
				echo "Passwords do not match or prohibited characters were use, please go back and try again";
			}

			if($confirm){
				$crypt = add_user($fname, $lname, $pass_1, $email_1);

				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login_user.php?c='.$crypt.'">'; 
			}







		}
	 	?>

			</div>
		</div>

		<?php include("Components/footer.php"); ?>
	</body>
</html>