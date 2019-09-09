<?php
ini_set('display_errors', 'Off');
$arr = array('status' => true,"time"=>time(),"date"=>date('l jS \of F Y h:i:s A'));
try
{
include '../configdb.php';
include '../stats.php';

if($_GET['from']==NULL) throw new Exception('No number');
$number=$_GET['from'];

$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');

//,main_users.login,main_users.url_stream,main_users.logo_ava,main_users.back_img,main_users.name_stream

$query = sprintf("SELECT a.login,a.url_stream,a.url_preview,a.url_hls_stream,a.logo_ava,a.back_img,a.name_stream,b.viewers FROM main_users as a LEFT JOIN (SELECT main_users.CLIENT_ID as id,COUNT(*) as viewers FROM main_users RIGHT JOIN online ON CONCAT('/',main_users.login)=online.query WHERE online.host='%s' GROUP BY main_users.CLIENT_ID) as b ON a.CLIENT_ID=b.id ORDER BY b.viewers DESC limit %s,%s",'tv.shass.ru',$number,$number+10);
$result=mysqli_query($link,$query);
$arr['result']=null;
if ($row=mysqli_fetch_array($result)){
$arr['result']=array(array('login'=>$row['login'],'url_stream'=>$row['url_stream'],'url_preview'=>$row['url_preview'],'url_hls_stream'=>$row['url_hls_stream'],'logo_ava'=>$row['logo_ava'],'back_img'=>$row['back_img'],'name_stream'=>$row['name_stream'],'viewers'=>$row['viewers']));
while ($row=mysqli_fetch_array($result)){
array_push($arr['result'],array('login'=>$row['login'],'url_stream'=>$row['url_stream'],'url_preview'=>$row['url_preview'],'url_hls_stream'=>$row['url_hls_stream'],'logo_ava'=>$row['logo_ava'],'back_img'=>$row['back_img'],'name_stream'=>$row['name_stream'],'viewers'=>$row['viewers']));
}
}
if ($result){
mysqli_free_result($result);
}

}catch (Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
