<?php
require_once('resources/api/facebook/facebook.php');
require_once('Private/creds.php');
session_start();

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => $fb_app_key,
  'secret' => $fb_app_secret,
  'cookie' => true,
));

//$new_token = file_get_contents("https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=".$fb_app_key."&client_secret=".$fb_app_secret."&fb_exchange_token=".$old_token);

// Get User ID
$fb_user = $facebook->getUser();

if ($fb_user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_info = fetch_user_info_token($fb_user);
    $token = @$user_info[7];
    $crypt = @$user_info[4];

    $user_profile = $facebook->api('/me', array('access_token' => $token));
  } catch (FacebookApiException $e) {
    error_log($e);
    $fb_user = false;
  }
}

if($fb_user && !(is_logged_out_fb($crypt) == 'true'))
{
  setcookie("user", $crypt, time()+2592000);
}
else
{
  $fb_user = false;
}


$logout_params = array( 'next' => $fb_logout);
$login_params = array(
  'scope' => 'email, user_photos',
  'redirect_uri' => $fb_login
  );
$loginUrl = $facebook->getLoginUrl($login_params);
$logoutUrl = $facebook->getLogoutUrl($logout_params);
?>