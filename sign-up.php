<?php include("functions.php"); ?>
<html>
	<title>IDidIt - Sign Up</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/jquery.validate.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="content">
			<div class="main-content">
				<h1>Sign Up</h1>
				<br><br>

		<?php if(!isset($_POST['submit'])) { ?>		
		    <form class="sign-up" action="sign-up.php" method="post" name="sign_up_form" id="sign_up_form">
		    	First Name <br>
		    	<input type="text" name="fname" id="fname"><br>
		    	Last Name:<br>
		    	<input type="text" name="lname" id="lname"><br>
		    	<b id="email4"></b> 
		    	Email: <span id="email1" ></span><br>
		    	<input type="text" name="email_first" id="email_first" class="email"><br>
		    	Email Confirmation: <br>
		    	<input type="text" name="email_second"><br>     
		    	Password:<br>
		    	<input type="password" name="pass_first" id="pass_first"><br>
		    	Password Confirmation:<br>
		    	<input type="password" name="pass_second" id="pass_second"><br>
				<input type="hidden" name="valid_email" id="valid_email" value="">
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

			if(check_email($email_1))
			{
				$confirm = false;
				echo "Email is already in use, please go back and try again<br>";
			}

			if($email_1 != $email_2)
			{
				$confirm = false;
				echo "Emails do not match, please go back and try again<br>";
			}
			if($pass_2 != $pass_1 || (str_replace('"', '', str_replace("'", "", strip_tags($pass_1))) != $pass_1))
			{
				$confirm = false;
				echo "Passwords do not match or prohibited characters were use, please go back and try again<br>";
			}

			if($confirm){
				$crypt = add_user($fname, $lname, $pass_1, $email_1);

				$header = 'Content-type: text/html; charset=iso-8859-1'."\r\n";
				$header .= 'From: I Did It <do-not-reply@i-did-it.net>'."\r\n"; 

				$message = "Dear ".$fname.", <br><br>";
				$message .= "Welcome to I Did It, where you can share with the world all the awesome things you have done ";
				$message .= "in your life. Better yet, think of this site as a real time achievement tracker, making sure you will";
				$message .= " never forget the things you have accomplished. Be sure to add as much as you want, but keep in mind ";
				$message .= "that this site is intended only for valuable posts documenting your life. "

				mail($email_1, "Welcome!", $message, $header);

				echo '<META HTTP-EQUIV="Refresh" Content="0; URL=login_user.php?c='.$crypt.'">'; 
			}
		}
	 	?>
			</div>
		</div>

		<script type="text/javascript" src="scripts/functions.js">
		</script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>