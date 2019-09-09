<?php
ini_set('display_errors', 'Off');
try
{
include 'configdb.php';

$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');


$time= time();
$query = sprintf("SELECT online_id FROM online WHERE remote_ip='%s' AND query='%s' AND host='%s'",$_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'],$_SERVER['SERVER_NAME']);
$result=mysqli_query($link,$query);
if (mysqli_fetch_array($result)){
$query = sprintf("UPDATE online SET expires_in='%s',query='%s',remote_host='%s',host='%s' WHERE remote_ip='%s' AND query='%s' AND host='%s'",$time,$_SERVER['REQUEST_URI'],$_SERVER['HTTP_USER_AGENT'],$_SERVER['SERVER_NAME'] ,$_SERVER['REMOTE_ADDR'],$_SERVER['REQUEST_URI'],
$_SERVER['SERVER_NAME']);}
else {
$query = sprintf("INSERT INTO online (remote_ip,remote_host,query,expires_in,host) VALUES ('%s','%s','%s','%s','%s')",$_SERVER['REMOTE_ADDR'],$_SERVER['HTTP_USER_AGENT'],$_SERVER['REQUEST_URI'],$time,$_SERVER['SERVER_NAME']);
 }
if($result)
mysqli_free_result($result);
if (!($result=mysqli_query($link,$query))) throw new Exception('No update/insert');
if($result)
mysqli_free_result($result);
$query = sprintf("DELETE FROM online WHERE expires_in<%s",time()-200);
if (!($result=mysqli_query($link,$query))) throw new Exception('No delete');
if($result)
mysqli_free_result($result);
mysqli_close($link);
}catch(Exception $e){
}
?>
