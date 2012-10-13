<?php
require 'resources/api/facebook/facebook.php';

// Create our Application instance (replace this with your appId and secret).
$facebook = new Facebook(array(
  'appId'  => '204806049653341',
  'secret' => 'e5a3bb77981baae5711ec31d1355da4b',
  'cookie' => true,
));

// Get User ID
$user = $facebook->getUser();

// We may or may not have this data based on whether the user is logged in.
//
// If we have a $user id here, it means we know the user is logged into
// Facebook, but we don't know if the access token is valid. An access
// token is invalid if the user logged out of Facebook.

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

$logout_params = array( 'next' => 'http://www.justdidthat.com/logout.php' );
$login_params = array(
  'scope' => 'email',
  'redirect_uri' => 'http://www.justdidthat.com/fb_login.php'
  );
$loginUrl = $facebook->getLoginUrl($login_params);
$logoutUrl = $facebook->getLogoutUrl($logout_params);
?>