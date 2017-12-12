<?php

  function checkLogin(){
    if(!(isset($_SESSION['fb_access_token']))) {
      header('Location: login.php');
      exit;
    }
  }

  function requireFacebookSDK(){
    if (file_exists("fb/vendor/autoload.php")) {
      require_once  "fb/vendor/autoload.php";
    }elseif(file_exists("../fb/vendor/autoload.php")) {
      require_once  "../fb/vendor/autoload.php";
    }elseif(file_exists("../../fb/vendor/autoload.php")) {
      require_once  "../../fb/vendor/autoload.php";
    }elseif(file_exists("../../../fb/vendor/autoload.php")) {
      require_once  "../../../fb/vendor/autoload.php";
    }
  }

  function HTMLIncludes(){

    echo '
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- Optional theme -->
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <!-- Latest compiled and minified JavaScript -->
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
      <script src="//code.jquery.com/jquery-3.2.1.min.js"
      			  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
      			  crossorigin="anonymous"></script>
    ';
  }


  function getPageSubscription($page_id, $page_token){
    global $app_id;
    $f = "https://graph.facebook.com/$page_id/subscribed_apps?access_token=$page_token";
    $s = file_get_contents($f);
    $subscribed = json_decode(json_decode(json_encode($s), true));
    $r = array();
    $r[0] = "add";
    $r[1] = "INSCREVER PAGINA";
    $r[2] = "success";
    if(isset($subscribed->data['0'])) {
      $subscribed = $subscribed->data['0'];
      if($subscribed->id == $app_id){
        $r[0] = "remove";
        $r[1] = "DESINSCREVER PAGINA";
        $r[2] = "danger";
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

  function httpPost($url, $data = array())
  {
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $response = curl_exec($curl);
      curl_close($curl);
      return $response;
  }

  function httpDelete($url)
  {
      /*$url = $path;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      $result = curl_exec($ch);
      //$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      curl_close($ch);
      return $result;*/
      $curl = curl_init($url);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
      $response = curl_exec($curl);
      curl_close($curl);
      substr($response, 0, strlen($response) - 1);
      return $response;
  }



  function fixJSON($string, $character = "}", $side='left', $keep_character=true) {
    echo "<br>FUNCAO";
    echo "<br>$side";
    echo "<br>FUNCAO<br>";
    $offset = ($keep_character ? 1 : 0);
    $whole_length = strlen($string);
    $right_length = (strlen(strrchr($string, $character)) - 1);
    $left_length = ($whole_length - $right_length - 1);
    switch($side) {
        case 'left':
            $piece = substr($string, 0, ($left_length + $offset));
            break;
        case 'right':
            $start = (0 - ($right_length + $offset));
            $piece = substr($string, $start);
            break;
        default:
            $piece = false;
            break;
    }
    $piece = array($piece, $side);
    print_r($piece);
    return($piece);
}
