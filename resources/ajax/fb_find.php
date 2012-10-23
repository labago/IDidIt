<?php
include("../../functions.php");


$friends = $facebook->api('/me/friends', array('access_token' => $facebook->getAccessToken()));

$search = strtolower(trim($_GET["q"]));

$found = array();

foreach ($friends['data'] as $friend) {
	if(strpos(strtolower(trim($friend['name'])), $search) !== false)
		array_push($found, $friend);
}

// JSON-encode the response
$json_response = json_encode($found);

// Return the response
echo $json_response;

?>
