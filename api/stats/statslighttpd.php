<?php

//ini_set('display_errors', 'Off');

$arr = array('status' => true,"time"=>time(),"date"=>date('l jS \of F Y h:i:s A'));
try{
  if ($_GET['get']=='online'){

    include '../stats.php';

    $database = 'users'; // имя базы данных

    $link = mysqli_connect($host, $user, $password, $database);
    if (!$link) throw new Exception('No connect to DB');

    if ($_GET['login']==null){
    $query = sprintf("SELECT COUNT(*) FROM online");
    //if (!($result=mysqli_query($link,$query))) throw new Exception('Error query search');
  }else{
    $query = sprintf("SELECT COUNT(*) FROM online WHERE query='%s' AND host='%s'",'/'.$_GET['login'],'tv.shass.ru');
  }
    $result=mysqli_query($link,$query);

    $arr['online']=mysqli_fetch_array($result)[0];

    mysqli_close($link);



  }
  if ($_GET['get']=='ip'){
    $arr['remote_ip']=$_SERVER['REMOTE_ADDR'];
  }
}catch(Exception $e){
  $arr['status']=false;
  $arr['error']=$e->getMessage();
}

echo json_encode($arr, JSON_UNESCAPED_UNICODE);
 ?>
