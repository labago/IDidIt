<?php
data_connect();


function check_crypt_user($crypt){


	$query = "SELECT * 
	FROM  `Users` 
	WHERE  `Crypt` LIKE  '$crypt'
	LIMIT 0 , 30";  
	  
	$result = mysql_query($query);

	if(mysql_num_rows($result) != 0){
	return false;  
	}  
	return true;
  
}

function gen_rand_hex(){
	srand((double)microtime()*1000000);

	$decnumber = rand(0, 16777215);

	$colorcode = dechex($decnumber);

	return $colorcode;
}

function add_user($fname, $lname, $pass, $email){

	$crypt = gen_rand_hex();  
	while(!check_crypt_user($crypt)) {  
	$crypt = gen_rand_hex();
	} 

	$query = "INSERT INTO `ididit`.`Users` (
			`First Name` ,
			`Last Name` ,
			`Email` ,
			`Password`,
			`Crypt`
			)
			VALUES (
			'$fname', '$lname', '$email', '$pass', '$crypt'
			);";

	mysql_query($query);

	return $crypt;
}

function data_connect() {
  
$host = "data.justdidthat.com"; 
$user = "jlane09"; 
$pass = "counter";  
$db = "ididit";

// open connection 
$connection = mysql_connect($host, $user, $pass) or die ("Unable to connect!"); 
    
mysql_select_db($db) or die ("Unable to select database!");    
}

function fetch_user_info($crypt){
  
$query = "SELECT * 
FROM  `Users` 
WHERE  `Crypt` LIKE  '$crypt'
LIMIT 0 , 30";  
  
$result = mysql_query($query);
$row = mysql_fetch_row($result);

$info = array();

array_push($info, $row[0]);
array_push($info, $row[1]);
array_push($info, $row[2]);
array_push($info, $row[3]);
array_push($info, $row[4]);

return $info;
}





?>
<script>
function check_emails(){
  
  var pwd1 = document.sign_up_form.email_first.value;
  var pwd2 = document.sign_up_form.email_second.value;
  
  if(pwd1 == pwd2){
  document.getElementById("email1").innerHTML = ' <img src="check.png" width="15">';
  document.getElementById("email2").innerHTML = ' <img src="check.png" width="15">';
  document.getElementById("email3").innerHTML = '';  
  }
  else {
  document.getElementById("email1").innerHTML = ' <img src="xmark.png" width="15">';  
  document.getElementById("email2").innerHTML = ' <img src="xmark.png" width="15">';  
  document.getElementById("email3").innerHTML = ' Emails do not match, please re-enter<br>';  
  } 
}

function check_passwords(){
  
  var pwd1 = document.sign_up_form.pass_first.value;
  var pwd2 = document.sign_up_form.pass_second.value;
  
  if(pwd1 == pwd2){
  document.getElementById("pass1").innerHTML = ' <img src="check.png" width="15">';
  document.getElementById("pass2").innerHTML = ' <img src="check.png" width="15">';
  document.getElementById("pass3").innerHTML = '';    
  }
  else {
  document.getElementById("pass1").innerHTML = ' <img src="xmark.png" width="15">';  
  document.getElementById("pass2").innerHTML = ' <img src="xmark.png" width="15">';  
  document.getElementById("pass3").innerHTML = 'Passwords do not match, please re-enter<br>';  
  } 
}

function check_first(){
  
  var first = document.sign_up_form.fname.value;
  
  if(first.length > 0){
  document.getElementById("first").innerHTML = ' <img src="check.png" width="15">';  
  }
  else {
  document.getElementById("first").innerHTML = ' <img src="xmark.png" width="15">';    
  } 
}

function check_last(){
  
  var first = document.sign_up_form.lname.value;
  
  if(first.length > 0){
  document.getElementById("last").innerHTML = ' <img src="check.png" width="15">';  
  }
  else {
  document.getElementById("last").innerHTML = ' <img src="xmark.png" width="15">';    
  } 
}

function check_email() {
      var email = document.sign_up_form.email_first.value;
      document.getElementById("email1").innerHTML = ' <img src="loading.gif" width="15">';
     $.ajax({
            type: "GET",
            url: "java_check_email.php",
            data: "email="+email,
            success: function(data){
                  if(data == "true"){
			      document.getElementById("email1").innerHTML = ' <img src="check.png" width="15">';
			      document.getElementById("email4").innerHTML = '';  
			      }
			      else {
			      document.getElementById("email1").innerHTML = ' <img src="xmark.png" width="15">';
			      document.getElementById("email4").innerHTML = 'Email is already in use<br>';    
			      }
             }
    });
}
</script>