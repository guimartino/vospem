<?php
  include("../../include/data.php");

  //https://graph.facebook.com/ID/subscribed_apps?access_token=PAGE_TOKEN
  $id = $_POST['page_id'];
  $token = $_POST['page_token'];
  $page_name = $_POST['page_name'];
  $t = $_POST['tipo'];
  $data = array();
  $data['id_page'] = $id;
  $data['page_name'] = $page_name;
  $data['page_token'] = $token;
  $data['id_user'] = 1;

  if($t == "remove"){
    $r = curl_del("https://graph.facebook.com/$id/subscribed_apps?access_token=$token");
    $data['enabled'] = 0;
  }else{
    $r = httpPost("https://graph.facebook.com/$id/subscribed_apps?access_token=$token");
    $data['enabled'] = 1;
  }
  echo insertPageDataBase($data);

  //$r = fixJSON($r, "}", 'right', false);
  //$r = $r[0];
  ///echo "<br>Lado: ".$r."<br>";

  if($r->success == 1){
    echo "Sucesso";


    //salvar no banco

    //salvar no banco o LOG
  }else{
    echo "Ocorreu um erro!";

    //salvar no banco o LOG
  }


  

      /*
        Inscrever pagina no app:
            https://graph.facebook.com/530951440254946/subscribed_apps?access_token=EAAR9nHZBpogcBAMghZBAQ2sIqVGYJITZCSUvaXb7RCwawDhQZBnLyiKUNS1C9IP6TE6PbWMbS0PJ831EdW89bAbW7yjVUq1bs9lngfFkga60PzJCr04Nm4qEeqR6ZAlLb1WpohevhnceZATuIKdUIZBJ7ZAJZCX9ZBtFZAvq6EZAW1wKgtCBYMZCopzNw

              Tutorial:
                https://developers.facebook.com/docs/marketing-api/guides/lead-ads/quickstart/webhooks-integration
      */
