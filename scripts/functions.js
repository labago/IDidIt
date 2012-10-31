function check_email() 
{
      var email = document.sign_up_form.email_first.value;
      document.getElementById("email1").innerHTML = ' <img src="styles/images/loading.gif" width="15">';
     $.ajax({
            type: "GET",
            url: "resources/ajax/java_check_email.php",
            data: "email="+email,
            success: function(data){
            if(data.trim() == "true")
            {
  			      document.getElementById("email1").innerHTML = '';
  			      document.getElementById("email4").innerHTML = ''; 
              document.getElementById("valid_email").value = 'true';
              return true; 
			      }
			      else 
            {
  			      document.getElementById("email1").innerHTML = '';
  			      document.getElementById("email4").innerHTML = 'Email is already in use<br>';    
              document.getElementById("valid_email").value = '';
              return false;
			      }
         }
    });
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

function add_pictures(goal, fb_pics, locals, album, crypt) {
    $('.submit').html("<img src='styles/images/loading.gif' style='width: 70px;'>");
     $.ajax({
            type: "GET",
            url: "resources/ajax/add_pics.php",
            data: "goal="+goal+"&p="+fb_pics+"&a="+album+"&l="+locals+"&crypt="+crypt,
            success: function(data){
                $('.submit').html("Added!");
                window.location = "view_album.php?g="+goal
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

function get_and_add_pictures(goal, album, crypt)
{
  var imgs = $('img.selected');
  var local_imgs = $('img.local_selected');

  var fb_pics = '';
  var locals = '';

  for(var i = 0; i < imgs.length; i++) 
  {
    fb_pics = fb_pics + "," + imgs[i].src;
  }
  for(var i = 0; i < local_imgs.length; i++) 
  {
    locals = locals + "," + local_imgs[i].src;
  }
  add_pictures(goal, fb_pics, locals, album, crypt);

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


  // ON PAGE LOAD
  $(document).ready(function () {

    if($.isFunction($.fn.cpwmHpCarousel))
    {
      // FOR SLIDESHOW
      $("div#cpwm_hero_wrapper").insertBefore($(".mainLayoutTable"));

       $(function() {
         $("#cpwm_hero_wrapper").cpwmHpCarousel({
          CE: false,
          auto: "once",
          autointerval: 3000,
          delay: 1000,
          autopause: 1,
          speed: 1000,
          easing: "easeOutQuint", //"easeOutExpo", //"easeInOutQuart", // see http://jqueryui.com/demos/effect/easing.html
          start: 0,
          scroll: 1,
          slideH: 450,
          slideW: 960,
          showLoading: ".showLoading",
          visible: 5
          });
      });
     }

     $(".panel-content").hide();
     $("div.row-large-single").hover(function(){
        $(this).find("img").hide();
        $(this).find("span.panel-content").show();
      }, 
      function(){
        $(this).find("img").show();
        $(this).find("span.panel-content").hide();
      });

     $("div.row-half-single").hover(function(){
        $(this).find("img").hide();
        $(this).find("span.panel-content").show();
      }, 
      function(){
        $(this).find("img").show();
        $(this).find("span.panel-content").hide();
      });
     // END SLIDESHOW

      // NOTIFICATIONS
      $(".notification-overlay").hide();
      $(".notification-click").click( function(){
        $(".notification-overlay").slideToggle();
        return false;
      });
      $(".not-count").html("("+$(".notification").length+")");

      //check = setInterval(function (){ get_new_goals();}, 5000);

     $("div.photo-select").find('img').click(function() {
          $(this).toggleClass("selected");
          return false;
      });  

     if($.isFunction($.fn.tokenInput))
     {
        $("#query").tokenInput("resources/ajax/fb_find.php");
     }

     if($.isFunction($.fn.validate))
     {
        // LOGIN FORM
        $("#login_form").validate({ 
          rules: {
            email: "required"
          }
        });
        // END LOGIN FORM

        // SIGN UP FORM
          jQuery.validator.addMethod("emailcheck", function(value, element) { 
              check_email();
            return (document.getElementById("valid_email").value == 'true');
          }, "Email is already in use");

        $("#sign_up_form").validate({
        rules: {
          fname: "required",
          lname: "required",
          email_first: "required",
          email_first: "emailcheck",
          email_second: "required",
          email_second: {
            equalTo: "#email_first"
          },
          pass_first: "required",
          pass_second: "required",
          pass_second: {
            equalTo: "#pass_first"
            }
          }
        });
        // END SIGN UP FORM

        // ADD GOAL FORM(s)
        $("#add_goal_form").validate({
          rules: {
            title: "required",
            cat: "required",
            date_s: "required",
            desc: "required"
          }
        });
        // END ADD GOAL FORM(s)

        // ACCOUNT FORM
        $("#account_form").validate({
        rules: {
          fname: "required",
          lname: "required",
          email_first: "required",
          email_first: "emailcheck",
          email_second: "required",
          email_second: {
            equalTo: "#email_first"
          },
          pass_first: "required",
          pass_second: "required",
          pass_second: {
            equalTo: "#pass_first"
            }
          }
        });
        // END ACCOUNT FORM

     }

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


