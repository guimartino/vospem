<?php
  if(!session_id()) {
      session_start();
  }
  requireFacebookSDK();
?>
<script
			  src="https://code.jquery.com/jquery-3.2.1.min.js"
			  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="
			  crossorigin="anonymous"></script>
<?php
  $domain = "https://vospem.com/";
  $app_id = "1264011017036295";

  $fb = new \Facebook\Facebook([
    'app_id' => $app_id,
    'app_secret' => 'c1642f39152539b59460933e65c5f0d0',
    'default_graph_version' => 'v2.11',
    //'default_access_token' => '{access-token}', // optional
  ]);




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

?>
