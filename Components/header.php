<div class="header">
	<h1>#IDIDIT</h1>
	<div class="login">
		<?php if(isset($_COOKIE['user']) || $facebook->getSession) { 

			if(isset($_COOKIE['user']))		
				$user_info = fetch_user_info($_COOKIE['user']);
			else
				$user_info = fetch_user_info_token($user);	

			if($facebook->getSession)
				echo "Logged in as ".$user_info[0]." <a href='".$logoutUrl."'>Logout</a>";
			else
				echo "Logged in as ".$user_info[0]." <a href='logout.php'>Logout</a>"; 
		} else { ?>
			Welcome, login with facebook <a href="<?php echo $loginUrl; ?>">here</a>
		<?php } ?>

	</div>
	<div class="main-nav">
		<div class="notifications">
			<table>
				<tr>
					<td><a href="#" class="notification-click">Notifications <span class="not-count"></span></a></td>
				</tr>
			</table>
			<div class="notification-overlay">
				<table>
					<?php
					if(isset($_COOKIE['user']))	
						echo get_notifications_html($_COOKIE['user']);
					?>
				</table>
			</div>
		</div>
		<div class="nav">
			<table>
				<tr>
					<td><a href="index.php">Home</a></td>
					<td><a href="profile.php">Profile</a></td>
					<td><a href="sign-up.php">Sign Up</a></td>
					<td><a href="account.php">Account</a></td>
					<td><a href="twitter-feed.php">#ididit</a></td>
					<td><a href="add-goal.php">Add Achievement</a></td>
				</tr>
			</table>
		</div>
	</div>
	<script type="text/javascript">
	$(".notification-overlay").hide();
	$(".notification-click").click( function(){
		$(".notification-overlay").slideToggle();
		return false;
	});

	if($(".notification").length != 0)
		$(".not-count").html("("+$(".notification").length+")");
	else
		$(".not-count").html("(None)");
	</script>
</div>
