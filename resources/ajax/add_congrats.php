<?php
include('../../functions.php');

$user = $_GET['user'];
$goal = $_GET['goal'];

$query = "SELECT * 
FROM  `Goal` 
WHERE  `Crypt` LIKE  '$goal'
LIMIT 0 , 30";

$result = mysql_query($query);

$row = mysql_fetch_row($result);

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

mysql_query($query);

echo sizeof(explode(",",$new_congradulators));
?>
