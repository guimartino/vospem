<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();

/* PHP SDK v5.0.0 */
/* make the API call */
try {
  // Returns a `Facebook\FacebookResponse` object
  //ID_CONVERSA/?fields=can_reply,former_participants,id,is_subscribed,link,message_count,participants,name,senders,subject
  $response = $fb->get(
    '/'.$_POST['page_id'].'/conversations',
    ''.$_POST['page_token']
  );
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

$graphEdge = $response->getGraphEdge();
$array = $graphEdge->asArray();
//print_r($array);
foreach ($array as $key => $value) {
  echo "Id " . $key . ": " . $value['id']."<br>";
}
/* handle the result */
