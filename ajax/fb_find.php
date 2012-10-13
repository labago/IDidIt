<?

#
# Example PHP server-side script for generating
# responses suitable for use with jquery-tokeninput
#

# Connect to the database
include('../functions.php');

$friends = $facebook->api('/me/friends');

$search = strtolower(trim($_GET["q"]));

$found = array();

foreach ($friends['data'] as $friend) {
	if(strpos(strtolower(trim($friend['name'])), $search) !== false)
		array_push($found, $friend);
}

# JSON-encode the response
$json_response = json_encode($found);

# Optionally: Wrap the response in a callback function for JSONP cross-domain support
if($_GET["callback"]) {
    $json_response = $_GET["callback"] . "(" . $json_response . ")";
}

# Return the response
echo $json_response;

?>
