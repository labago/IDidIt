<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<script type="text/javascript" src="scripts/functions.js"></script>
	<script type="text/javascript" src="scripts/slideshow-test/second.js?20121016-1"></script>
	<script type="text/javascript" src="scripts/slideshow-test/first.js?20121016-2"></script>
	<script type="text/javascript" src="scripts/slideshow-test/easing.js"></script>
	<link href="scripts/slideshow-test/css.css?20121002-1" rel="stylesheet" type="text/css" />

	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Slideshow</h1>
				<br>
				<br>

				<div id="cpwm_hero_wrapper">
					<a href="#" class="arrow prev" id="arrowleft"></a>
				  	<div id=transleft class="trans" ></div>
				  	<div id=transright class="trans" ></div>
					<a href="#" class="next arrow" id="arrowright"></a>
					<div class="homeslider" id="cpwm_hero_slider">
						<div class="preload" id="preloadimgs"><img src="test-images/trans.png"/><img src="test-images/trans2.png"/></div>
						<ul>
							<li>
						        <img src="test-images/a1.jpg" width="960" height="450" alt="" class="showLoading"/>
							</li>
							<li>
						        <img src="test-images/a2.jpg" width="960" height="450" alt="" class="showLoading"/>
							</li>
							<li>
						        <img src="test-images/a3.jpg" width="960" height="450" alt="" class="showLoading"/>
							</li>
							<li>
						        <img src="test-images/a4.jpg" width="960" height="450" alt="" class="showLoading"/>
							</li>
					    </ul>
					</div>
				</div>

<script>	
$(document).ready(function () {
	// fix for ML DOM structure
	$("div#cpwm_hero_wrapper").insertBefore($(".mainLayoutTable"));

	 $(function() {
	   $("#cpwm_hero_wrapper").cpwmHpCarousel({
			CE: false,
			auto: "once",
			autointerval: 3000,
			delay: 1000,
			autopause: 5000,
			speed: 1000,
			easing: "easeOutQuint", //"easeOutExpo", //"easeInOutQuart", // see http://jqueryui.com/demos/effect/easing.html
			start: 0,
			scroll: 1,
			slideH: 450,
			slideW: 960,
			showLoading: ".showLoading",
			visible: 3
			});
	});
});
</script>


			</div>
		</div>
		<?php include("Components/footer.php"); ?>
	</body>
</html>