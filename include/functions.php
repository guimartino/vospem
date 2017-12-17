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
      $response = json_decode($response);
      curl_close($curl);
      return $response;
  }

  function curl_del($path, $json = ''){
      $url = $path;
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      $result = json_decode($result);
      curl_close($ch);

      return $result;
  }

  function getUsersMessagePage($fb, $page_id, $page_token){

    //global $fb;
    try {
      // Returns a `Facebook\FacebookResponse` object
      //ID_CONVERSA/?fields=can_reply,former_participants,id,is_subscribed,link,message_count,participants,name,senders,subject
      $response = $fb->get(
        '/'.$page_id.'/conversations',
        ''.$page_token
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
    $users = array();
    foreach ($array as $key => $value) {
      echo "Id " . $key . ": " . $value['id']."<br>";
      $conversas = file_get_contents('https://graph.facebook.com/'.$value['id'].'/?fields=can_reply,former_participants,id,is_subscribed,link,message_count,participants,name,senders,subject&access_token='.$_POST['page_token']);
      $conversas = json_decode($conversas, true);
      foreach ($conversas['participants']['data'] as $k => $p) {
        if($p['id']!=$_POST['page_id']){
          $users[$p['id']] = $p['name'];
        }
      }

  }
  return $users;

}
