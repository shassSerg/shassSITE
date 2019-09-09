<?php

try
{
  // Формирование заголовков POST-запроса
 $header = "Content-type: application/x-www-form-urlencoded";

 // Выполнение POST-запроса и вывод результата
 $opts = array('http' =>
   array(
   'method'  => 'POST',
   'header'  => $header,
   )
 );
$context = stream_context_create($opts);


$token=json_decode(file_get_contents('https://id.twitch.tv/oauth2/token?client_id='.app_id_tw.'&client_secret='.secret_key_tw.'&code='.$_GET['code'].'&grant_type=authorization_code&redirect_uri='.$new_url,false ,$context),true);//&redirect_uri='.url_tw


if ($_COOKIE['authID'] && $_COOKIE['authID']!='' && $_COOKIE['authID']!=null)
      session_id($_COOKIE['authID']);
else if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
      session_id($_POST['Authorization']);

session_start();

$_SESSION['access_token']=$token['access_token'];
$_SESSION['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];
$_SESSION['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];
$_SESSION['OAUTH']='TWITCH';
$_SESSION['refresh_token']=$token['refresh_token'];
$_SESSION['expires_in']=$token['expires_in'];
$_SESSION['create_time']=time();
setcookie('authID', session_id(), time() + 604800, '/', '.shass.ru');

}catch (Exception $e){
}
?>
