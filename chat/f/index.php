<?php
include("../../include/data.php");
if(!isset($_SESSION['fb_access_token'])){
  header('Location:  '.$domain.'/chat/f/login.php');
}else{
  header('Location:  '.$domain.'/chat/f/pages.php');
}
 ?>
