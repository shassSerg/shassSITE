<?php

try{

  // Формирование параметров (тела) POST-запроса с указанием кода подтверждения
  $query = array(
    'grant_type' => 'authorization_code',
    'code' => $_GET['code'],
    'client_id' => app_id_ya,
    'client_secret' => secret_key_ya
  );
  $query = http_build_query($query);

  // Формирование заголовков POST-запроса
 $header = "Content-type: application/x-www-form-urlencoded";

 // Выполнение POST-запроса и вывод результата
 $opts = array('http' =>
   array(
   'method'  => 'POST',
   'header'  => $header,
   'content' => $query
   )
 );
$context = stream_context_create($opts);
$token = json_decode(file_get_contents('https://oauth.yandex.ru/token', false, $context),true);


if ($_COOKIE['authID'] && $_COOKIE['authID']!='' && $_COOKIE['authID']!=null)
      session_id($_COOKIE['authID']);
else if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
      session_id($_POST['Authorization']);

session_start();

$_SESSION['OAUTH']='YANDEX';
$_SESSION['access_token']=$token['access_token'];
$_SESSION['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];
$_SESSION['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];
$_SESSION['refresh_token']=$token['refresh_token'];
$_SESSION['expires_in']=$token['expires_in'];
$_SESSION['create_time']=time();
setcookie('authID', session_id(), time() + 604800, '/', '.shass.ru');

}
catch (Exception $e){
}
/*$data=json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='.$token['user_id'].'&fields=bdate,photo_200&access_token='.$token['access_token'].'&v=5.92'),true);
if (!$data){
  exit('error data');
}*/
?>
