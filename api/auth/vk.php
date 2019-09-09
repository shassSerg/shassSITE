<?php

date_default_timezone_set('UTC');
try
{
$token=json_decode(file_get_contents('https://oauth.vk.com/access_token?client_id='.app_id.'&display=page&redirect_uri='.$new_url.'&client_secret='.secret_key.'&code='.$_GET['code']),true);


if ($_COOKIE['authID'] && $_COOKIE['authID']!='' && $_COOKIE['authID']!=null)
      session_id($_COOKIE['authID']);
else if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
      session_id($_POST['Authorization']);

session_start();

$_SESSION['access_token']=$token['access_token'];
$_SESSION['user_id']=$token['user_id'];
$_SESSION['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];
$_SESSION['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];
$_SESSION['OAUTH']='VK';
$_SESSION['expires_in']=$token['expires_in'];
$_SESSION['create_time']=time();
setcookie('authID', session_id(), time() + 604800, '/', '.shass.ru');

}catch (Exception $e){
}
/*$data=json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='.$token['user_id'].'&fields=bdate,photo_200&access_token='.$token['access_token'].'&v=5.92'),true);
if (!$data){
  exit('error data');
}*/
?>
