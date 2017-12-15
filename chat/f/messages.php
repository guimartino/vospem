<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();
echo "Inicio";
/* PHP SDK v5.0.0 */
/* make the API call */
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get(
    '/720577281466461/conversations',
    ''.$_SESSION['fb_access_token']
  );
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}
$graphNode = $response->getGraphNode();
print_r($graphNode);
/* handle the result */
echo "fim";
