<div class="header">
	<h1>IDidIt</h1>
	<div class="login">
		<?php if(isset($_COOKIE['user']) || $facebook->getSession) { 

			if(isset($_COOKIE['user']))		
				$user_info = fetch_user_info($_COOKIE['user']);
			else
				$user_info = fetch_user_info_token($user);	

			echo "Logged in as ".$user_info[0]." <a href='".$logoutUrl."'>Logout</a>"; 
		} else { ?>
			Welcome, login with facebook <a href="<?php echo $loginUrl; ?>">here</a>
		<?php } ?>

	</div>

	<span class="header-nav">
		<ul class="nav">
			<li><a href="index.php">Home</a></li>
			<li><a href="profile.php">Profile</a></li>
			<li><a href="sign-up.php">Sign Up</a></li>
			<li><a href="account.php">Account</a></li>
		</ul>
	</span>
</div>
