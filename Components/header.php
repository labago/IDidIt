<?php include("functions.php"); ?>
<div class="header">
	<h1>IDidIt</h1>
	<div class="login">
		<?php if(isset($_COOKIE['user'])) { 

			$user_info = fetch_user_info($_COOKIE['user']);

			echo "Logged in as ".$user_info[0]." <a href='logout.php'>Logout</a>"; 
		} else { ?>
			Welcome, login <a href="login.php">here</a>
		<?php } ?>

	</div>

	<span class="header-nav">
		<ul class="nav">
			<li><a href="index.php">Home</a></li>
			<li><a href="#">Profile</a></li>
			<li><a href="sign-up.php">Sign Up</a></li>
			<li><a href="#">Search</a></li>
		</ul>
	</span>
</div>
