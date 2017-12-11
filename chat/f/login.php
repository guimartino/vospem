<?php
if(!session_id()) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once  "../fb/vendor/autoload.php"; // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => '1264011017036295',
  'app_secret' => 'c1642f39152539b59460933e65c5f0d0',
  'default_graph_version' => 'v2.11',
  //'default_access_token' => '{access-token}', // optional
]);

$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','public_profile','manage_pages','pages_show_list','read_page_mailboxes','pages_messaging']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://vospemtest1.herokuapp.com/chat/f/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';
