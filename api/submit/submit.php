<?php

include '../auth/auth_func.php';
ini_set('display_errors', 'Off');
ini_set('session.gc_maxlifetime', 604800);
ini_set('session.cookie_lifetime', 604800);
ini_set('session.save_path', '/data/data/ru.kslabs.ksweb/sessions_token');

$arr = array('status' => true);

try{

if (!(json_decode(auth(),true)['status'])){
  throw new Exception('Unauth');
}


if (!$_SESSION['AUTH']){
throw new Exception('Unauth');
}
if (!$_SESSION['OAUTH']){
throw new Exception('Undefinded auth');
}
if (!$_SESSION['NAME']){
throw new Exception('No name');
}
if (!$_SESSION['USERID_INT']){
throw new Exception('No user_id');
}
if (!$_SESSION['USERID']){
throw new Exception('No login');
}
if (!$_POST['FIRST_NAME']){
throw new Exception('No fn');
}
if (!$_POST['LAST_NAME']){
throw new Exception('No ln');
}
if (!$_POST['EMAIL']){
throw new Exception('No email');
}
if (!$_POST['CITY']){
throw new Exception('No city');
}
if (!$_POST['STATE']){
throw new Exception('No state');
}
if (!$_POST['ZIP']){
throw new Exception('No zip');
}
include '../configdb.php';

$database = 'messages'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');

$access=false;
$query = sprintf("SELECT user_id FROM message WHERE user_id='%s'", $_SESSION['USERID_INT']);

if (!($result=mysqli_query($link,$query))) throw new Exception('Error query search');
if (mysqli_fetch_array($result)) throw new Exception('Message already sended');
else $access=true;
mysqli_free_result($result);

if($access){
$sql = sprintf("INSERT INTO message (OAUTH,NAME,LOGIN,FIRST_NAME,LAST_NAME,EMAIL,STATE,CITY,ZIP,user_id,REMOTE_IP) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
$_SESSION['OAUTH'],
$_SESSION['NAME'],
$_SESSION['USERID'],
$_POST['FIRST_NAME'],
$_POST['LAST_NAME'],
$_POST['EMAIL'],
$_POST['STATE'],
$_POST['CITY'],
$_POST['ZIP'],
$_SESSION['USERID_INT'],
$_SERVER['REMOTE_ADDR']);
if (!mysqli_query($link,$sql)) throw new Exception('Error add row');
}
mysqli_close($link);
}catch(Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
 ?>
