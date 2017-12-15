<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();
echo "Inicio";
/* PHP SDK v5.0.0 */
/* make the API call */
try {
  // Returns a `Facebook\FacebookResponse` object
  //ID_CONVERSA/?fields=can_reply,former_participants,id,is_subscribed,link,message_count,participants,name,senders,subject
  $response = $fb->get(
    '/523235258054632/conversations',
    'EAAR9nHZBpogcBADZCSlhtAcmMAp2yaWVtdIsHhhAZBN2iXXfejdaisVUpFZB9SYD6W8Qr97NSCaMHHEEuuDdUQOylT3pXr3NiuoneOa0x4jKoSDvXfz92gycDxg606YqsYOZBOaR2zxLPkgK3k9dZBHaVIMZBzMD4i55Sm1uQkSmfAnHfvrR3wG'
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
