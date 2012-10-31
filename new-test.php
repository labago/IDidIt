<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<link rel="stylesheet" href="scripts/slideshow/demos/css/page.css">
	<link rel="stylesheet" href="scripts/slideshow/css/anythingslider.css">
	<script src="scripts/slideshow/js/jquery.easing.1.2.js"></script> 
	<script src="scripts/slideshow/js/jquery.anythingslider.min.js"></script> 
	<script src="scripts/slideshow/demos/colorbox/jquery.colorbox-min.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>Slideshow</h1>
				<br>
				<br>

				<style>
				#slider { width: 960px; height: 450px; }

				 div.anythingControls { 
				  bottom: 50px; /* thumbnail images are larger than the original bullets; move it up */ 
				} 
				 .anythingSlider-metallic .thumbNav a { 
				  background-image: url(); 
				  height: 30px; 
				  width: 30px; 
				  border: #000 1px solid; 
				  border-radius: 2px; 
				  -moz-border-radius: 2px; 
				  -webkit-border-radius: 2px; 
				  text-indent: 0; 
				 } 
				 .anythingSlider-metallic .thumbNav a span { 
				  visibility: visible; /* span changed to visibility hidden in v1.7.20 */ 
				 } 
				 /* border around link (image) to show current panel */ 
				 .anythingSlider-metallic .thumbNav a:hover, 
				 .anythingSlider-metallic .thumbNav a.cur { 
				  border-color: #fff; 
				 } 
				 /* reposition the start/stop button */ 
				 .anythingSlider-metallic .start-stop { 
				  margin-top: 15px; 
				 }
				</style>

				<script>
					// DOM Ready
					$(function(){
						$('#slider').anythingSlider({ 
					   toggleControls : false, 
					   theme          : 'metallic', 
					   navigationFormatter : function(i, panel){ // add thumbnails as navigation links 
					    return '<img src="demos/images/th-slide-' + ['civil-1', 'env-1', 'civil-2', 'env-2'][i - 1] + '.jpg">'; 
					   } 
					  })
						  // target all images inside the current slider 
				 	 // replace with 'img.someclass' to target specific images 
					  .find('.panel:not(.cloned) img') // ignore the cloned panels 
					   .attr('rel','group')            // add all slider images to a colorbox group 
					   .colorbox({ 
					     width: '90%', 
					     height: '90%', 
					     href: function(){ return $(this).attr('src'); }, 
					     // use $(this).attr('title') for specific image captions 
					     title: 'Press escape to close', 
					     rel: 'group' 
					   }); ;
					});
				</script>

				<ul id="slider">

				<li><img src="demos/images/slide-civil-1.jpg" alt=""></li>

				<li><img src="demos/images/slide-env-1.jpg" alt=""></li>

				<li><img src="demos/images/slide-civil-2.jpg" alt=""></li>

				<li><img src="demos/images/slide-env-2.jpg" alt=""></li>

				</ul>


			</div>
		</div>
		<?php include("Components/footer.php"); ?>
	</body>
</html>