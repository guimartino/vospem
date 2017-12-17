<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();

/* PHP SDK v5.0.0 */
/* make the API call */
  $users = getUsersMessagePage($fb, $_POST['page_id'], $_POST['page_token']);
  print_r($users);
  //graph.facebook.com/1428386897275804/picture?type=large
  foreach ($users as $key => $value) {
      ?>
        <div style="border:2px solid #007001; background:#60c961; width:50%; height: 100px;">
          aas
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
