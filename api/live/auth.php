<?php
ini_set('display_errors', 'Off');
try
{

include '../configdb.php';
if($_POST['tcurl']==NULL) throw new Exception();
$url_stream=$_POST['tcurl'];
if($_POST['name']==NULL) throw new Exception();


$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');

$query = sprintf("SELECT * FROM main_users WHERE secret_key='%s'",$_POST['name']);
$result=mysqli_query($link,$query);
$row=mysqli_fetch_array($result);
if ($row){
mysqli_free_result($result);
$parsed_url=parse_url($url_stream);
$query = sprintf("UPDATE main_users SET url_stream='%s',url_preview='%s',url_hls_stream='%s',stream_ip='%s' WHERE CLIENT_ID='%s'",$url_stream.'/'.$row['login'],
'https://'.$parsed_url['host'].':4430'.$parsed_url['path'].'/'.$row['login'].'/preview.png','https://'.$parsed_url['host'].':4430'.$parsed_url['path'].'/'.$row['login'].'/index.m3u8',$_SERVER['REMOTE_ADDR'],$row['CLIENT_ID']);
if (!($result=mysqli_query($link,$query))) throw new Exception();
mysqli_free_result($result);
$name_channel=$row['login'];
}else {
mysqli_free_result($result);
throw new Exception();
}

//$url_stream='rtmp://127.0.0.1/live';
//echo "Location: ".$url_stream.'/'.$name_channel;
http_response_code(302);
header("Location:".$name_channel);
exit;
}catch (Exception $e){
http_response_code(404);
}
?>
