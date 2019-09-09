<?php
ini_set('display_errors', 'Off');
try
{
if(!$_GET['login'] || $_GET['login']=='') throw new Exception('No login');
$login=$_GET['login'];

include '../configdb.php';

$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');

$query = sprintf("DELETE FROM online WHERE expires_in<%s",time()-200);
if (!($result=mysqli_query($link,$query))) throw new Exception('No delete');
if($result)
mysqli_free_result($result);

$time=time();

$query = sprintf("SELECT online_id FROM online WHERE remote_ip='%s' AND query='%s' AND host='tv.shass.ru'",$_SERVER['REMOTE_ADDR'],'/'.$login);
$result=mysqli_query($link,$query);
if (mysqli_fetch_array($result)){
$query = sprintf("UPDATE online SET expires_in='%s',query='%s',remote_host='%s',host='%s',from_code='%s' WHERE remote_ip='%s' AND query='%s' AND host='%s'",$time,'/'.$login,$_SERVER['HTTP_USER_AGENT'],'tv.shass.ru',1,$_SERVER['REMOTE_ADDR'],'/'.$login,
'tv.shass.ru');}
else {
$query = sprintf("INSERT INTO online (remote_ip,remote_host,query,expires_in,host,from_code) VALUES ('%s','%s','%s','%s','%s','%s')",$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],'/'.$login,$time,'tv.shass.ru',1);
}

if($result)
mysqli_free_result($result);
if (!($result=mysqli_query($link,$query))) throw new Exception('No update/insert');
if($result)
mysqli_free_result($result);

mysqli_close($link);

}catch (Exception $e){
}
?>
