<?php
  if(!session_id()) {
      session_start();
  }
  include('functions.php');
  include('mysql.php');
  requireFacebookSDK();
  HTMLIncludes();

  $domain = "https://vospem.com/";
  $app_id = "1264011017036295";

  $fb = new \Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => 'c1642f39152539b59460933e65c5f0d0',
    'default_graph_version' => 'v2.11',
    //'default_access_token' => '{access-token}', // optional
  ]);



?>