<?php
include("../../include/data.php");
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email','public_profile','manage_pages','pages_show_list','read_page_mailboxes','pages_messaging']; // Optional permissions
$loginUrl = $helper->getLoginUrl($domain . '/chat/f/fb-callback.php', $permissions);

echo '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';


echo "<br><br>";
$text = isset($_GET['t']) ? $_GET['t'] : 'vc gosta disso aqui? eu tb gosto!';
echo filtro($text);


?>
