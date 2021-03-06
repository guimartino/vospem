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
  $con = con();

/* PHP SDK v5.0.0 */
/* make the API call */
  $users = getUsersChatPage($page_id);

  //print_r($users);
  //print_r($users);
  //graph.facebook.com/1428386897275804/picture?type=large
  foreach ($users as $user_id) {
      $user_data = getDataFromPSID($user_id, $page_token);

      //print_r($user_data);
      $user_name = $user_data['first_name'] . ' ' . $user_data['last_name'];
      $user_image = $user_data['profile_pic'];
      echo "<br>";

      $class = "yes";
      $user_blocked = getUserLocked($page_id, $user_id, $con);

      ?>
        <div style="" id="div_<?=$user_id;?>" onClick="changeclass('div_<?=$user_id?>')" class="<?=$user_blocked;?>">
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
    var user_id = divName.split("_")[1];
    if(div.className == "yes"){
      div.className = "no";
      url = "../../include/actions.php?action=LockUnlockUser&value=1&user_id="+user_id+"&page_id=<?=$page_id?>";
      $.get(url, function(data, status){
        //alert("Usuario bloqueado com sucesso");
        console.log(url);
      });
    }else{
      div.className = "yes";
      url = "../../include/actions.php?action=LockUnlockUser&value=0&user_id="+user_id+"&page_id=<?=$page_id?>";
      $.get(url, function(data, status){
        //alert("Usuario desbloqueado");
        console.log(url);
      });
    }

    }
</script>
<style>
  .yes{
    border:2px solid #007001; background:#60c961; min-height: 100px; margin-bottom: 10px; border-radius:5px;
    padding:15px;
    width: 50%;
  }
  .yes span{
      color: #007001;
      font-weight: bolder;
    }

  .no{
    color: #7f0000;
    font-weight: bolder;
  }
  .no{
    border:2px solid #7f0000; background:#e06b6b; min-height: 100px; margin-bottom: 10px; border-radius:5px;
    padding:15px;
    width: 50%;
  }
</style>
