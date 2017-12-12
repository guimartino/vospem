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

  //$r = fixJSON($r, "}", 'right', false);
  //$r = $r[0];
  ///echo "<br>Lado: ".$r."<br>";
  $r = (string) $r;
  $r = json_decode($r, true);
  switch (json_last_error()) {
        case JSON_ERROR_NONE:
            echo ' - No errors';
        break;
        case JSON_ERROR_DEPTH:
            echo ' - Maximum stack depth exceeded';
        break;
        case JSON_ERROR_STATE_MISMATCH:
            echo ' - Underflow or the modes mismatch';
        break;
        case JSON_ERROR_CTRL_CHAR:
            echo ' - Unexpected control character found';
        break;
        case JSON_ERROR_SYNTAX:
            echo ' - Syntax error, malformed JSON';
        break;
        case JSON_ERROR_UTF8:
            echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
        break;
        default:
            echo ' - Unknown error';
        break;
    }

  //$r = strlen($r);
  $r = "aaaa".$r."aaa";
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
