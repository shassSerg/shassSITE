<?php
ini_set('display_errors', 'Off');
$arr = array('status' => true,"time"=>time(),"date"=>date('l jS \of F Y h:i:s A'));
try
{
include 'configdb.php';



$database = 'users'; // имя базы данных

$link = mysqli_connect($host, $user, $password, $database);
if (!$link) throw new Exception('No connect to DB');


if ($_GET['event']==='get'){
if ($_GET['index']!=null) $from_index=$_GET['index'];
else throw new Exception('No index');

if ($_GET['id']== null || strlen($_GET['id'])==0) throw new Exception('No id');
$session_support=$_GET['id'];


$time= time();
//clear last messages late without answer 24hours
$query = sprintf("DELETE FROM messages_support WHERE TIME<='%s'",$time-86400);
mysqli_query($link,$query);


$query = sprintf("SELECT * FROM messages_support WHERE IP_ADDRESS='%s' AND access='%s' AND ID_MESSAGE>'%s' ORDER BY ID_MESSAGE",$_SERVER['REMOTE_ADDR'],$session_support,$from_index);
$result=mysqli_query($link,$query);
$arr['index']=null;
$arr['result']=null;
if ($row=mysqli_fetch_array($result)){
$arr['result']=array(array('GET_ANSWER'=>$row['GET_ANSWER'],'TIME'=>$row['TIME'],'IP_ADDRESS'=>$row['IP_ADDRESS'],'TEXT'=>$row['TEXT'],'ID_MESSAGE'=>$row['ID_MESSAGE']));
while ($row=mysqli_fetch_array($result)){
array_push($arr['result'],(array('GET_ANSWER'=>$row['GET_ANSWER'],'TIME'=>$row['TIME'],'IP_ADDRESS'=>$row['IP_ADDRESS'],'TEXT'=>$row['TEXT'],'ID_MESSAGE'=>$row['ID_MESSAGE'])));
}

$index_of_last_message=$arr['result'][count($arr['result'])-1]['ID_MESSAGE'];
$arr['index']=$index_of_last_message;

//if ($from_index==-1) $arr['result']=null;
}else {
  if ($result){
  mysqli_free_result($result);
  }
  $query = sprintf("SELECT * FROM messages_support WHERE IP_ADDRESS='%s' AND access='%s' ORDER BY ID_MESSAGE DESC",$_SERVER['REMOTE_ADDR'],$session_support);
  $result=mysqli_query($link,$query);
  $arr['result']=null;
  if ($row=mysqli_fetch_array($result) && $row['ID_MESSAGE']>$from_index){
  $arr['result']=array(array('GET_ANSWER'=>$row['GET_ANSWER'],'TIME'=>$row['TIME'],'IP_ADDRESS'=>$row['IP_ADDRESS'],'TEXT'=>$row['TEXT'],'ID_MESSAGE'=>$row['ID_MESSAGE']));
  while ($row=mysqli_fetch_array($result)){
array_push($arr['result'],(array('GET_ANSWER'=>$row['GET_ANSWER'],'TIME'=>$row['TIME'],'IP_ADDRESS'=>$row['IP_ADDRESS'],'TEXT'=>$row['TEXT'],'ID_MESSAGE'=>$row['ID_MESSAGE'])));
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

}else if ($_GET['event']==='send'){

  if ($_GET['id']== null || strlen($_GET['id'])==0) throw new Exception('No id');
  $session_support=$_GET['id'];

  $query = sprintf("SELECT COUNT(*) FROM messages_support WHERE IP_ADDRESS='%s'",$_SERVER['REMOTE_ADDR']);
  $result=mysqli_query($link,$query);
  $row=mysqli_fetch_array($result);
  if ($row) $count_messages=$row[0];
  else throw new Exception('Too many error');
  if ($count_messages>300) {
    throw new Exception('Too many error');
  }
  if ($result){
  mysqli_free_result($result);
  }


  $query = sprintf("SELECT COUNT(*) FROM messages_support WHERE IP_ADDRESS='%s' AND access='%s'",$_SERVER['REMOTE_ADDR'],$session_support);
  $result=mysqli_query($link,$query);
  $row=mysqli_fetch_array($result);
  if ($row) $count_messages=$row[0];
  else throw new Exception('Too many error');
  if ($count_messages>20) {
    if ($result){
    mysqli_free_result($result);
    }
    $query = sprintf("DELETE FROM messages_support WHERE IP_ADDRESS='%s' AND access='%s'",$_SERVER['REMOTE_ADDR'],$session_support);
    $result=mysqli_query($link,$query);
  }
  if ($result){
  mysqli_free_result($result);
  }

  $time= time();
  //clear last messages late without answer 24hours
  $query = sprintf("DELETE FROM messages_support WHERE TIME<='%s'",$time-86400);
  mysqli_query($link,$query);

  if ($_POST['message']==null || strlen($_POST['message'])==0) throw new Exception('Empty message');

  $query = sprintf("INSERT INTO messages_support (TIME,GET_ANSWER,IP_ADDRESS,TEXT,access) VALUES('%s','%s','%s','%s','%s')",time(),0,$_SERVER['REMOTE_ADDR'],htmlspecialchars($_POST['message'], ENT_QUOTES),$session_support);
  $result=mysqli_query($link,$query);
  if (!$result) throw new Exception("Error send");
  if ($result){
    mysqli_free_result($result);
    }
}else throw new Exception('Undefinded event');

}catch (Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
?>
