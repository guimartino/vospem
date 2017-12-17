<?php
include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();

/* PHP SDK v5.0.0 */
/* make the API call */
  $users = getUsersMessagePage($fb, $_POST['page_id'], $_POST['page_token']);

  echo "<br><br>";
}
/* handle the result */
