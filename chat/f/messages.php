<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();


/* PHP SDK v5.0.0 */
/* make the API call */
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get(
    '/720577281466461/conversations',
    'EAAR9nHZBpogcBACvOJ7hxZAu9uAOfpn5REToRK4szjSc2OZCLMUeq6r3P0d5UjpuLbGBqLBGHHUqP1zWKKVadruNZAUZALJfZClNhJyCPaf04iwXbTZBbMPb9lQnsrn65QD9cdgJLLLXVuMyfpyQNqIrPw4Pa8P9uSixjOblEXlhBM3ogoi5QaZA'
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
