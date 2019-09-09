<?php
ini_set('display_errors', 'Off');
$arr = array('status' => true,"time"=>time(),"date"=>date('l jS \of F Y h:i:s A'));
try
{
include '../configdb.php';
if(!$_GET['login'] || $_GET['login']=='') throw new Exception('No login');
$login=$_GET['login'];

$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');

$query = sprintf("SELECT * FROM main_users WHERE login='%s'",$login);
$result=mysqli_query($link,$query);
$row=mysqli_fetch_array($result);
if ($row){
if  ($row['url_stream'] && $row['url_stream']!=NULL){
$arr['url_stream']=$row['url_stream'];
}else $arr['url_stream']=NULL;
$arr['url_preview']=$row['url_preview'];
$arr['url_hls_stream']=$row['url_hls_stream'];
$arr['stream_ip']=$row['stream_ip'];
$arr['logo_img']=$row['logo_ava'];
$arr['back_img']=$row['back_img'];
$arr['name_stream']=$row['name_stream'];
}else {
mysqli_free_result($result);
throw new Exception('Found no login');
}
mysqli_free_result($result);

}catch (Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
