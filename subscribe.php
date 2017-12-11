<?php


  //https://graph.facebook.com/ID/subscribed_apps?access_token=PAGE_TOKEN
  $id = $_POST['page_id'];
  $token = $_POST['page_token'];
  file_get_contents("https://graph.facebook.com/$id/subscribed_apps?access_token=$token");

  header('Location: pages.php');
