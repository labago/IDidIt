<?php
include('../../functions.php');

$goal = $_GET['crypt'];
$raw_pictures = $_GET['p'];
$album_id = $_GET['a'];

$album = json_encode(explode(",", $raw_pictures));

$db->db_connect();

$query = "UPDATE `ididit`.`Goal` SET `Album` = '$album', `From FB Album` = '$album_id' WHERE `Goal`.`Crypt` = '$goal' LIMIT 1 ;";

$db->db_query($query);
?>
