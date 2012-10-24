function check_emails()
{
  
  var pwd1 = document.sign_up_form.email_first.value;
  var pwd2 = document.sign_up_form.email_second.value;
  
  if(pwd1 == pwd2)
  {
    document.getElementById("email1").innerHTML = ' <img src="styles/images/check.png" width="15">';
    document.getElementById("email2").innerHTML = ' <img src="styles/images/check.png" width="15">';
    document.getElementById("email3").innerHTML = '';  
    return true;
  }
  else 
  {
    document.getElementById("email1").innerHTML = ' <img src="styles/images/xmark.png" width="15">';  
    document.getElementById("email2").innerHTML = ' <img src="styles/images/xmark.png" width="15">';  
    document.getElementById("email3").innerHTML = ' Emails do not match, please re-enter<br>';  
    return false;
  } 
}

function check_passwords()
{
  
  var pwd1 = document.sign_up_form.pass_first.value;
  var pwd2 = document.sign_up_form.pass_second.value;
  
  if(pwd1 == pwd2)
  {
    document.getElementById("pass1").innerHTML = ' <img src="styles/images/check.png" width="15">';
    document.getElementById("pass2").innerHTML = ' <img src="styles/images/check.png" width="15">';
    document.getElementById("pass3").innerHTML = '';    
    return true;
  }
  else 
  {
    document.getElementById("pass1").innerHTML = ' <img src="styles/images/xmark.png" width="15">';  
    document.getElementById("pass2").innerHTML = ' <img src="styles/images/xmark.png" width="15">';  
    document.getElementById("pass3").innerHTML = 'Passwords do not match, please re-enter<br>';  
    return false;
  } 
}

function check_email() 
{
      var email = document.sign_up_form.email_first.value;
      document.getElementById("email1").innerHTML = ' <img src="styles/images/loading.gif" width="15">';
     $.ajax({
            type: "GET",
            url: "resources/ajax/java_check_email.php",
            data: "email="+email,
            success: function(data){
            if(data == "true")
            {
  			      document.getElementById("email1").innerHTML = ' <img src="styles/images/check.png" width="15">';
  			      document.getElementById("email4").innerHTML = ''; 
              return true; 
			      }
			      else 
            {
  			      document.getElementById("email1").innerHTML = ' <img src="styles/images/xmark.png" width="15">';
  			      document.getElementById("email4").innerHTML = 'Email is already in use<br>';    
              return false;
			      }
         }
    });
}

function check_email2() 
{
  if(document.getElementById("email4").innerHTML == '')
  {
    return true;
  }
  else
  {
    return false;
  }
}

function check_sign_up_form()
{
  if(check_email2() && check_emails() && check_last() && check_first() && check_passwords())
  {
    return true;
  }
  else
  {
    alert("All required fields must be filled out");
    return false;
  }
}

function congrats(user, goal, el) 
{
      //var email = document.sign_up_form.email_first.value;
      //document.getElementById("email1").innerHTML = ' <img src="loading.gif" width="15">';
     $.ajax({
            type: "GET",
            url: "resources/ajax/add_congrats.php",
            data: "user="+user+"&goal="+goal,
            success: function(data){
                el.parentNode.innerHTML = "Thanks!";
                document.getElementById(goal).innerHTML = data; 
            }
    });
}

function get_new_goals() {
    var count = $('.stream-goal').size() + $('.stream-goal-small').size();
     $.ajax({
            type: "GET",
            url: "resources/ajax/get_new_goals.php",
            data: "count="+count,
            success: function(data){
              if(data.trim() != '')
              {
                var stream = document.getElementById("stream");
                $('div.stream').hide().html(data+stream.innerHTML).fadeIn();
              }
            }
    });
}

function get_notifications(crypt) {
     $.ajax({
            type: "GET",
            url: "resources/ajax/notification-info.php",
            data: "crypt="+crypt+"&r=get",
            success: function(data){
                $('.notification-overlay').html("<table>"+data+"</table>");
                $(".not-count").html("("+$(".notification").length+")");
            }
    });
}

function add_pictures(crypt, pictures, album) {
    $('.submit').html("<img src='styles/images/loading.gif' style='width: 70px;'>");
     $.ajax({
            type: "GET",
            url: "resources/ajax/add_pics.php",
            data: "crypt="+crypt+"&p="+pictures+"&a="+album,
            success: function(data){
                $('.submit').html("Added!");
                window.location = "view_album.php?g="+crypt
            }
    });
}

function htmlEncode(value){
    if (value) {
        return $('<div />').text(value).html();
    } else {
        return '';
    }
}

function add_comment(goal) {
  var comment = document.getElementById('comment-text').value;
  document.getElementById('comment-text').value = '';
  comment = htmlEncode(comment);
     $.ajax({
            type: "GET",
            url: "resources/ajax/add_comment.php",
            data: "g="+goal+"&c="+comment,
            success: function(data){
              if(data.trim() != '')
              {
                $('div.comment-content').hide().html(data).fadeIn();
              }
            }
    });
    return false;
}

function get_and_add_pictures(crypt, album)
{
  var imgs = $('img.selected');

  var value = '';

  if(imgs.length != 0)
  {
    for(var i = 0; i < imgs.length; i++) 
    {
      value = value + "," + imgs[i].src;
    }
    add_pictures(crypt, value, album);
  }
  else
  {
    alert("No pictures selected!");
    return false;
  }

}

function check_el(el, span)
{
  var title = el.value;
  
  if(title.length > 0)
  {
    document.getElementById(span).innerHTML = ' <img src="styles/images/check.png" width="15">';  
    return true;
  }
  else 
  {
    document.getElementById(span).innerHTML = ' <img src="styles/images/xmark.png" width="15">';
    return false;    
  } 
}

function check_add_goal_form(form)
{
  if((form.title.value != '') && (form.category.value != '') && (form.date_s.value != '') && (form.desc.value != ''))
  {
    return true;
  }
  else
  {
    alert("All required fields must be filled out");
    return false;
  }
}

function select_all_pics_toggle(){
  if(one_selected())
  {
    $("div.photo-select").find('img').removeClass("selected");
    $("div.photo-select").find('img').addClass("selected");
  }
  else if(all_selected())
  {
    $("div.photo-select").find('img').removeClass("selected");
  }
  else
   {
    $("div.photo-select").find('img').addClass("selected");
   } 
}

function all_selected(){
  var imgs = $("div.photo-select").find('img');
  for (var i = 0; i < imgs.length; i++) 
  {
    if(imgs[i].className.indexOf("selected") == -1)
    {
      return false;
    }
  }
  return true;
}

function one_selected(){
  if(all_selected())
  {
    return false
  }
  var imgs = $("div.photo-select").find('img');
  for (var i = 0; i < imgs.length; i++) 
  {
    if(imgs[i].className.indexOf("selected") != -1)
    {
      return true;
    }
  }
  return false;
}





    // notifications
    $(".notification-overlay").hide();
    $(".notification-click").click( function(){
    $(".notification-overlay").slideToggle();
      return false;
    });
    $(".not-count").html("("+$(".notification").length+")");

  $(document).ready(function () {

     $("div.photo-select").find('img').click(function() {
          $(this).toggleClass("selected");
          return false;
      });

      $("#query").tokenInput("resources/ajax/fb_find.php");

      $(".add-goal-form").hide();
      $(".add-goal-form-professional").hide();
      $(".add-goal-form-educational").hide();
      $(".add-goal-form-philanthropic").hide();

      $(".personal").click( function(){
        $(".add-goal-form").hide();
        $(".add-goal-form-professional").hide();
        $(".add-goal-form-philanthropic").hide();
        $(".add-goal-form-educational").hide();
        $(".add-goal-form-personal").show();
        $(".form-title").html("Personal");
        $(".add-goal-form").fadeIn("slow");
        return false;
      });

      $(".philanthropic").click( function(){
        $(".add-goal-form").hide();
        $(".add-goal-form-professional").hide();
        $(".add-goal-form-philanthropic").show();
        $(".add-goal-form-educational").hide();
        $(".add-goal-form-personal").hide();
        $(".form-title").html("Philanthropic");
        $(".add-goal-form").fadeIn("slow");
        return false;
      });

      $(".educational").click( function(){
        $(".add-goal-form").hide();
        $(".add-goal-form-professional").hide();
        $(".add-goal-form-philanthropic").hide();
        $(".add-goal-form-educational").show();
        $(".add-goal-form-personal").hide();
        $(".form-title").html("Educational");
        $(".add-goal-form").fadeIn("slow");
        return false;
      });

      $(".professional").click( function(){
        $(".add-goal-form").hide();
        $(".add-goal-form-professional").show();
        $(".add-goal-form-philanthropic").hide();
        $(".add-goal-form-educational").hide();
        $(".add-goal-form-personal").hide();
        $(".form-title").html("Professional");
        $(".add-goal-form").fadeIn("slow");
        return false;
      });
  });

