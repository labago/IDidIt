<?php include("functions.php"); ?>
<html>
	<title>IDidIt</title>
	<head>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<script type="text/javascript" src="scripts/jquery.js"></script>
	<body>
		<?php include("Components/header.php"); ?>

		<div class="page">
			<div class="content">
				<h1>#ididit</h1>
				<br><br><br>

			<?php 

				require_once ("resources/api/twitter/twitteroauth.php");

				$twitter = new TwitterOAuth("jdZBZzna7KmUuwUSFPZkw", "tKcUNrlgnQVx0bj7bUWaH3wKLS434gMm47bUEewkSw", "245096759-MFLFmuF9tGnFdwFajg1Nq0SM2aVdV6muZCFbiBDg", "eHht8TbYkXHCjIHwrGoZyQCrnjE0mpdX8mBN9LmVzE");

				// The fetch url with the given username appended to it.
				// $trends_url = "http://twitter.com/statuses/user_timeline/".$u.".xml";

				$url = 'http://search.twitter.com/search.atom?q='.urlencode("#ididit");

			    $xml = $twitter->oAuthRequest($url, 'GET', array());

			    $affected = 0;
			    $twelement = new SimpleXMLElement($xml);
			    foreach ($twelement->entry as $entry) {
			        $text = trim($entry->title);
			        $author = trim($entry->author->name);
			        $time = strtotime($entry->published);
			        $id = $entry->id;
			        echo "<div class='tweet'>";
			        echo "<p>Tweet from ".$author.": <br><br><b>".$text."</b>  <em><br>Posted ".date('n/j/y g:i a',$time)."</em></p>";
			        echo "</div>";
			        echo '<div class="space"></div>';
			    }

			?>


			</div>
		</div>

		<script type="text/javascript" src="scripts/functions.js"></script>
		<?php include("Components/footer.php"); ?>
	</body>
</html>