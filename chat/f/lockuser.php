<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();
  if(isset($_POST)){
    $_SESSION['lockuser_page_id'] = $_POST['page_id'];
    $_SESSION['lockuser_page_token'] = $_POST['page_token'];
  }

    $page_id = $_SESSION['lockuser_page_id'];
    $page_token = $_SESSION['lockuser_page_token'];

/* PHP SDK v5.0.0 */
/* make the API call */
  $users = getUsersMessagePage($fb, $page_id, $page_token);
  print_r($users);
  //graph.facebook.com/1428386897275804/picture?type=large
  foreach ($users as $user_id => $user_name) {
      $user_image = getUserImage($user_id);
      ?>
        <div style="border:2px solid #007001; background:#60c961; width:50%; height: 100px; margin-bottom: 10px; border-radius:5px;">
          <img src="<?=$user_image?>" style="width:80px;">
        </div>
      <?php
  }
  echo "<br><br>";

/* handle the result */




?>

<style>
  .yes{


  }
</style
