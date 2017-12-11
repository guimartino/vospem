<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . "/fb/vendor/autoload.php"; // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => '1264011017036295',
  'app_secret' => 'c1642f39152539b59460933e65c5f0d0',
  'default_graph_version' => 'v2.11',
  //'default_access_token' => '{access-token}', // optional
]);

// Use one of the helper classes to get a Facebook\Authentication\AccessToken entity.
   $helper = $fb->getRedirectLoginHelper();
//   $helper = $fb->getJavaScriptHelper();
//   $helper = $fb->getCanvasHelper();
//   $helper = $fb->getPageTabHelper();

try {
  // Get the \Facebook\GraphNodes\GraphUser object for the current user.
  // If you provided a 'default_access_token', the '{access-token}' is optional.
  $response = $fb->get('/me', 'EAAR9nHZBpogcBAIZC1kGY9HOqP9IXWoIYYwfJXv1ZAyvglkJ9nLOZC74Dgp9zNyXzpZA40pfExZCVNqtihJOQXpgAoCLdSsTiyjPGFF4IaY13zqCjXcGHiGFRpctmJwCU31xqUi7FfKxu2ZADAXwWmJMMPrpdXBN3NS3p8gZABKMKwZBeSWTxbyjFlugYOn4gs77ZCbZC0qJbMDGwZDZD');
} catch(\Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(\Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$me = $response->getGraphUser();
echo 'Logged in as ' . $me->getName();
