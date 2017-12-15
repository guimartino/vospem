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
    'EAAR9nHZBpogcBAMe0g7vRKCEVOiguJ7p4kom0N7hJQmHV8wsbIUp1tiimj9xCPSWaVklb096Ld4ZC34OWUp9BHmvN3gSmc3fddGYpVN0SdqZBFhEWW5fJ53bt0o4FXQgdXydMYFjX7pY2STb5ZC10GKRt8kPcyk47Xyj6e65XlmipzZBREmu8'
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
