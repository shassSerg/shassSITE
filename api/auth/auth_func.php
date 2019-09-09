<?php

include 'config.php';

function auth(){

header('Content-Type: text/html; charset=utf-8');


//setcookie("PHPSESSID", session_id());

$arr = array('status' => true);
try{


if ($_GET['type'] && $_GET['type']=='vk'){
  if ($_GET['redirect']!='tv')
  header("Location: https://oauth.vk.com/authorize?client_id=".app_id."&display=page&redirect_uri=".url."&scope=friends&response_type=code&v=5.52");
  else
  header("Location: https://oauth.vk.com/authorize?client_id=".app_id."&display=page&redirect_uri=".url_tv."&scope=friends&response_type=code&v=5.52");
  exit();
}
if ($_GET['type'] && $_GET['type']=='yandex'){
    if ($_GET['redirect']!='tv')
  header("Location: https://oauth.yandex.ru/authorize?response_type=code&client_id=".app_id_ya."&redirect_uri=".url_ya);
  else
  header("Location: https://oauth.yandex.ru/authorize?response_type=code&client_id=".app_id_ya."&redirect_uri=".url_ya_tv);
  exit();
}
if ($_GET['type'] && $_GET['type']=='twitch'){
  if ($_GET['redirect']!='tv')
  header("Location: https://id.twitch.tv/oauth2/authorize?client_id=".app_id_tw."&redirect_uri=".url_tw."&response_type=code&scope=user:edit+user:read:email");
  else
  header("Location: https://id.twitch.tv/oauth2/authorize?client_id=".app_id_tw."&redirect_uri=".url_tw_tv."&response_type=code&scope=user:edit+user:read:email");
  exit();
}

if ($_COOKIE['authID'] && $_COOKIE['authID']!='' && $_COOKIE['authID']!=null)
      session_id($_COOKIE['authID']);
else if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
      session_id($_POST['Authorization']);

  session_start();
  if (session_id()!=$_COOKIE['authID'] &&  session_id()!=$_POST['Authorization']){
  session_destroy();
  throw new Exception('Invalid authorization id');
  }

if (isset($_SESSION['AUTH'])) {
  unset($_SESSION['AUTH']);
}

$expires_in=$_SESSION['expires_in'];
$create_time=$_SESSION['create_time'];
$difference=time()-$create_time;

$_SESSION['AUTH']=false;
if ($_SESSION['REMOTE_ADDR']!=$_SERVER['REMOTE_ADDR'] && $_SESSION['HTTP_USER_AGENT']!=$_SERVER['HTTP_USER_AGENT']) throw new Exception("Different host or device");//|| $_SESSION['HTTP_USER_AGENT']!=$_SERVER['HTTP_USER_AGENT']

if (!isset($_SESSION['OAUTH']) || $_SESSION['OAUTH']=='') throw new Exception("No oauth");


if ($_SESSION['OAUTH']=='SELF'){


  include '../configdb.php';
  $database = 'users'; // имя базы данных

  $link = mysqli_connect($host, $user, $password, $database);
  if (!$link) throw new Exception('No connect to DB');


  //UPDATE CONNECT DB

  $query = sprintf("SELECT * FROM main_users WHERE login=? AND password=?");

  $stmt = mysqli_stmt_init($link);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
      throw new Exception('No prepare query');
  }
  mysqli_stmt_bind_param($stmt, "ss",$_SESSION['login_token'],$_SESSION['access_token']);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  //$result=mysqli_query($link,$query);

  if ($token=mysqli_fetch_array($result)){

    $_SESSION['AUTH']=true;
    $_SESSION['NAME']=$token['login'];
    $_SESSION['USERID']=$token['CLIENT_ID'];
    $_SESSION['USERID_INT']=$token['CLIENT_ID'];


    $arr['disp_name']=$token['login'];
    $arr['type_auth']='SELF';

    $arr['display_name']=$token['login'];
    $arr['logo']=$token['logo_ava'];
    $arr['back']=$token['back_img'];

  }else throw new Exception('Incorrect login or password');

  if($result)
  mysqli_free_result($result);


mysqli_stmt_close($stmt);
mysqli_close($link);

}else
if ($_SESSION['OAUTH']=='VK'){//VK

$token=$_SESSION['access_token'];
$user_id=$_SESSION['user_id'];
if (!$token || !$user_id) throw new Exception("No user_id or token");

$data=json_decode(file_get_contents('https://api.vk.com/method/users.get?user_ids='.$user_id.'&fields=bdate,photo_200&access_token='.$token.'&v=5.92'),true);

if (!$data) throw new Exception("No info (vk)");
$image_url=$data['response'][0]['photo_200'];
if (!$image_url || $image_url=='') $image_url='/images/no-avatar.png';

$_SESSION['AUTH']=true;
$_SESSION['NAME']=$data['response'][0]['first_name']." ".$data['response'][0]['last_name'];
$_SESSION['USERID']=$_SESSION['user_id'];
$_SESSION['USERID_INT']=$_SESSION['user_id'];

$arr['disp_name']=$_SESSION['user_id'];
$arr['type_auth']='VK';

$arr['display_name']= $data['response'][0]['first_name'].' '.$data['response'][0]['last_name'];
$arr['logo']=$image_url;
}
else if ($_SESSION['OAUTH']=='YANDEX'){


if ($difference>=$expires_in){
$query = array(
  'grant_type' => 'refresh_token',
  'refresh_token' => $_SESSION['refresh_token'],
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
try{
$token = json_decode(file_get_contents('https://oauth.yandex.ru/token', false, $context),true);
}catch (Exception $e){
}
if (!$token) $token=$_SESSION['access_token'];
else{
$_SESSION['refresh_token']=$token['refresh_token'];
$_SESSION['access_token']=$token['access_token'];
$token=$_SESSION['access_token'];
}
}else{
      $token=$_SESSION['access_token'];
}

// Формирование заголовков POST-запроса
$header = array("Content-type: application/x-www-form-urlencoded",'Authorization: OAuth '.$token);

// Выполнение POST-запроса и вывод результата
$opts = array('http' =>
 array(
 'method'  => 'GET',
 'header'  => $header,
// 'content' => ''
 )
);
$context = stream_context_create($opts);
$data = json_decode(file_get_contents('https://login.yandex.ru/info?format=json&with_openid_identity=1', false, $context),true);

if (!$token || !$data) throw new Exception("No token or data (yandex info)");

$image_url='https://avatars.mds.yandex.net/get-yapic/'.$data['default_avatar_id'].'/islands-200';

$_SESSION['AUTH']=true;
$_SESSION['NAME']=$data['first_name']." ".$data['last_name'];
$_SESSION['USERID']=$data['login'];
$_SESSION['USERID_INT']=$data['id'];


$arr['disp_name']=$data['login'];
$arr['type_auth']='YANDEX';

$arr['display_name']=$data['first_name'].' '.$data['last_name'];
$arr['logo']=$image_url;

}
else if($_SESSION['OAUTH']=='TWITCH'){

        if ($difference>=$expires_in){

$query = array(
  'grant_type' => 'refresh_token',
  'refresh_token' => $_SESSION['refresh_token'],
  'client_id' => app_id_tw,
  'client_secret' => secret_key_tw
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
try{
$token = json_decode(file_get_contents('https://id.twitch.tv/oauth2/token', false, $context),true);
}catch (Exception $e){
}
if (!$token) $token=$_SESSION['access_token'];
else{
$_SESSION['refresh_token']=$token['refresh_token'];
$_SESSION['access_token']=$token['access_token'];
$token=$_SESSION['access_token'];
}
}else{
  $token=$_SESSION['access_token'];
}


if (!$_SESSION['user_id']){
// Формирование заголовков POST-запроса
$header = array('Authorization: OAuth '.$token);

// Выполнение POST-запроса и вывод результата
$opts = array('http' =>
 array(
 'method'  => 'GET',
 'header'  => $header,
// 'content' => ''
 )
);
$context = stream_context_create($opts);
$data = json_decode(file_get_contents('https://id.twitch.tv/oauth2/validate', false, $context),true);

if (!$token || !$data) throw new Exception("No token or data (twitch validate)");

$_SESSION['user_id']=$data['user_id'];
}
$user_id=$_SESSION['user_id'];

$header = array('Authorization: Bearer '.$token);

// Выполнение POST-запроса и вывод результата
$opts = array('http' =>
 array(
 'method'  => 'GET',
 'header'  => $header,
// 'content' => ''
 )
);

$context = stream_context_create($opts);
$data = json_decode(file_get_contents('https://api.twitch.tv/helix/users?id='.$user_id, false, $context),true);

if (!$token || !$data) throw new Exception("No token or data (twitch users)");

$image_url=$data['data'][0]['profile_image_url'];
if (!$image_url || $image_url=='') $image_url='/images/no-avatar.png';

$_SESSION['AUTH']=true;
$_SESSION['NAME']=$data['data'][0]['display_name'];
$_SESSION['USERID']=$data['data'][0]['login'];
$_SESSION['USERID_INT']=$user_id;


$arr['disp_name']=$data['data'][0]['login'];
$arr['type_auth']='TWITCH';

$arr['display_name']=$data['data'][0]['display_name'];
$arr['logo']=$image_url;
}
else throw new Exception("Not valid OAUTH");


}catch(Exception $e)
{
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}
return json_encode($arr, JSON_UNESCAPED_UNICODE);
}
 ?>
