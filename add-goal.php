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
		 <div class="add-goal-form">
		    <form action="add-goal.php" method="post" name="add_goal_form" enctype="multipart/form-data">
		    	<h3 class="form-title">Personal</h3>
		    	Title*: <span id="title" ></span><br>
		    	<input type="text" name="title" onchange="check_el(this, 'title');"><br>
		    	<div class="add-goal-form-personal">
			    	Category*: <span id="cat" ></span><br>
			    	<select name="cat" onchange="check_el(this, 'cat');">
			    		<option></option>
			    		<option value="Resume Worthy">Resume Worthy</option>
			    		<option value="Personal goal">Personal goal</option>
			    		<option value="Career">Career</option>
			    		<option value="Athletic">Athletic</option>
			    		<option value="Financial">Financial</option>
			    		<option value="Family">Family</option>
			    		<option value="Other">Other</option>
			    	</select><br>
		    	</div>
		    	<div class="add-goal-form-professional">
			    	Company: <span id="prof" ></span><br>
			    	<input type="text" name="prof" onchange="check_el(this, 'prof');"><br>
			    	<!-- The Chosen Category -->
			    	<input type="hidden" name="cat" value="Professional" >
		    	</div>
		    	<div class="add-goal-form-educational">
			    	School/College/University: <span id="school" ></span><br>
			    	<input type="text" name="school" onchange="check_el(this, 'school');"><br>
			    	<!-- The Chosen Category -->
			    	<input type="hidden" name="cat" value="Educational" >
		    	</div>
		    	<div class="add-goal-form-philanthropic">
			    	Orginization: <span id="org" ></span><br>
			    	<input type="text" name="org" onchange="check_el(this, 'org');"><br>
			    	<!-- The Chosen Category -->
			    	<input type="hidden" name="cat" value="Educational" >
		    	</div>
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
		    	Witness: <span id="witness" ></span><br>
		    	<input type="text" name="witness" id="query" onchange="check_el(this, 'witness');"/>
		 
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
			$category = $_POST['cat'];
			$crypt = $_COOKIE['user'];
			$witness = $_POST['witness'];

			$school = $_POST['school'];
			$org = $_POST['org'];
			$prof = $_POST['prof'];
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

			switch ($category) {
				case 'Philanthropic':
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube, $org);
					break;

				case 'Professional':
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube, '', $prof);
					break;
				
				case 'Educational':
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube, '', '', $school);
					break;

				default:
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube);
					break;
			}

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