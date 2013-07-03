<?php include("functions.php"); ?>
<html>
	<title>IDidIt - Add Achievement</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/jquery.tokeninput.js"></script>
	<script type="text/javascript" src="scripts/jquery.validate.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/token-input.css" />
	<body>
	<div class="page">
		<div class="content">
			<?php include("Components/header.php"); ?>
			<div class="main-content">
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
		    <form class="add-goal" action="add-goal.php" method="post" name="add_goal_form" enctype="multipart/form-data" id="add_goal_form">
		    	<h3 class="form-title">Personal</h3>
		    	Title*: <br>
		    	<input type="text" name="title" id="title"><br>
		    	<div class="add-goal-form-personal">
			    	Category*: <br>
			    	<select name="cat" id="cat">
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
			    	Company: <br>
			    	<input type="text" name="prof"><br>
			    	<!-- The Chosen Category -->
			    	<input type="hidden" name="cat" value="Professional" >
		    	</div>
		    	<div class="add-goal-form-educational">
			    	School/College/University: <br>
			    	<input type="text" name="school"><br>
			    	<!-- The Chosen Category -->
			    	<input type="hidden" name="cat" value="Educational" >
		    	</div>
		    	<div class="add-goal-form-philanthropic">
			    	Orginization: <br>
			    	<input type="text" name="org"><br>
			    	<!-- The Chosen Category -->
			    	<input type="hidden" name="cat" value="Educational" >
		    	</div>
		    	Date Started*: <br>
		    	<input type="date" name="date_s" id="date_s"><br>
		    	Date Ended: <br>
		    	<input type="date" name="date_e"><br>
		    	Picture: <br>
		    	<input id="local" type="file" name="pic" size="10000000"><br>
		    	YouTube Video: <br>
		    	<input type="text" name="youtube"><br>    
		    	Description*: <br>
		    	<textarea type="text" name="desc" id="desc"></textarea><br>
		    	Witness: <br>
		    	<input type="text" name="witness" id="query"/>
		 
		    	<input type="submit" name="submit" value="Add Goal">
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

				$temp = "uploads/".$pic_name;
				$thumbnail = "uploads/thumbnails/".$pic_name;
				$pic_name = "uploads/".$pic_name;

				make_thumb($temp, $thumbnail, 100);

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
				$thumbnail = '';
			}

			switch ($category) {
				case 'Philanthropic':
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube, $org, '', '', $thumbnail);
					break;

				case 'Professional':
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube, '', $prof, '', $thumbnail);
					break;
				
				case 'Educational':
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube, '', '', $school, $thumbnail);
					break;

				default:
					add_new_goal($title, $date_s, $date_e, $pic_name, $desc, $crypt, $category, $witness, $youtube, '', '', '', $thumbnail);
					break;
			}

			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=profile.php">'; 

		}

		} else 
		{ 

			echo "Please <a href='login.php'>login</a> to view your profile";

		}
	 	?>


		<?php include("Components/footer.php"); ?>
	<script type="text/javascript" src="scripts/functions.js"></script>
	</body>
</html>