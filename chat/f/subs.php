<?php
include("../../include/data.php");

try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get(
    '/1264011017036295/subscriptions',
    '1264011017036295|BZ4RY8aGM6VvOhC8nGUWVkqzhoo'
  );
  //echo $_SESSION['fb_access_token']."<br>";
  // print_r($response);
  $graphEdge = $response->getGraphEdge();
  $array = $graphEdge->asArray();
  // print_r($array);
  //print_r($array);


  print_r($array);

} catch(Facebook\Exceptions\FacebookResponseException $e) {
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

// var_dump($response);
// $graphNode = $response->getGraphNode();
// Or if you have the latest dev version of the official SDK

/* handle the result */
$end = date('Y-m-d H:i:s');

echo "
    Inicio: $start \n
    Fim: $end \n
    Tempo decorrido: ".(strtotime($end)-strtotime($start))."

";
function accessProtected($obj, $prop) {
  $reflection = new ReflectionClass($obj);
  $property = $reflection->getProperty($prop);
  $property->setAccessible(true);
  return $property->getValue($obj);
}
?>
