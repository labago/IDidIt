<?php include("functions.php"); ?>
<html>
	<title>IDidIt - My Account</title>
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
				<h1>My Account</h1>
				<br><br>
		<?php if(isset($_COOKIE['user']))
				   { ?>

		<?php if(!isset($_POST['submit'])) { ?>		
		    <form class="account-form" action="account.php" method="post" name="sign_up_form" enctype="multipart/form-data" id="account_form">
		    	First Name: <br>
		    	<input type="text" name="fname" id="fname" value="<?php echo $user_info[0]; ?>"><br>
		    	Last Name: <br>
		    	<input type="text" name="lname" id="lname" value="<?php echo $user_info[1]; ?>"><br>
		    	<b id="email4"></b> 
		    	Email: <span id="email1" ></span><br>
		    	<input type="text" name="email_first" id="email_first" value="<?php echo $user_info[2]; ?>" class="email"><br>
		    	Email Confirmation: <br>
		    	<input type="text" name="email_second" id="email_second" value="<?php echo $user_info[2]; ?>"><br>     
		    	New Password:<br>
		    	<input type="password" name="pass_first" id="pass_first"><br>
		    	New Password Confirmation:<br>
		    	<input type="password" name="pass_second" id="pass_second"><br>
		    	Profile Picture: <br>
		    	<img src="<?php echo $user_info[5]; ?>" alt="current profile pic" style="max-width: 200px;"><br><br>
				<input id="local" type="file" name="pic" size="10000000"><br>
				<input type="hidden" name="valid_email" id="valid_email" value="">

		    	<input type="submit" name="submit" value="Update">
		    </form>
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


				change_user_pic($_COOKIE['user'], "http://www.i-did-it.net/uploads/".$pic_name);

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

			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=account.php">';

		}

		} else 
		{ 

			echo "Please <a href='login.php'>login</a> to view your profile";

		}
	 	?>

		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>