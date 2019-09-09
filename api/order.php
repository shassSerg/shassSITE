<?php
ini_set('display_errors', 'Off');
$arr = array('status' => true,"time"=>time(),"date"=>date('l jS \of F Y h:i:s A'));
try
{
include 'configdb.php';


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

if ($_SESSION['REMOTE_ADDR']!=$_SERVER['REMOTE_ADDR']  && $_SESSION['HTTP_USER_AGENT']!=$_SERVER['HTTP_USER_AGENT'])  throw new Exception("Different host or device");
$_SESSION['AUTH']=false;

//check access
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

if ($_GET["event"]==="get"){

  $type_sort=0;
  if ($_GET["sort"]!=null){
    if ($_GET["sort"]=="1")
    $type_sort=1;
    else if ($_GET["sort"]=="0")
    $type_sort=0;
    else if ($_GET["sort"]=="3")
    $type_sort=3;
    else if ($_GET["sort"]=="2")
    $type_sort=2;
    else throw new Exception("Undefinded sort type.");
  }

  $filter_type=0;
  if ($_GET["filter"]!=null){
    if ($_GET["filter"]=="1")
    $filter_type=1;
    else if ($_GET["filter"]=="0")
    $filter_type=0;
    else if ($_GET["filter"]=="2")
    $filter_type=2;
    else throw new Exception("Undefinded filter type.");
  }


  $search=null;
  if ($_GET["search"]!=null){
    $search=$_GET["search"] ;
  }

  if ($_GET["number"]!=null){
    $number=$_GET["number"];
  }  else throw new Exception("Undefinded number.");


$query = sprintf("SELECT id_order,points,title,desc_order,date_start,date_end,back_image,max_points,max_points-points as total_points FROM orders WHERE ID_USER='%s'", $_SESSION['USERID']);

switch ($filter_type) {
  case 1:
    $query=$query." AND (max_points-points)=0";
  break;
  case 2:
    $query=$query." AND (max_points-points)<>0";
  break;
  default:
  break;
}

if ($search!=null)
$query=$query.sprintf(" AND (title LIKE '%s' OR desc_order LIKE '%s')",  '%'.$search.'%',  '%'.$search.'%');

switch ($type_sort) {
  case 1:
    $query=$query." ORDER BY date_start DESC";
  break;
  case 2:
    $query=$query." ORDER BY total_points";
  break;
  case 3:
    $query=$query." ORDER BY total_points DESC";
  break;
  default:
    $query=$query." ORDER BY date_start";
  break;
}

$query=$query.sprintf(" limit %s,%s",$number,$number+10);


$result=mysqli_query($link,$query);
$arr['result']=null;
if ($row=mysqli_fetch_array($result)){
$arr['result']=array(array('id_order'=>$row['id_order'],'points'=>$row['points'],'title'=>$row['title'],'desc_order'=>$row['desc_order'],'date_start'=>$row['date_start'],'date_end'=>$row['date_end'],'back_image'=>$row['back_image'],'max_points'=>$row['max_points']));
while ($row=mysqli_fetch_array($result)){
array_push($arr['result'],array('id_order'=>$row['id_order'],'points'=>$row['points'],'title'=>$row['title'],'desc_order'=>$row['desc_order'],'date_start'=>$row['date_start'],'date_end'=>$row['date_end'],'back_image'=>$row['back_image'],'max_points'=>$row['max_points']));
}
}
if ($result){
mysqli_free_result($result);
}
}
else if ($_GET["event"]==="delete"){

if ($_GET["index"]!=null)
$index_order=$_GET["index"];
else throw new Exception("Undefinded index");

$query = sprintf("DELETE FROM orders WHERE id_order='%s'",$index_order);
$result=mysqli_query($link,$query);
if (!$result){
throw new Exception("Error delete");

}
if ($result){
mysqli_free_result($result);
}

}
else {
throw new Exception("Undefinded event");
}




}catch (Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
