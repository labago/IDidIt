		<div class="footer">
			<div class="footer-column">
				<div class="footer-column-content">
					<img src="styles/images/ididit-header-logo.png" style="height: 40px;">
					<br>
					&copy; 2013 ididit. All Rights Reserved
				</div>
			</div>
			<div class="footer-column">
				<div class="footer-column-content">
					<h2>Stay Connected</h2>
					<img src="styles/images/facebook_logo.png" style="height: 60px;">
				</div>
			</div>
			<div class="footer-column">
				<div class="footer-column-content no-border">
					<h2>Contact Us?</h2>
					<p style="float: left;">For more information please<br>
						<a href="#">Click Here</a>
					</p>
					<img src="styles/images/info_bubble.png" style="float: right; height: 60px; padding-right: 20px;">
				</div>
			</div>
		</div>
	</div>
	<div class="bottom-page-links">
		<p><a href="#">Terms of Use</a> | <a href="#">Privacy Policy</a> | <a href="#">Purchase Terms and Conditions</a> | <a href="#">Refunds and Returns Policy</a> | neverlandsales 2012</p>
	</div>
</div>
			<!-- <div class="social-media-buttons">
				<a href="#"><img src="styles/images/google-button.png"></a>
				<a href="#"><img src="styles/images/twitter-button.png"></a>
				<a href="#"><img src="styles/images/facebook-button.png"></a>
			</div> -->
		</div>
<script type="text/javascript">
<?php if(isset($_COOKIE['user'])){ ?>
get_notifications(<?php echo '"'.$_COOKIE['user'].'"'; ?>);
notification = setInterval(function (){ get_notifications(<?php echo '"'.$_COOKIE['user'].'"'; ?>);}, 5000);
<?php } ?>
</script>
