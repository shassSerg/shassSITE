<?php
ini_set('display_errors', 'Off');
$arr = array('status' => true,"time"=>time(),"date"=>date('l jS \of F Y h:i:s A'));
try
{

if(($_GET['event']!="update_drone" && $_GET['event']!="get_drone" && $_GET['event']!="get" && $_GET['event']!="send") || ($_GET['event']=="send" && $_GET['drone']==NULL )|| ($_GET['event']=="get" && $_GET['drone']==NULL)) throw new Exception('Incorrect event');

include '../configdb.php';

$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');

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


  $query = sprintf("DELETE FROM drone_control WHERE time<%s",time()-200);
  if (!($result=mysqli_query($link,$query))) throw new Exception('No delete');
  if($result)
  mysqli_free_result($result);

  $query = sprintf("DELETE FROM drones WHERE time<%s",time()-200);
  if (!($result=mysqli_query($link,$query))) throw new Exception('No delete');
  if($result)
  mysqli_free_result($result);

if ($_GET['event']=="get"){
  if ($_GET['control']) $control=true;
  else $control=false;

  $query = sprintf("SELECT a.user_id,a.drone_id,a.time,a.packet_mt,a.packet_t,a.value,a.packet_id FROM drone_control AS a WHERE a.user_id=%s AND a.drone_id=%s AND control='%s'",$_SESSION['USERID'],$_GET['drone'],$control);
  $result=mysqli_query($link,$query);
  $arr['result']=null;
  if ($row=mysqli_fetch_array($result)){
  $arr['result']=array(array('user_id'=>$row['user_id'],'drone_id'=>$row['drone_id'],'time'=>$row['time'],'packet_mt'=>$row['packet_mt'],'packet_t'=>$row['packet_t'],'value'=>$row['value'],'packet_id'=>$row['packet_id']));
  while ($row=mysqli_fetch_array($result)){
  array_push($arr['result'],array('user_id'=>$row['user_id'],'drone_id'=>$row['drone_id'],'time'=>$row['time'],'packet_mt'=>$row['packet_mt'],'packet_t'=>$row['packet_t'],'value'=>$row['value'],'packet_id'=>$row['packet_id']));
  }
  }

  //delete


}else if ($_GET['event']=="send"){

  $query = sprintf("SELECT COUNT(DISTINCT drone_id)  FROM drone_control WHERE user_id=%s",$_SESSION['USERID']);

  $result=mysqli_query($link,$query);

  $row=mysqli_fetch_array($result);

  if ($row) $count_messages=$row[0];
  else throw new Exception(' '.var_dump($row).' ');
  if ($count_messages>5) {
    $query = sprintf("DELETE FROM drone_control WHERE user_id=%s",$_SESSION['USERID']);
    if (!($result=mysqli_query($link,$query))) throw new Exception('No delete');
    if($result)
    mysqli_free_result($result);
  }

  if ($result){
  mysqli_free_result($result);
  }


  $query = sprintf("SELECT COUNT(*)  FROM drone_control WHERE user_id=%s AND drone_id=%s",$_SESSION['USERID'],$_GET['drone']);

  $result=mysqli_query($link,$query);

  $row=mysqli_fetch_array($result);

  if ($row) $count_messages=$row[0];
  else throw new Exception(' '.var_dump($row).' ');
  if ($count_messages>100) {
    $query = sprintf("DELETE FROM drone_control WHERE user_id=%s AND drone_id=%s",$_SESSION['USERID'],$_GET['drone']);
    if (!($result=mysqli_query($link,$query))) throw new Exception('No delete');
    if($result)
    mysqli_free_result($result);
  }

  if ($result){
  mysqli_free_result($result);
  }

  if ($_GET['control']) $control=true;
  else $control=false;

  $query = sprintf("INSERT INTO drone_control (drone_id,user_id,packet_mt,packet_t,time,value,control) VALUES('%s','%s','%s','%s','%s','%s','%s')",$_GET['drone'],$_SESSION['USERID'],$_POST['main_type'],$_POST['type'],time(),$_POST['value'],$control);

  $result=mysqli_query($link,$query);
  if ($result){
  mysqli_free_result($result);
}else throw new Exception('No send');


}else if ($_GET['event']=="get_drone"){

  $query = sprintf("SELECT a.drone_id,a.user_id,a.voltage,a.current,a.temp,a.height,a.left_d,a.right_d,a.rotate FROM drones AS a WHERE a.user_id=%s",$_SESSION['USERID']);
  $result=mysqli_query($link,$query);
  $arr['result']=null;
  if ($row=mysqli_fetch_array($result)){
  $arr['result']=array(array('drone_id'=>$row['drone_id'],'user_id'=>$_SESSION['USERID'],'voltage'=>$row['voltage'],'current'=>$row['current'],'temp'=>$row['temp'],'height'=>$row['height'],'left_d'=>$row['left_d'],'right_d'=>$row['right_d'],'rotate'=>$row['rotate']));
  while ($row=mysqli_fetch_array($result)){
  array_push($arr['result'],array('drone_id'=>$row['drone_id'],'user_id'=>$_SESSION['USERID'],'voltage'=>$row['voltage'],'current'=>$row['current'],'temp'=>$row['temp'],'height'=>$row['height'],'left_d'=>$row['left_d'],'right_d'=>$row['right_d'],'rotate'=>$row['rotate']));
  }
  }

}
else if ($_GET['event']=="update_drone"){

  $drone_id=$_GET['drone'];
  if ($drone_id==NULL || $drone_id=="") throw new Exception('No drone id');


  $query = sprintf("SELECT COUNT(*) FROM drones WHERE user_id=%s",$_SESSION['USERID']);

  $result=mysqli_query($link,$query);

  $row=mysqli_fetch_array($result);

  if ($row) $count_messages=$row[0];
  else throw new Exception(' '.var_dump($row).' ');
  if ($count_messages>5) {
    $query = sprintf("DELETE FROM drones WHERE user_id=%s",$_SESSION['USERID']);
    if (!($result=mysqli_query($link,$query))) throw new Exception('No delete');
    if($result)
    mysqli_free_result($result);
  }

  if ($result){
  mysqli_free_result($result);
  }


  $query = sprintf("INSERT INTO drones (drone_id,user_id,voltage,current,temp,rotate,height,left_d,right_d,time) VALUES('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s') ON DUPLICATE KEY UPDATE drone_id='%s',user_id='%s',voltage='%s',current='%s',temp='%s',rotate='%s',height='%s',left_d='%s',right_d='%s',time='%s';",
  $_GET['drone'],$_SESSION['USERID'],$_POST['voltage'],$_POST['current'],$_POST['temp'],$_POST['rotate'],$_POST['height'],$_POST['left_d'],$_POST['right_d'],time(),
   $_GET['drone'],$_SESSION['USERID'],$_POST['voltage'],$_POST['current'],$_POST['temp'],$_POST['rotate'],$_POST['height'],$_POST['left_d'],$_POST['right_d'],time());

  $result=mysqli_query($link,$query);

  if (!$result)
    throw new Exception('No update');



}else throw new Exception('No event');



}catch (Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
