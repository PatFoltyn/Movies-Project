<?php
session_start();
require 'autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

define('CONSUMER_KEY','eUUiVJsnNlbb1AhdMwNx9INOj');
define('CONSUMER_SECRET', 'x2DZPa8agxdhaRb0cjChCtXsSgHUCtSyBEcuoOAbWUsMOkJgMn');
define('OAUTH_CALLBACK', 'https://moviesproject.com/twitter_app/callback.php');

if (!isset($_SESSION['access_token'])) {
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
  $request_token = $connection->oauth('oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));
  $_SESSION['oauth_token'] = $request_token['oauth_token'];
  $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
  $url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
  header('Location: ' . $url);
} else {
  $access_token = $_SESSION['access_token'];
  $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
  $user = $connection->get("account/verify_credentials");
  include 'db_insert_user.php';
  include 'grab_info.php';
  $_SESSION['logged_in'] = True;
  header('Location: ../');
  exit();
}
 ?>
