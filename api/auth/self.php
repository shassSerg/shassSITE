<?php
header('Content-Type: text/html; charset=utf-8');

ini_set('display_errors', 'Off');
ini_set('session.gc_maxlifetime', 604800);
ini_set('session.cookie_lifetime', 604800);
ini_set('session.save_path', '/data/data/ru.kslabs.ksweb/sessions_token');
//setcookie("PHPSESSID", session_id());

$arr = array('status' => true);
try
{

  include '../configdb.php';
  $database = 'users'; // имя базы данных

  $link = mysqli_connect($host, $user, $password, $database);
  if (!$link) throw new Exception('No connect to DB');

  if ($_POST['login']==null || $_POST['password']==null) throw new Exception('No login or password');

  $query = sprintf("SELECT * FROM main_users WHERE login=? AND password=?");

  $stmt = mysqli_stmt_init($link);
  if(!mysqli_stmt_prepare($stmt, $query))
  {
      throw new Exception('No prepare query');
  }
  mysqli_stmt_bind_param($stmt, "ss",$_POST['login'],hash('sha512',$_POST['password']));
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  //$result=mysqli_query($link,$query);


  if ($token=mysqli_fetch_array($result)){
  }else throw new Exception('Incorrect login or password');

  if($result)
  mysqli_free_result($result);


mysqli_stmt_close($stmt);
mysqli_close($link);

if ($_COOKIE['authID'] && $_COOKIE['authID']!='' && $_COOKIE['authID']!=null)
      session_id($_COOKIE['authID']);
else if ($_POST['Authorization'] && $_POST['Authorization']!='' && $_POST['Authorization']!=null)
      session_id($_POST['Authorization']);

session_start();

$_SESSION['login_token']=$token['login'];
$_SESSION['access_token']=$token['password'];
$_SESSION['REMOTE_ADDR']=$_SERVER['REMOTE_ADDR'];
$_SESSION['HTTP_USER_AGENT']=$_SERVER['HTTP_USER_AGENT'];
$_SESSION['OAUTH']='SELF';
$_SESSION['expires_in']=-1;
$_SESSION['create_time']=time();
$arr['authID']=session_id();
setcookie('authID', session_id(), time() + 604800, '/', '.shass.ru');

}catch (Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}
echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
