<?php
$start = date('Y-m-d H:i:s');
if(!session_id()) {
    session_start();
}
if(!(isset($_SESSION['fb_access_token']))) {
  header('Location: login.php');
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once "../fb/vendor/autoload.php"; // change path as needed

$fb = new \Facebook\Facebook([
  'app_id' => '1264011017036295',
  'app_secret' => 'c1642f39152539b59460933e65c5f0d0',
  'default_graph_version' => 'v2.11',
  //'default_access_token' => '{access-token}', // optional
]);
/* PHP SDK v5.0.0 */
/* make the API call */
try {
  // Returns a `Facebook\FacebookResponse` object
  $response = $fb->get(
    '/me/accounts',
    ''.$_SESSION['fb_access_token']
  );
  echo $_SESSION['fb_access_token']."<br>";
  // print_r($response);
  $graphEdge = $response->getGraphEdge();
  $array = $graphEdge->asArray();
  // print_r($array);
  //print_r($array);
  foreach($array as $key => $value){
    $accessTokenPagina = $value["access_token"];
    echo 'Nome da pagina: ' . $value['name'] . '<br>';
    echo 'ID: ' . $value['id'] . '<br>';
    echo 'Acces Token: ' . $accessTokenPagina;
    echo "<br><br>";
    $fid = $value['id'];


    $image = "https://graph.facebook.com/$fid/picture?type=large&access_token=".$_SESSION['fb_access_token'];
    $imageData = base64_encode(file_get_contents($image));
    // Format the image SRC:  data:{mime};base64,{data};
    $src = 'data:;base64,'.$imageData;
    // Echo out a sample image
    echo '<img src="' . $src . '">';
    $f = "https://graph.facebook.com/$fid/subscribed_apps?access_token=$accessTokenPagina";

    $s = file_get_contents($f);
    //echo "<br>Subscribed apps:";

    $subscribed = json_decode(json_decode(json_encode($s), true));
    if(isset($subscribed->->data['0'])){
      if($subscribed->id == "1264011017036295"){
        echo "INSCRITO NO APLICATIVO!";
      }


    }
    // foreach($subscribed as $s1 => $k1){
    //   print_r($s1);
    //   echo ": ";
    //   print_r($k1);
    //   echo "<br>";
    // }

    /*
      Inscrever pagina no app:
          https://graph.facebook.com/530951440254946/subscribed_apps?access_token=EAAR9nHZBpogcBAMghZBAQ2sIqVGYJITZCSUvaXb7RCwawDhQZBnLyiKUNS1C9IP6TE6PbWMbS0PJ831EdW89bAbW7yjVUq1bs9lngfFkga60PzJCr04Nm4qEeqR6ZAlLb1WpohevhnceZATuIKdUIZBJ7ZAJZCX9ZBtFZAvq6EZAW1wKgtCBYMZCopzNw

            Tutorial:
              https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration
    */
    echo "<br><br>";
    echo "<br><br>";
  }

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
    Inicio: $start <br>
    Fim: $end <br>
    Tempo decorrido: ".(strtotime($end)-strtotime($start))."

";
function accessProtected($obj, $prop) {
  $reflection = new ReflectionClass($obj);
  $property = $reflection->getProperty($prop);
  $property->setAccessible(true);
  return $property->getValue($obj);
}
?>
