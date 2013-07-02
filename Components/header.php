<div class="header">
	<div class="header-logo">
		<a href="/"><img src="styles/images/ididit-header-logo.png"></a>
	</div>
	<div class="nav-items">
		<a href="profile.php">
			<div class="bordered-header-link bordred-header-link-left-right">
				<p>MY ACHIEVEMENTS</p>
			</div>
		</a>
		<a href="add-goal.php">
			<div class="bordered-header-link bordred-header-link-right">
				<p>ADD NEW</p>
			</div>
		</a>
	</div>
	<div class="right-header-items">
		<a href="#"><img src="styles/images/profile.png"></a>
		<input type="text" class="search-box" value="Search..." onclick="this.value = '';">
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
