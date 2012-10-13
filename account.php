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
				<h1>My Account</h1>
				<br><br>
		<?php if(isset($_COOKIE['user']))
				   { ?>

		<?php if(!isset($_POST['submit'])) { ?>		
		    <form action="account.php" method="post" name="sign_up_form" enctype="multipart/form-data">
		    	First Name: <span id="first" ></span><br>
		    	<input type="text" name="fname" onChange="check_first();" value="<?php echo $user_info[0]; ?>"><br>
		    	Last Name:<span id="last" ></span><br>
		    	<input type="text" name="lname" onChange="check_last();" value="<?php echo $user_info[1]; ?>"><br>
		    	<b id="email4"></b> 
		    	Email: <span id="email1" ></span><br>
		    	<input type="text" name="email_first" onChange="check_email();" value="<?php echo $user_info[2]; ?>"><br><span id="first" ></span>
		    	Email Confirmation: <span id="email2" ></span> <br>
		    	<input type="text" name="email_second" onChange="check_emails();" value="<?php echo $user_info[2]; ?>"><br>     
	            <b id="email3"></b>
		    	Password:<span id="pass1" ></span><br>
		    	<input type="password" name="pass_first"><br><b id="pass1"></b>
		    	Password Confirmation:<span id="pass2" ></span><br>
		    	<input type="password" name="pass_second" onChange="check_passwords();"><br>
		    	<b id="pass3"></b>
		    	Profile Picture: <br>
		    	<img src="<?php echo $user_info[5]; ?>" alt="current profile pic" style="max-width: 200px;"><br><br>
				<input id="local" type="file" name="pic" size="10000000"><br>

		    	<input type="submit" name="submit" value="Update">
		    <br>
		<?php } else {

			if(isset($_FILES['pic'])){

				if ((($_FILES["pic"]["type"] == "image/gif")
				|| ($_FILES["pic"]["type"] == "image/jpeg")
				|| ($_FILES["pic"]["type"] == "image/pjpeg")
				|| ($_FILES["pic"]["type"] == "image/png"))
				&& ($_FILES["pic"]["size"] < 200000000))
				  {
				  if ($_FILES["pic"]["error"] > 0)
				    {
				    echo 'Something went wrong';
				    }
				  else
				    {
				$pic_name = gen_pic_name($_FILES["pic"]["name"]);

				move_uploaded_file($_FILES["pic"]["tmp_name"], "uploads/" . $pic_name);


				change_user_pic($_COOKIE['user'], "http://www.justdidthat.com/uploads/".$pic_name);

				//need to update database here and refresh page
				}
				}
				else {

				// need an error message here stating that the file was not of the picture variety
				}
			}


			if(isset($_POST['fname']))
				$fname = $_POST['fname'];
			else
				$fname = $user_info[0];

			if(isset($_POST['lname']))
				$lname = $_POST['lname'];
			else
				$lname = $user_info[1];

			if(isset($_POST['email_first']) && isset($_POST['email_second']))
			{
				if($_POST['email_first'] == $_POST['email_second'])
					$email = $_POST['email_first'];
				else
					$email = $user_info[2];
			}
			else
				$email = $user_info[2];

			if(isset($_POST['pass_first']) && isset($_POST['pass_second']))
			{
				if($_POST['pass_first'] == $_POST['pass_second'])
					$pass = $_POST['pass_first'];
				else
					$pass = $user_info[3];
			}
			else
				$pass = $user_info[3];

			$crypt = $user_info[4];


			update_user_info($fname, $lname, $email, $pass, $crypt);

			echo 'Valid user info has been updated, refresh page to see changes';

		}

		} else 
		{ 

			echo "Please <a href='login.php'>login</a> to view your profile";

		}
	 	?>

			</div>
		</div>

		<?php include("Components/footer.php"); ?>
	</body>
</html>