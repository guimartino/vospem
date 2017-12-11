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

$app_id = "1264011017036295";


$fb = new \Facebook\Facebook([
  'app_id' => $app_id,
  'app_secret' => 'c1642f39152539b59460933e65c5f0d0',
  'default_graph_version' => 'v2.11',
  //'default_access_token' => '{access-token}', // optional
]);
try {
  $response = $fb->get(
    '/me/accounts',
    ''.$_SESSION['fb_access_token']
  );
  //echo $_SESSION['fb_access_token']."<br>";
  $graphEdge = $response->getGraphEdge();
  $array = $graphEdge->asArray();
  // print_r($array);
  //print_r($array);
  foreach($array as $key => $value){
    $page_token = $value["access_token"];
    $page_name = $value['name'];
    $page_id = $value['id'];
    echo 'Nome da pagina: ' . $page_name . '<br>';
    //echo 'ID: ' . $value['id'] . '<br>';
    //echo 'Acces Token: ' . $accessTokenPagina;
    //echo "<br><br>";
    $fid = $value['id'];
    /*
      Checa se pagina está inscrita no app
    */
    $s = getPageSubscription($page_id, $page_token)
    ?>
    <br>
    <form method="POST" action="subscribe.php">
      <input type="hidden" name="tipo" value="<?=$s[0]?>">
      <input type="hidden" name="page_id" value="<?=$page_id?>">
      <input type="hidden" name="page_token" value="<?=$page_token?>">
      <input type="submit" value="<?=$s[1]?>" style="padding:10px 20px 10px 20px">
    </form>
    <?php
    /*
      Exibe imagem da página (mesmo se estiver oculta)
    */
    $imagem = getPageImage($page_id, $_SESSION['fb_access_token']);
    echo '<img src="' . $imagem . '">';


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


$end = date('Y-m-d H:i:s');

echo "
    Inicio: $start <br>
    Fim: $end <br>
    Tempo decorrido: ".(strtotime($end)-strtotime($start))."s
";


function getPageSubscription($page_id, $page_token){
  global $app_id;
  $f = "https://graph.facebook.com/$page_id/subscribed_apps?access_token=$page_token";
  $s = file_get_contents($f);
  $subscribed = json_decode(json_decode(json_encode($s), true));
  $r = array();
  $r[0] = "add"; $t[1] = "INSCREVER PAGINA";
  if(isset($subscribed->data['0'])) {
    $subscribed = $subscribed->data['0'];
    if($subscribed->id == $app_id){
      $r[0] = "remove";
      $r[1] = "DESINSCREVER PAGINA";
    }
  }
  return $r;
}

function getPageImage($page_id, $fb_token){
  $image = "https://graph.facebook.com/$page_id/picture?type=large&access_token=".$fb_token;
  $imageData = base64_encode(file_get_contents($image));
  $src = 'data:;base64,'.$imageData;
  return $src;
}


?>
