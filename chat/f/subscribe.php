<?php
  include("../../include/data.php");

  //https://graph.facebook.com/ID/subscribed_apps?access_token=PAGE_TOKEN
  $id = $_POST['page_id'];
  $token = $_POST['page_token'];
  $t = $_POST['tipo'];
  if($t == "remove"){
    $r = httpDelete("https://graph.facebook.com/$id/subscribed_apps?access_token=$token");
  }else{
    $r = httpPost("https://graph.facebook.com/$id/subscribed_apps?access_token=$token");
  }
  echo "<br>$r<br>";
  $r = json_decode($r, true);
  print_r($r);
  //echo $t;
  // salvar no banco ID da pagina e Token


  //header('Location: pages.php');











      /*
        Inscrever pagina no app:
            https://graph.facebook.com/530951440254946/subscribed_apps?access_token=EAAR9nHZBpogcBAMghZBAQ2sIqVGYJITZCSUvaXb7RCwawDhQZBnLyiKUNS1C9IP6TE6PbWMbS0PJ831EdW89bAbW7yjVUq1bs9lngfFkga60PzJCr04Nm4qEeqR6ZAlLb1WpohevhnceZATuIKdUIZBJ7ZAJZCX9ZBtFZAvq6EZAW1wKgtCBYMZCopzNw

              Tutorial:
                https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration
      */
