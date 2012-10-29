<div class="footer">
	<span class="footer-content">
		<ul class="bottom-links">
			<li><a href="#">Contact</a></li>
			<li><a href="#">About</a></li>
			<li><a href="#">Terms and Conditions</a></li>
		</ul>
	</span>
</div>
<script type="text/javascript">
<?php if(isset($_COOKIE['user'])){ ?>
get_notifications(<?php echo '"'.$_COOKIE['user'].'"'; ?>);
notification = setInterval(function (){ get_notifications(<?php echo '"'.$_COOKIE['user'].'"'; ?>);}, 5000);
<?php } ?>
</script>
