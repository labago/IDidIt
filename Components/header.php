<div class="header">
	<img src="styles/images/ididit_logo.png" style="float: left; display: inline; padding-left: 20%; padding-right: 20px; height: 100%;">
	<div class="nav-items">
		<div class="bordered-header-link">
			<a href="#">MY ACHIEVEMENTS</a>
		</div>
		<div class="bordered-header-link">
			<a href="#">ADD NEW</a>
		</div>
	</div>
	<div class="login">
		<?php if(isset($_COOKIE['user'])) { 

			$user_info = fetch_user_info($_COOKIE['user']);	

			if($fb_user)
				echo "Logged in as ".$user_info[0]." <a href='".$logoutUrl."'>Logout</a>";
			else
				echo "Logged in as ".$user_info[0]." <a href='logout.php'>Logout</a>"; 
		} else { ?>
			Welcome, login with facebook <a href="<?php echo $loginUrl; ?>">here</a>
		<?php } ?>

	</div>
	<div class="right-header-items">
		<a href="#"><img src="styles/images/profile.png"></a>
		<a href="#"><img src="styles/images/search.png"></a>
	</div>
</div>
