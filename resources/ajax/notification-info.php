<?php
include('../../functions.php');

$crypt = $_GET['crypt'];
$request = $_GET['r'];

switch ($request) {
	case 'get':
		echo get_notifications_html($crypt);
		break;
	
	default:
		# code...
		break;
}
?>