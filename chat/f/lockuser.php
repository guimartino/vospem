<?php

include("../../include/data.php");
$start = date('Y-m-d H:i:s');
checkLogin();
  if(isset($_POST['page_id'])){
    $page_id = $_POST['page_id'];
    $page_token = $_POST['page_token'];
  }else{
    header("Location: pages.php");
  }


/* PHP SDK v5.0.0 */
/* make the API call */
  $users = getUsersMessagePage($fb, $page_id, $page_token);
  print_r($users);
  //graph.facebook.com/1428386897275804/picture?type=large
  foreach ($users as $user_id => $user_name) {
      $user_image = getUserImage($user_id);
      ?>
        <div style="" id="div_<?=$user_id;?>" onClick="changeclass('div_<?=$user_id?>')" class="yes">
          <table>
            <tr>
              <td>
                <img src="<?=$user_image?>"style="width:80px;">
              </td>
              <td>
                <span><?=$user_name?></span>
              </td>
            </tr>
          </table>
        </div>
      <?php
  }
  echo "<br><br>";

/* handle the result */




?>
<script>
    function changeclass(divName) {

    var div = document.getElementById(divName);

    if(div.className == "yes"){
      div.className = "no";
    }else{
      div.className = "yes";
    }

    }
</script>
<style>
  .yes{
    border:2px solid #007001; background:#60c961; min-height: 100px; margin-bottom: 10px; border-radius:5px;
    padding:150px;

  }
  .yes span{
      color: #007001;
    }

  .no{
    color: #7f0000;
  }
  .no{
    border:2px solid #7f0000; background:#e06b6b; min-height: 100px; margin-bottom: 10px; border-radius:5px;
    padding:15px;
  }
</style>
