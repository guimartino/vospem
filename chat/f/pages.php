<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();

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

    $fid = $value['id'];
    
    $s = getPageSubscription($page_id, $page_token);
    echo '<img src="' . getPageImage($page_id, $_SESSION['fb_access_token']). '">';
    ?>
    <br><br>
    <form method="POST" action="subscribe.php">
      <input type="hidden" name="tipo" value="<?=$s[0]?>">
      <input type="hidden" name="page_id" value="<?=$page_id?>">
      <input type="hidden" name="page_token" value="<?=$page_token?>">
      <input type="submit" value="<?=$s[1]?>" class="btn btn-<?=$s[2];?>" style="padding:10px 20px 10px 20px">
    </form>
    <?php
    /*
      Exibe imagem da página (mesmo se estiver oculta)
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


$end = date('Y-m-d H:i:s');

echo "
    Inicio: $start <br>
    Fim: $end <br>
    Tempo decorrido: ".(strtotime($end)-strtotime($start))."s
";




?>
