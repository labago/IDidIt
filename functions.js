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