<?php
echo '<script> const login="'.$_GET['login'].'"; </script>';
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

<!doctype html>
<html lang="ru">
  <head>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png" sizes="16x16">
    <link rel="icon" type="image/png" href="images/favicon.png" sizes="16x16">
    <link rel="apple-touch-icon" href="images/favicon.png" sizes="16x16"/>


    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- local CSS -->
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/streams.css">
    <link rel="stylesheet" href="css/login.css">


    <!-- Video.js-->
    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <link href="https://vjs.zencdn.net/7.4.1/video-js.css" crossorigin="anonymous" rel="stylesheet">
    <script crossorigin="anonymous" src="https://vjs.zencdn.net/7.4.1/video.js"></script>

    <title>SHASS Team</title>
  </head>
  <body>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Вы уверены, что хотите выйти?</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p>Подтвердите выход из аккаунта.</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отменить</button>
            <button id='logoutSuccess' type="button" class="btn btn-primary">Выйти</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Выберите платформу для авторизации</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <div id="login_message_alert" class='login-alerts-class-contacts'>
              </div>
            <form id='form_to_login'>
  <div class="form-group">
    <label for="exampleInputEmail1">Логин</label>
    <input name="login" type="login" class="form-control" id="exampleInputEmail1" aria-describedby="" placeholder="Введите логин">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Пароль</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Пароль">
  </div>
<!--  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Запомнить</label>
  </div>-->
  <button type="submit" id='form_login_button' class="btn btn-primary">Ввойти</button>
</form>
  <hr>  <h5>Другие платформы:</h5>
            <a id='vk_button_login' role="button" class="btn popover-test  login-vk-logo" title="VK" data-content=""></a>
            <a id='yandex_button_login' role="button" class="btn popover-test login-yandex-logo" title="Yandex" data-content=""></a>
            <a id='twitch_button_login' role="button" class="btn popover-test login-twitch-logo" title="Twitch" data-content=""></a>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
          </div>
        </div>
      </div>
    </div>


    <!--<div class='loader'></div> -->
    <!--React JS -->
    <script crossorigin src="https://unpkg.com/react@16/umd/react.production.min.js"></script>
    <!--<script crossorigin src="https://unpkg.com/react-dom@16/umd/react-dom.production.min.js"></script>-->
    <script src="js/react-dom.js"></script>

    <!-- Optional JavaScript
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <!--Babel
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script> -->

    <!-- local JavaScript -->
    <script src="js/chat.js"></script>
    <script src="js/streamers.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>
