<?php

include("data.php");


if($_GET['action'] == 'LockUnlockUser'){
  $user_id = $_GET['user_id'];
  $page_id = $_GET['page_id'];
  $value = $_GET['value'];
  lockAndUnlockUser($user_id, $page_id, $value);
}
