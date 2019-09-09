<?php
include 'config.php';




try{

  if ($_COOKIE['authID'] && $_COOKIE['authID']!='' && $_COOKIE['authID']!=null)
        session_id($_COOKIE['authID']);
  else if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
        session_id($_POST['Authorization']);

    session_start();
    if (session_id()!=$_COOKIE['authID'] &&  session_id()!=$_POST['Authorization']){
    session_destroy();
    throw new Exception('Invalid authorization id');
    }


  if ($_SESSION['OAUTH']=='VK'){

  }else if ($_SESSION['OAUTH']=='YANDEX'){

  }if ($_SESSION['OAUTH']=='TWITCH'){
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


    $token=json_decode(file_get_contents('https://id.twitch.tv/oauth2/revoke?client_id='.app_id_tw.'&token='.$_SESSION['access_token'],false ,$context),true);
    echo var_dump($token);
  }

}
catch(Exception $e)
{

}

$_SESSION['OAUTH']='';

if (isset($_SESSION['access_token'])) {
  unset($_SESSION['access_token']);
}
if (isset($_SESSION['user_id'])) {
  unset($_SESSION['user_id']);
}


if ($_GET['type']!=null && $_GET['type']=='main')
header("Location: https://shass.ru");
else if ($_GET['type']!=null  && $_GET['type']=='tv')
header("Location: https://tv.shass.ru");
else if ($_GET['type']!=null  && $_GET['type']=='remote_drone')
header("Location: https://shass.ru/docs/drone/remote");
else
header("Location: /");
 ?>
