<?php
//include 'config.php';

//session_start();
//setcookie(session_name(),session_id(),time()+604800);
?>
<!doctype html>
<html lang="ru">
  <head>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="/docs/favicon.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/docs/favicon.png" sizes="16x16">
    <link rel="apple-touch-icon" href="/docs/favicon.png" sizes="16x16"/>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, , user-scalable=no, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- local CSS -->
    <link rel="stylesheet" href="/docs/css/main.css">

    <title>SHASS Team</title>
  </head>
  <body>
      <div class="upper-block">
        <img src="/docs/images/title.png" class="upper-block-image"></img>
        <h1 class="font-weight-light">Документация</h1>
      </div>


      <div class="left-block">
        <div class="main-root-tag">
          <a id="id_drone" class="main-root-elements font-weight-light" href="/docs/drone/about">Дрон</a>
        </div>
        <div id="id_drone_second"  class="block-tag">
        <div>
        <a id="id_drone_second0" class="main-second-elements font-weight-light" href="/docs/drone/about">Главная</a>
        </div>
        <div>
        <a id="id_drone_second1" class="main-second-elements font-weight-light" href="/docs/drone/device">Устройство дрона</a>
        </div>
        <div>
          <a id="id_drone_second2" class="main-second-elements font-weight-light" href="/docs/drone/control">Взаимодействие с дроном</a>
        </div>
        <div>
          <a id="id_drone_second3" class="main-second-elements font-weight-light" href="/docs/drone/faq">Возможные ошибки и их испраление</a>
        </div>
        <div>
          <a id="id_drone_second4" class="main-second-elements font-weight-light" href="/docs/drone/ihelp">Интерактивная помощь</a>
        </div>
        <div>
          <a id="id_drone_second5" class="main-second-elements font-weight-light" href="/docs/drone/use">Обслуживание дрона</a>
        </div>
        <div>
          <a id="id_drone_second6" class="main-second-elements font-weight-light" href="/docs/drone/remote">Состояние дронов</a>
        </div>
      </div>
      <div class="main-root-tag">
        <a id="id_device" class="main-root-elements font-weight-light" href="/docs/device/about">Бесконтактная док-станция</a>
      </div>
      <div id="id_device_second"  class="block-tag">
      <div>
      <a id="id_device_second0" class="main-second-elements font-weight-light" href="/docs/device/about">Главная</a>
      </div>
      <div>
      <a id="id_device_second1" class="main-second-elements font-weight-light" href="/docs/device/use">Обслуживание бесконтактной док-станции</a>
      </div>
      <div>
      <a id="id_device_second2" class="main-second-elements font-weight-light" href="/docs/device/ihelp">Интерактивная помощь</a>
      </div>
      <div>
      <a id="id_device_second3" class="main-second-elements font-weight-light" href="/docs/device/control">Взаимодействие с бесконтактной док-станцией</a>
      </div>
    </div>
    <div class="main-root-tag">
      <a id="id_server"  class="main-root-elements font-weight-light" href="/docs/server/about">Сервер</a>
    </div>
    <div id="id_server_second"  class="block-tag">
    <div>
    <a id="id_server_second0" class="main-second-elements font-weight-light" href="/docs/server/about">Главная</a>
    </div>
    <div>
    <a id="id_server_second1" class="main-second-elements font-weight-light" href="/docs/server/use">Обслуживание сервера</a>
    </div>
    <div>
    <a id="id_server_second2" class="main-second-elements font-weight-light" href="/docs/server/ihelp">Интерактивная помощь</a>
    </div>
    <div>
    <a id="id_server_second3" class="main-second-elements font-weight-light" href="/docs/server/device">Устройство сервера</a>
    </div>
    <div>
    <a id="id_server_second4" class="main-second-elements font-weight-light" href="/docs/server/connect">Взаимодействие с сервером</a>
    </div>
  </div>
</div>




      <!-- Main -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<div class="main-block">
<?php
$main_check=-1;
$second_check=-1;
$select_string="";
$first_string="";
$main_url="";
switch($_GET["query_main"]){
  case "drone":
  $main_url="/docs/drone/about";
  $first_string="Дрон";
  $main_check=0;
  switch($_GET["query_second"]){
    case "about":
    $select_string="Главная";
    $second_check=0;
    $page = file_get_contents('drone/about.html');
    break;
    case "device":
    $select_string="Устройство дрона";
    $second_check=1;
    $page = file_get_contents('drone/device.html');
    break;
    case "control":
    $select_string="Взаимодействие с дроном";
    $second_check=2;
    $page = file_get_contents('drone/control.html');
    break;
    case "faq":
    $select_string="FAQ";
    $second_check=3;
    $page = file_get_contents('drone/faq.html');
    break;
    case "ihelp":
    $select_string="Интерактивная помощь";
    $second_check=4;
    $page = file_get_contents('drone/ihelp.html');
    break;
    case "use":
    $select_string="Обслуживание дрона";
    $second_check=5;
    $page = file_get_contents('drone/usedrone.html');
    break;
    case "remote":
    $select_string="Состояние дронов";
    $second_check=6;
    $page = file_get_contents('drone/remote.html');
    break;
    default:
    $second_check=-1;
    $page = file_get_contents('error.php');
    break;
  }
  break;
  case "device":
  $main_url="/docs/device/about";
  $first_string="Бесконтактная док-станция";
  $main_check=1;
  switch($_GET["query_second"]){
    case "about":
    $select_string="Главная";
    $second_check=0;
    $page = file_get_contents('app/about.html');
    break;
    case "use":
    $select_string="Обслуживание бесконтактной док-станции";
    $second_check=1;
    $page = file_get_contents('app/useapp.html');
    break;
    case "ihelp":
    $select_string="Интерактивная помощь";
    $second_check=2;
    $page = file_get_contents('app/ihelp.html');
    break;
    case "control":
    $select_string="Взаимодействие с бесконтактной док-станцией";
    $second_check=3;
    $page = file_get_contents('app/control.html');
    break;
    default:
    $second_check=-1;
    $page = file_get_contents('error.php');
    break;
  }
  break;
  case "server":
  $main_url="/docs/server/about";
  $first_string="Сервер";
  $main_check=2;
  switch($_GET["query_second"]){
    case "about":
    $select_string="Главная";
    $second_check=0;
    $page = file_get_contents('server/about.html');
    break;
    case "use":
    $select_string="Обслуживание сервера";
    $second_check=1;
    $page = file_get_contents('server/useserver.html');
    break;
    case "ihelp":
    $select_string="Интерактивная помощь";
    $second_check=2;
    $page = file_get_contents('server/ihelp.html');
    break;
    case "device":
    $select_string="Устройство сервера";
    $second_check=3;
    $page = file_get_contents('server/device.html');
    break;
    case "connect":
    $select_string="Взаимодействие с сервером";
    $second_check=4;
    $page = file_get_contents('server/connect.html');
    break;
    default:
    $second_check=-1;
    $page = file_get_contents('error.php');
    break;
  }
  break;
  default:
  $main_check=-1;
  $page = file_get_contents('error.php');
  break;
}
  ?>

        <nav aria-label="breadcrumb">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $main_url; ?>"><?php echo $first_string; ?></a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $select_string; ?></li>
          </ol>
        </nav>
      <?php
      echo $page;
      echo "<script>
      var main_check=".$main_check.";
      var second_check=".$second_check.";
      </script>";
      /*try
      {
        echo <a onclick=\"if ($('.title-block-login-info-closed').hasClass('title-block-login-info-open')) $('.title-block-login-info-closed').removeClass('title-block-login-info-open'); else $('.title-block-login-info-closed').addClass('title-block-login-info-open');\" class='title-block-login main-block-login-ava' style='outline: none;background-image: url(".$image_url.");'></a>
        <div class='title-block-login-info-closed'><h1 class='title-block-login-info'>".$data['response'][0]['first_name']." ".$data['response'][0]['last_name']."</h1><button data-toggle=\"modal\" data-target=\"#logoutModal\" type=\"button\" class=\"btn btn-outline-danger title-block-login-logout\">Log out</button></div>";
      }
      catch (Exception $e){
        echo "<button data-toggle=\"modal\" data-target=\"#loginModal\" type=\"button\" class=\"btn btn-outline-success title-block-login\">Log in</button>";
      }*/
      include '../api/stats.php';
      ?>
      </div>

    <script src="/docs/js/main.js"></script>
  </body>
</html>
