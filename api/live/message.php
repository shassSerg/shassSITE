<?php
ini_set('display_errors', 'Off');
$arr = array('status' => true,"time"=>time(),"date"=>date('l jS \of F Y h:i:s A'));
try
{
include '../configdb.php';

if($_GET['event']==NULL) throw new Exception('No event');
$event=$_GET['event'];

if ($event!='get' && $event!='send'  && $event!='info') throw new Exception('No event');

if($_GET['login']==NULL) throw new Exception('No login');
$login=$_GET['login'];

$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');

//,main_users.login,main_users.url_stream,main_users.logo_ava,main_users.back_img,main_users.name_stream

switch($event){


case 'get':

if($_GET['from']==NULL) throw new Exception('No number');
$number=$_GET['from'];

$query = sprintf("SELECT CLIENT_ID FROM main_users WHERE login='%s'",$login);
$result=mysqli_query($link,$query);
if ($row=mysqli_fetch_array($result)){
$id_streamer=$row['CLIENT_ID'];
}else {
throw new Exception('No user');
}
if ($result){
mysqli_free_result($result);
}



$query = sprintf("SELECT a.ID_MESSAGE,a.display_nameREMOTEDB,a.time,a.message,a.color_login,a.platform,b.login FROM messages_streams as a LEFT JOIN main_users as b ON a.ID_USER=b.CLIENT_ID WHERE a.ID_TO_USER=%s AND a.private=0 AND a.ID_MESSAGE>%s ORDER BY a.ID_MESSAGE",$id_streamer,$number);
$result=mysqli_query($link,$query);
$arr['index']=null;
$arr['result']=null;
if ($row=mysqli_fetch_array($result)){
if ($row['display_nameREMOTEDB']==null)
$arr['result']=array(array('login'=>$row['login'],'type'=>'SELF','ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
else $arr['result']=array(array('login'=>$row['display_nameREMOTEDB'],'type'=>$row['platform'],'ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
while ($row=mysqli_fetch_array($result)){
if ($row['display_nameREMOTEDB']==null)
array_push($arr['result'],array('login'=>$row['login'],'type'=>'SELF','ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
else
array_push($arr['result'],array('login'=>$row['display_nameREMOTEDB'],'type'=>$row['platform'],'ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
}

$index_of_last_message=$arr['result'][count($arr['result'])-1]['ID_MESSAGE'];
$arr['index']=$index_of_last_message;

if ($number==-1) $arr['result']=null;
}else {
  if ($result){
  mysqli_free_result($result);
  }
  $query = sprintf("SELECT a.ID_MESSAGE,a.display_nameREMOTEDB,a.time,a.message,a.color_login,a.platform,b.login FROM messages_streams as a LEFT JOIN main_users as b ON a.ID_USER=b.CLIENT_ID WHERE a.ID_TO_USER=%s AND a.private=0 ORDER BY a.ID_MESSAGE DESC",$id_streamer);
  $result=mysqli_query($link,$query);
  $arr['result']=null;
  if ($row=mysqli_fetch_array($result) && $row['ID_MESSAGE']>$number){
  if ($row['display_nameREMOTEDB']==null)
  $arr['result']=array(array('login'=>$row['login'],'type'=>'SELF','ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
  else $arr['result']=array(array('login'=>$row['display_nameREMOTEDB'],'type'=>$row['platform'],'ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
  while ($row=mysqli_fetch_array($result)){
  if ($row['display_nameREMOTEDB']==null)
  array_push($arr['result'],array('login'=>$row['login'],'type'=>'SELF','ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
  else
  array_push($arr['result'],array('login'=>$row['display_nameREMOTEDB'],'type'=>$row['platform'],'ID_MESSAGE'=>$row['ID_MESSAGE'],'time'=>$row['time'],'message'=>$row['message'],'color'=>$row['color_login']));
  }

  $index_of_last_message=$arr['result'][0]['ID_MESSAGE'];
  $arr['index']=$index_of_last_message;
  $arr['result']=array_reverse($arr['result']);
}
}

if ($result){
mysqli_free_result($result);
}

  mysqli_close($link);
break;

case 'send':
ini_set('session.gc_maxlifetime', 604800);
ini_set('session.cookie_lifetime', 604800);
ini_set('session.save_path', '/data/data/ru.kslabs.ksweb/sessions_token');

if ($_COOKIE['authID'] && $_COOKIE['authID']!='' && $_COOKIE['authID']!=null)
      session_id($_COOKIE['authID']);
else if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
      session_id($_POST['Authorization']);

  session_start();
  if (session_id()!=$_COOKIE['authID'] &&  session_id()!=$_POST['Authorization']){
  session_destroy();
  throw new Exception('Invalid authorization id');
  }

  if (!isset($_SESSION['AUTH'])) throw new Exception("Unauth");


  $expires_in=$_SESSION['expires_in'];
  $create_time=$_SESSION['create_time'];
  $difference=time()-$create_time;

  $_SESSION['AUTH']=false;
  if ($_SESSION['REMOTE_ADDR']!=$_SERVER['REMOTE_ADDR']  && $_SESSION['HTTP_USER_AGENT']!=$_SERVER['HTTP_USER_AGENT'])  throw new Exception("Different host or device");//|| $_SESSION['HTTP_USER_AGENT']!=$_SERVER['HTTP_USER_AGENT']

  if (!isset($_SESSION['OAUTH']) || $_SESSION['OAUTH']=='') throw new Exception("No oauth");


  if ($_SESSION['OAUTH']=='VK'){
  if ($difference>=$expires_in){
        throw new Exception("Token error, expires_in");
  }
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
  if (!$token)  throw new Exception("Token error, expires_in");
  else{
  $_SESSION['refresh_token']=$token['refresh_token'];
  $_SESSION['access_token']=$token['access_token'];
  $token=$_SESSION['access_token'];
  }
}
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
  if (!$token) throw new Exception("Token error, expires_in");
  else{
  $_SESSION['refresh_token']=$token['refresh_token'];
  $_SESSION['access_token']=$token['access_token'];
  $token=$_SESSION['access_token'];
  }
  }
}else if ($_SESSION['OAUTH']=='SELF'){

  /*include '../configdb.php';
  $database = 'users'; // имя базы данных

  $link = mysqli_connect($host, $user, $password, $database);
  if (!$link) throw new Exception('No connect to DB');*/


  $query = sprintf("SELECT * FROM main_users WHERE login='%s' AND password='%s'",$_SESSION['login_token'],$_SESSION['access_token']);
  $result=mysqli_query($link,$query);
  if ($token=mysqli_fetch_array($result)){

    $_SESSION['AUTH']=true;
    $_SESSION['NAME']=$token['login'];
    $_SESSION['USERID']=$token['CLIENT_ID'];
    $_SESSION['USERID_INT']=$token['CLIENT_ID'];


  }else throw new Exception('Incorrect login or password');

  if($result)
  mysqli_free_result($result);
}  else throw new Exception("Not valid OAUTH");

  if ($_POST['message']==null || $_POST['message']=='') throw new Exception("Not valid message");

  if ($_SESSION['NAME']=='' || $_SESSION['NAME']==null || !$_SESSION['NAME']) throw new Exception("Not valid name");
  else $name_sender1=$_SESSION['USERID'];
  $name_sender2=$_SESSION['OAUTH'];

  if ($name_sender2!='SELF')
  $query = sprintf("SELECT COUNT(*) FROM messages_streams WHERE display_nameREMOTEDB='%s' AND platform='%s' AND private=0 AND time>'%s'",$name_sender1,$name_sender2,time()-10);
  else $query = sprintf("SELECT COUNT(*)  FROM messages_streams WHERE ID_USER=%s AND private=0 AND time>%s",$name_sender1,time()-10);

  $result=mysqli_query($link,$query);

  $row=mysqli_fetch_array($result);

  if ($row) $count_messages=$row[0];
  else throw new Exception(' '.var_dump($row).' ');
  if ($count_messages>10) throw new Exception("Больше 10 сообщений за десять секунд");

  if ($result){
  mysqli_free_result($result);
  }


  $query = sprintf("SELECT CLIENT_ID FROM main_users WHERE login='%s'",$login);

  $result=mysqli_query($link,$query);
  if ($row=mysqli_fetch_array($result)){
  $id_streamer=$row['CLIENT_ID'];
  }else {
  throw new Exception('No user');
  }
  if ($result){
  mysqli_free_result($result);
  }


  $query = sprintf("SELECT COUNT(*) FROM messages_streams WHERE ID_TO_USER='%s' AND private=0 ",$id_streamer);
  $result=mysqli_query($link,$query);
  $row=mysqli_fetch_array($result);
  if ($row) $count_messages=$row[0];
  else throw new Exception('Too many error');
  if ($count_messages>50) {
    if ($result){
    mysqli_free_result($result);
    }
    $query = sprintf("DELETE FROM messages_streams WHERE ID_TO_USER='%s' AND private=0 ",$id_streamer);
    $result=mysqli_query($link,$query);
  }
  if ($result){
  mysqli_free_result($result);
  }


  $color_string='#'.substr(md5($name_sender1.$name_sender2),0,6);
  //$color_string='#000000';
  if ($name_sender2!='SELF')
  $query = sprintf("INSERT INTO messages_streams (ID_USER,ID_TO_USER,message,time,display_nameREMOTEDB,platform,color_login) VALUES('%s','%s','%s','%s','%s','%s','%s')",41,$id_streamer,$_POST['message'],time(),$name_sender1,$name_sender2,$color_string);
  else
  $query = sprintf("INSERT INTO messages_streams (ID_USER,ID_TO_USER,message,time,color_login) VALUES('%s','%s','%s','%s','%s')",$name_sender1,$id_streamer,$_POST['message'],time(),$color_string);

  $result=mysqli_query($link,$query);
  if ($result){
  mysqli_free_result($result);
  }
$arr['type']=$name_sender1;
$arr['login']=$name_sender2;

  mysqli_close($link);
break;
case 'info':

ini_set('session.gc_maxlifetime', 604800);
ini_set('session.cookie_lifetime', 604800);
ini_set('session.save_path', '/data/data/ru.kslabs.ksweb/sessions_token');

if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
      session_id($_POST['Authorization']);

  session_start();
  if (session_id()!=$_POST['Authorization']){
  session_destroy();
  throw new Exception('Invalid authorization id');
  }

  if (!isset($_SESSION['AUTH'])) throw new Exception("Unauth");


  $expires_in=$_SESSION['expires_in'];
  $create_time=$_SESSION['create_time'];
  $difference=time()-$create_time;

  $_SESSION['AUTH']=false;
  if ($_SESSION['REMOTE_ADDR']!=$_SERVER['REMOTE_ADDR']) throw new Exception("Different host or device");//|| $_SESSION['HTTP_USER_AGENT']!=$_SERVER['HTTP_USER_AGENT']

  if (!isset($_SESSION['OAUTH']) || $_SESSION['OAUTH']=='') throw new Exception("No oauth");


  if ($_SESSION['OAUTH']=='VK'){
  if ($difference>=$expires_in){
        throw new Exception("Token error, expires_in");
  }
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
  if (!$token)  throw new Exception("Token error, expires_in");
  else{
  $_SESSION['refresh_token']=$token['refresh_token'];
  $_SESSION['access_token']=$token['access_token'];
  $token=$_SESSION['access_token'];
  }
}
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
  if (!$token) throw new Exception("Token error, expires_in");
  else{
  $_SESSION['refresh_token']=$token['refresh_token'];
  $_SESSION['access_token']=$token['access_token'];
  $token=$_SESSION['access_token'];
  }
  }
  }
  else throw new Exception("Not valid OAUTH");


  if ($_SESSION['NAME']=='' || $_SESSION['NAME']==null || !$_SESSION['NAME']) throw new Exception("Not valid name");
  else $name_sender1=$_SESSION['USERID'];
  $name_sender2=$_SESSION['OAUTH'];

$arr['type']=$name_sender2;
$arr['login']=$name_sender1;

break;
default:
throw new Exception('No event');
}

}catch (Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
