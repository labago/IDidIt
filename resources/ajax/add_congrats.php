<?php
include('../../functions.php');

$user = $_GET['user'];
$goal = $_GET['goal'];

$db->db_connect();

$query = "SELECT * 
FROM  `Goal` 
WHERE  `Crypt` LIKE  '$goal'
LIMIT 0 , 30";

$result = $db->db_query($query);

$row = $db->db_fetch_row($result);

$congradulators = $row[9];

$new_congradulators = $congradulators;
if(strpos($congradulators, $user) === false)
{
	if($new_congradulators != '')
		$new_congradulators .= ",".$user;
	else
		$new_congradulators .= $user;
}

$query = "UPDATE `ididit`.`Goal` SET `Congradulators` = '$new_congradulators' WHERE `Goal`.`Crypt` = '$goal' LIMIT 1 ;";

$db->db_query($query);

echo sizeof(explode(",",$new_congradulators));
?>
