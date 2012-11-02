<?php
include('../../functions.php');

$goal = $_GET['goal'];
$raw_fb_pics = $_GET['p'];
$raw_local_pics = $_GET['l'];
$album_id = $_GET['a'];
$crypt = $_GET['crypt'];

$album = json_encode(explode(",", $raw_fb_pics));
$locals = json_encode(explode(",", $raw_local_pics));

add_album($locals, $album, $album_id, $_COOKIE['user'], $goal, $crypt);
?>
