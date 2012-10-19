<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/jquery.tokeninput.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/token-input.css" />
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Add Goal</h1>
				<br><br>
		<?php if(isset($_COOKIE['user']))
				   { ?>

		<?php if(!isset($_POST['submit'])) {
		 ?>		

		 <div class="goal-form-header">
		 	<img src="styles/images/achievement-header-test.jpg">

		 	<div class="buttons">
			 	<a class="personal" href="#"></a>
			 	<a class="educational" href="#"></a>
			 	<a class="professional" href="#"></a>
			 	<a class="philanthropic" href="#"></a>
		 	</div>
		 </div>
		 <div class="add-goal-form-personal">
		    <form action="add-goal.php" method="post" name="add_goal_form" enctype="multipart/form-data">
		    	<h3>Personal</h3>
		    	Title*: <span id="title" ></span><br>
		    	<input type="text" name="title" onchange="check_el(this, 'title');"><br>
		    	Category*: <span id="category" ></span><br>
		    	<select name="category" onchange="check_el(this, 'category');">
		    		<option></option>
		    		<option value="Resume Worthy">Resume Worthy</option>
		    		<option value="Personal goal">Personal goal</option>
		    		<option value="Career">Career</option>
		    		<option value="Athletic">Athletic</option>
		    		<option value="Financial">Financial</option>
		    		<option value="Family">Family</option>
		    		<option value="Other">Other</option>
		    	</select><br>
		    	Date Started*: <span id="date" ></span><br>
		    	<input type="date" name="date_s" onchange="check_el(this, 'date');"><br>
		    	Date Ended: <br>
		    	<input type="date" name="date_e"><br>
		    	Picture: <br>
		    	<input id="local" type="file" name="pic" size="10000000"><br>
		    	YouTube Video: <br>
		    	<input type="text" name="youtube"><br>    
		    	Description*: <span id="desc" ></span><br>
		    	<textarea type="text" name="desc" onchange="check_el(this, 'desc');"></textarea><br>
		    	Witness*: <span id="witness" ></span><br>
		    	<input type="text" name="witness" id="query" onchange="check_el(this, 'witness');"/>
		 
		    	<input type="submit" name="submit" value="Add Goal" onclick="return check_add_goal_form(document.add_goal_form);">
		    </form>
		</div>
		<div class="add-goal-form-professional">
		    <form action="add-goal.php" method="post" name="add_goal_form" enctype="multipart/form-data">
		    	<h3>Professional</h3>
		    	Title*: <span id="title" ></span><br>
		    	<input type="text" name="title" onchange="check_el(this, 'title');"><br>
		 
		    	<input type="submit" name="submit" value="Add Goal" onclick="return check_add_goal_form(document.add_goal_form);">
		    </form>
		</div>
 		<div class="add-goal-form-educational">
		    <form action="add-goal.php" method="post" name="add_goal_form" enctype="multipart/form-data">
		    	<h3>Educational</h3>
		    	Title*: <span id="title" ></span><br>
		    	<input type="text" name="title" onchange="check_el(this, 'title');"><br>
		 
		    	<input type="submit" name="submit" value="Add Goal" onclick="return check_add_goal_form(document.add_goal_form);">
		    </form>
		</div>
		 <div class="add-goal-form-philanthropic">
		    <form action="add-goal.php" method="post" name="add_goal_form" enctype="multipart/form-data">
		    	<h3>Philanthropic</h3>
		    	Title*: <span id="title" ></span><br>
		    	<input type="text" name="title" onchange="check_el(this, 'title');"><br>
		 
		    	<input type="submit" name="submit" value="Add Goal" onclick="return check_add_goal_form(document.add_goal_form);">
		    </form>
		</div>
		    <br>
		<?php } else if(isset($_POST['submit'])) { 

			$title = htmlentities(strip_tags($_POST['title']), ENT_QUOTES);
			$date_s = $_POST['date_s'];
			$date_e = $_POST['date_e'];
			$youtube = $_POST['youtube'];
			$desc = htmlentities(strip_tags($_POST['desc']), ENT_QUOTES);
			$category = $_POST['category'];
			$crypt = $_COOKIE['user'];
			$witness = $_POST['witness'];
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

				$pic_name = "http://www.i-did-it.net/uploads/".$pic_name;

				//need to update database here and refresh page
				}
				}
				else {

				// need an error message here stating that the file was not of the picture variety
				}
			}
			else
			{
				$pic_name = '';
			}

			add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube);

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
	<script type="text/javascript" src="scripts/functions.js"></script>
	</body>
</html>