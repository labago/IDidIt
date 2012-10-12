<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="jquery.tokeninput.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/token-input.css" />
	<script type="text/javascript" src="functions.js"></script>
	<script type="text/javascript">
	$(document).ready(function () {
	    $("#query").tokenInput("fb_find.php");
	});
	</script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Add Goal</h1>
				<br><br>
		<?php if(isset($_COOKIE['user']))
				   { ?>

		<?php if(!isset($_POST['submit'])) { ?>		
		    <form action="add-goal.php" method="post" name="add_goal_form">
		    	Title: <br>
		    	<input type="text" name="title" ><br>
		    	Category: <br>
		    	<select name="category" >
		    		<option></option>
		    		<option value="Resume Worthy">Resume Worthy</option>
		    		<option value="Personal goal">Personal goal</option>
		    		<option value="Career">Career</option>
		    		<option value="Athletic">Athletic</option>
		    		<option value="Financial">Financial</option>
		    		<option value="Family">Family</option>
		    		<option value="Other">Other</option>
		    	</select><br>
		    	Date Started:<br>
		    	<input type="date" name="date_s"><br>
		    	Date Ended: <br>
		    	<input type="date" name="date_e"><br>
		    	Picture URL: <br>
		    	<input type="text" name="pic"><br>     
		    	Description:<br>
		    	<textarea type="text" name="desc"></textarea><br>
		    	Witness:
		    	<input type="text" name="witness" id="query" />
		 
		    	<input type="submit" name="submit" value="Add Goal">
		    </form>
		    <br>
		<?php } else { 

			$title = $_POST['title'];
			$date_s = $_POST['date_s'];
			$date_e = $_POST['date_e'];
			$pic = $_POST['pic'];
			$desc = $_POST['desc'];
			$category = $_POST['category'];
			$crypt = $_COOKIE['user'];
			$witness = $_POST['witness'];

			add_new_goal($title, $date_s, $date_e, $pic, $desc, $crypt, $category, $witness);

			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=profile.php">'; 

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