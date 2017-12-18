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
      return;
    }elseif(file_exists("../fb/vendor/autoload.php")) {
      require_once  "../fb/vendor/autoload.php";
      return;
    }elseif(file_exists("../../fb/vendor/autoload.php")) {
      require_once  "../../fb/vendor/autoload.php";
      return;
    }elseif(file_exists("../../../fb/vendor/autoload.php")) {
      require_once  "../../../fb/vendor/autoload.php";
      return;
    }elseif(file_exists("../chat/fb/vendor/autoload.php")) {
      require_once  "../chat/fb/vendor/autoload.php";
      return;
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
    $appsecret_proof= hash_hmac('sha256', $fb_token, 'c1642f39152539b59460933e65c5f0d0');
    $image = "https://graph.facebook.com/$page_id/picture?type=large&appsecret_proof=$appsecret_proof&access_token=".$fb_token;
    //echo "<br>".$image."<br>";
    $imageData = base64_encode(file_get_contents($image));
    $src = 'data:;base64,'.$imageData;
    return $src;
  }
  function getUserImage($user_id){
    $image = "https://graph.facebook.com/$user_id/picture?type=large";
    $imageData = base64_encode(file_get_contents($image));
    $src = 'data:;base64,'.$imageData;
    return $src;
  }

  function httpPost($url, $data = array()){
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
  function lockAndUnlockUser($user_id, $page_id, $value){
    $con = con();
    $rs = $con->prepare("SELECT * FROM locked_users WHERE id_user = ? AND id_page = ?");
    $rs->bindParam(1, $user_id);
    $rs->bindParam(2, $page_id);
    $insert = true;
    if($rs->execute()){
      while($row = $rs->fetch(PDO::FETCH_OBJ)){
        $insert = false;
      }
    }
    if($insert){
      $stmt = $con->prepare("INSERT INTO locked_users(id_user, id_page, is_blocked) VALUES(?, ?, ?)");
      $stmt->bindParam(1, $user_id);
      $stmt->bindParam(2, $page_id);
      $stmt->bindParam(3, $value);
    }else{
      $stmt = $con->prepare("UPDATE locked_users SET is_blocked = ? WHERE id_user = ? AND id_page = ? ");
      $stmt->bindParam(1, $value);
      $stmt->bindParam(2, $user_id);
      $stmt->bindParam(3, $page_id);
      print_r($stmt);
    }
    print_r($stmt->execute());
  }
  function getUserLocked($page_id, $user_id, $con = ''){
    $con = ($con == '') ? con() : $con;
    $sql = "SELECT * FROM locked_users WHERE id_user = ? AND id_page = ? AND is_blocked = 1";
    $stmt = $con->prepare( $sql );
    $stmt->bindParam(1, $user_id);
    $stmt->bindParam(2, $page_id);
    $stmt->execute();
    while($row = $stmt->fetch( PDO::FETCH_ASSOC )) {
        return "no";
    }

    return "yes";
  }
  function insertUserChat($id_user, $id_page){
    $con = con();
    $rs = $con->prepare("SELECT * FROM user_chat WHERE id_user = ? AND id_page = ? limit 1");
    $rs->bindParam(1, $id_user);
    $rs->bindParam(2, $id_page);
    $insert = true;
    if($rs->execute()){
      while($row = $rs->fetch(PDO::FETCH_OBJ)){
        $insert = false;
      }
    }
    if($insert){
      $stmt = $con->prepare("INSERT INTO user_chat(id_user, id_page) VALUES(?, ?)");
      $stmt->bindParam(1, $id_user);
      $stmt->bindParam(2, $id_page);
      $stmt->execute();
    }
  }
  function findAnswer($text){
    $con = ($con == '') ? con() : $con;
    $sql = "SELECT * FROM answer_bot WHERE question like ?";
    $stmt = $con->prepare( $sql );
    $text = "%|".$text."|%";
    $stmt->bindParam(1, $text);
    $stmt->execute();
    while($row = $stmt->fetch( PDO::FETCH_ASSOC )) {
      return array($row['answer'], $text);
    }
    return array(' ', $text);
  }
  function getUsersChatPage($page_id, $con = ''){
    $con = ($con == '') ? con() : $con;
    $sql = "SELECT * FROM user_chat WHERE id_page = ?";
    $stmt = $con->prepare( $sql );
    $stmt->bindParam(1, $page_id);
    $stmt->execute();
    $users = array();
    while($row = $stmt->fetch( PDO::FETCH_ASSOC )) {
      //print_r($row);
        $users[] = $row['id_user'];
    }
    return $users;
  }

  function getDataFromPSID($user_id, $page_token){
    $data = json_decode(file_get_contents("https://graph.facebook.com/$user_id?access_token=$page_token"), true);
    return $data;
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
      //echo "Id " . $key . ": " . $value['id']."<br>";
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

function notice_handler($errno, $errstr) {
// do something
}
