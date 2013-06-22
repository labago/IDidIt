		<div class="footer">
			<div class="footer-column">
				
			</div>
			<div class="footer-column">

			</div>
			<div class="footer-column no-border">

			</div>
		</div>
	</div>
<script type="text/javascript">
<?php if(isset($_COOKIE['user'])){ ?>
get_notifications(<?php echo '"'.$_COOKIE['user'].'"'; ?>);
notification = setInterval(function (){ get_notifications(<?php echo '"'.$_COOKIE['user'].'"'; ?>);}, 5000);
<?php } ?>
</script>
