<?php


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
