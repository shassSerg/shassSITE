<?php
//include 'config.php';

//session_start();
//setcookie(session_name(),session_id(),time()+604800);
?>
<!doctype html>
<html lang="ru">
  <head>
    <!--Favicon-->
    <link rel="shortcut icon" type="image/png" href="/favicon.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/favicon.png" sizes="16x16">
    <link rel="apple-touch-icon" href="/favicon.png" sizes="16x16"/>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, , user-scalable=no, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <!-- local CSS -->
    <link rel="stylesheet" href="css/main-block.css">
    <link rel="stylesheet" href="css/drone-block.css">
    <link rel="stylesheet" href="css/about-block.css">
    <link rel="stylesheet" href="css/bottom-block.css">
    <link rel="stylesheet" href="css/members-block.css">
    <link rel="stylesheet" href="css/contacts-block.css">
    <link rel="stylesheet" href="css/download-block.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/wave.css">

    <!-- ========== CHAT ========================-->
    <link rel="stylesheet" href="css/chat.css">

    <title>SHASS Team</title>
  </head>
  <body>
    <!-- ========== CHAT ========================-->
    <div class="support-chat-open" onclick="showChat();">
      <img src="/images/chat_icon.png" class="support-chat-open-image"></img>
    </div>
    <div class="support-chat-open-back1">
    </div>
    <div class="support-chat-open-back2">
    </div>
    <div class="support-chat">
      <div class="support-chat-header"><h1 >Чат-поддержка</h1>
      <div onclick="hideChat();" class="support-chat-header-hide"><span class="support-chat-header-hide-span1"></span><span class="support-chat-header-hide-span2"></span></div></div>
      <div class="messaging">
            <div class="inbox_msg">
              <div class="mesgs">
                <div class="msg_history">
                  <div class="incoming_msg">
                    <div class="incoming_msg_img"> <img src="/images/support_helper.png" alt="support"> </div>
                    <div class="received_msg">
                      <div class="received_withd_msg">
                        <p>Сеанс технической поддержки будет открыт на 24 часа с момента отправки Вашего сообщения. После истечения срока сеанс будет закрыт. </p>
                        <span class="time_date"></span></div>
                    </div>
                  </div>
                  <div class="incoming_msg">
                    <div class="incoming_msg_img"> <img src="/images/support_helper.png" alt="support"> </div>
                    <div class="received_msg">
                      <div class="received_withd_msg">
                        <p>Техническая поддержка постарается решить Вашу проблему в кратчайшие сроки. Задавайте Ваш вопрос.</p>
                        <span class="time_date"> </span></div>
                    </div>
                  </div>
                  <!--
                  <div class="outgoing_msg">
                    <div class="sent_msg">
                      <p>Test which is a new approach to have all
                        solutions</p>
                      <span class="time_date"> 11:01 AM    |    June 9</span> </div>
                  </div>-->
                </div>
                <div class="type_msg">
                  <div class="input_msg_write">
                    <input type="text" placeholder="Type a message" id="input_chat_support"/>
                    <button class="msg_send_btn" type="button" onclick="SendMessage();"><i class="input_msg_write_i"></i></button>
                  </div>
                </div>
              </div>
            </div>

          </div>
    </div>
    <!-- ====================================== -->




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





    <!--Временное изменение фона-->
    <!--<div id="main-page-img"></div>-->
    <video id="main-page-img" src="/video/drone_intro.mp4" autoplay="" height="100%" muted loop ></video>

    <!-- Logo -->
     <div id='upper_block_main' class="main-upper-block">
      <a href="https://shass.ru/#main" class="main-upper-block-logo-behind">
        <div class="main-upper-block-logo">
        </div>
      </a>
      <div class="short-button-menu" onclick="
      if ($('.short-button-menu').hasClass('short-button-menu-open')) $('.short-button-menu').removeClass('short-button-menu-open'); else $('.short-button-menu').addClass('short-button-menu-open');
      if ($('.mobile-nav').hasClass('mobile-nav-after')) $('.mobile-nav').removeClass('mobile-nav-after'); else $('.mobile-nav').addClass('mobile-nav-after');">
              <span class="bar bar-top"></span>
              <span class="bar bar-mid"></span>
              <span class="bar bar-bot"></span>
    </div>
      <!-- Navs -->
      <ul class="nav main-block-nav">
        <li class="nav-item">
          <a class="nav-link active main-block-local" href="#main">Main</a>
        </li>
        <li class="nav-item">
          <a class="nav-link main-block-local" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link main-block-local" href="#contacts">Contact us</a>
        </li>
      </ul>

      <ul class="nav main-block-nav">
        <li class="nav-item">
          <a class="nav-link active main-block-local" href="#main">Main</a>
        </li>
        <li class="nav-item">
          <a class="nav-link main-block-local" href="#about">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link main-block-local" href="#contacts">Contact us</a>
        </li>
      </ul>

      <div class="mobile-nav">
        <li  class="mobile-href">
          <a href="#main">Main</a>
        </li>
                <li  class="mobile-href">
          <a href="#about">About</a>
            </li>
                            <li  class="mobile-href">
          <a href="#contacts">Contact us</a>
                      </li>
      </div>
      <div id='box_logo_main' class='logo-box-upper-block-right'>
      <div id='logo_loader' class="loader" style='display: none'></div>
      </div>
      <div id='box_logo_info' class='logo-box-upper-block-right'>
      </div>
      <!-- Login -->
      <?php
      /*try
      {
        echo <a onclick=\"if ($('.title-block-login-info-closed').hasClass('title-block-login-info-open')) $('.title-block-login-info-closed').removeClass('title-block-login-info-open'); else $('.title-block-login-info-closed').addClass('title-block-login-info-open');\" class='title-block-login main-block-login-ava' style='outline: none;background-image: url(".$image_url.");'></a>
        <div class='title-block-login-info-closed'><h1 class='title-block-login-info'>".$data['response'][0]['first_name']." ".$data['response'][0]['last_name']."</h1><button data-toggle=\"modal\" data-target=\"#logoutModal\" type=\"button\" class=\"btn btn-outline-danger title-block-login-logout\">Log out</button></div>";
      }
      catch (Exception $e){
        echo "<button data-toggle=\"modal\" data-target=\"#loginModal\" type=\"button\" class=\"btn btn-outline-success title-block-login\">Log in</button>";
      }*/
      include 'api/stats.php';
      ?>
    </div>



    <section id="main">
      <div id="main-page-img-back-block">
        <button type="button" class="btn btn-outline-success main-block-button" onclick='GoToHash("#about");'>Узнать больше</button>
        <div id="main-title-block">
          <h1 class="lead">SHASS Project</h1>
          <h2 class="lead">program better be better</h2>
        </div>

        <div id="main-title-block-sponsors">
          <div id="main-title-block-sponsors-left">
              <img  id="main-title-block-sponsors-left-image" src="/images/sponsor0.png"> </img>
          </div>
          <div id="main-title-block-sponsors-right">
              <img   id="main-title-block-sponsors-right-image"  src="/images/sponsor1.png"> </img>
          </div>
        </div>


        <div class="waveWrapper waveAnimation">
            <div class="waveWrapperInner bgTop">
                <div class="wave waveTop" style="background-image: url('images/wave-main3.png')">
                </div>
            </div>
            <div class="waveWrapperInner bgMiddle">
                <div class="wave waveMiddle" style="background-image: url('images/wave-main3.png')">
                </div>
            </div>
            <div class="waveWrapperInner bgBottom">
                <div class="wave waveBottom" style="background-image: url('images/wave-main3.png')">
                </div>
            </div>
        </div>
      </div>
     </section>
     <section id="about">
       <div class="about-first-row">
       <div class="about-first-row-under">
          <img class="about-first-image"  src="/images/scan_room2.png"/>
          <div class="first-about-text">
          <h1 class="h1-first-block-about font-weight-light">Удобно. Легко. Быстро.</h1>
          <span class="about-span-first"></span>
          <h2 class="h2-first-block-about font-weight-light">Вы можете получить цифровую копию различных помещений без особых проблем</h2>
        </div>
       </div>
     </div>
       <div class="about-second-row">
                <div class="about-second-row-under">
         <img class="about-second-image"  src="/images/scan_str.png"/>
         <div class="second-about-text">
         <h1 class="h1-second-block-about font-weight-light">Сканирование объектов инфраструктуры</h1>
         <span class="about-span-second"></span>
         <h2 class="h2-second-block-about font-weight-light">Создание цифровой копии объектов инфраструктуры, в том числе дорог и объектов строительства</h2>
       </div>
       </div>
     </div>
    </section>

    <section id="drone">
      <div class="drone-container">
      <img  class="drone-image" src="/images/drone.png"> </img>
      <div  class="drone-image-under">
      <h1 class="drone-image-under-left">SHASS</h1>
      <h1 class="drone-image-under-right">Drone</h1>
    </div>
    <div class="row drone-row" id="id-drone-row">
  <div class="col drone-col">
          <img  class="drone-little-image" src="/images/drone_save.png"> </img>
          <h1 class="drone-little-title-main font-weight-light" >Безопасность</h2>
            <span class="drone-span"></span>
           <h2 class="drone-little-title  font-weight-light" >Дрон оснащен 6 ультразвуковыми датчиками, а также многими другими, которые обеспечивают безопасность дрона, даже в помещении</h2>
  </div>
  <div class="col drone-col">
          <img  class="drone-little-image" src="/images/drone_android.png"> </img>
          <h1 class="drone-little-title-main font-weight-light" >Андроид</h2>
              <span class="drone-span"></span>
           <h2 class="drone-little-title  font-weight-light" >Возможность управлять дроном с андроид устройства</h2>
  </div>
  <div class="col drone-col">
      <img  class="drone-little-image" src="/images/drone_auto.png"> </img>
      <h1 class="drone-little-title-main font-weight-light" >Автоматическое управление</h2>
          <span class="drone-span"></span>
       <h2 class="drone-little-title  font-weight-light" >Возможность полностью настроить дрона, в том числе на выполнение каких-либо задач</h2>
  </div>
  <div class="col drone-col">
      <img  class="drone-little-image" src="/images/drone_5G.png"> </img>
      <h1 class="drone-little-title-main font-weight-light" >5G технология</h2>
          <span class="drone-span"></span>
       <h2 class="drone-little-title  font-weight-light" >Дрон поддерживает новейшую технологию 5G</h2>
  </div>
</div>
    </div>
   </section>


       <section id="members">
         <!-- Header -->
         <header class="bg-primary text-center py-5 mb-4 members-header">
           <div class="container members-container-header">
             <h1 class="font-weight-light">Наша команда</h1> <!--text-white-->
           </div>
         </header>

         <!-- Page Content -->
         <div class="container members-container">
           <div class="row members-row">
             <!-- Team Member 1 -->
             <div class="col-xl-3 col-md-6 mb-4  members-col">
               <div class="card border-0 shadow">
                                  <div class="card-img-top members-div">
                 <div style="background: url('/images/creator.jpg');background-size: cover;" class="members-image" alt="Serg"></div>
               </div>
                 <div class="card-body text-center">
                   <h5 class="card-title mb-0">Сергей Шастин</h5>
                   <div class="card-text text-black-50">Разработчик</div>
                 </div>
               </div>
             </div>
             <!-- Team Member 2 -->
             <div class="col-xl-3 col-md-6 mb-4   members-col">
               <div class="card border-0 shadow">
                                  <div class="card-img-top members-div">
                <div style="background: url('/images/member1.jpg');background-size: cover;" class="members-image" alt="Ostrouh"></div>
               </div>
                 <div class="card-body text-center">
                   <h5 class="card-title mb-0">Остроух А.В.</h5>
                   <div class="card-text text-black-50">Ментор</div>
                 </div>
               </div>
             </div>
             <!-- Team Member 3 -->
             <div class="col-xl-3 col-md-6 mb-4   members-col">
               <div class="card border-0 shadow">
                                  <div class="card-img-top members-div">
                <div style="background: url('/images/member2.jpg');background-size: cover;" class="members-image" alt="Mihail"></div>
               </div>
                 <div class="card-body text-center">
                   <h5 class="card-title mb-0">Михаил Даньшин</h5>
                   <div class="card-text text-black-50">Разработчик</div>
                 </div>
               </div>
             </div>
             <!-- Team Member 4 -->
             <div class="col-xl-3 col-md-6 mb-4   members-col">
               <div class="card border-0 shadow">
                 <div class="card-img-top members-div">
                <div style="background: url('/images/member3.jpg');background-size: cover;" class="members-image" alt="Lev"></div>
               </div>
                 <div class="card-body text-center">
                   <h5 class="card-title mb-0">Лев Еникеев</h5>
                   <div class="card-text text-black-50">Разработчик</div>
                 </div>
               </div>
             </div>
           </div>
           <!-- /.row -->

         </div>
         <!-- /.container -->
      </section>

     <section id="download">
       <div style="
    right: -180px;
    bottom: -230px;
    background: #e0c432a8;
    width: 300px;
    height: 700px;
    position: absolute;
    transform: rotate(45deg);
"></div>
<div style="
    right: -130px;
    bottom: -170px;
    background: #b12a129c;
    width: 200px;
    height: 600px;
    position: absolute;
    transform: rotate(45deg);
"></div>
       <img id="id-smartphone-download" class="smartphone-download" src="/images/get_app.png"/>
       <div class="container-for-download">
       <!--<h1>About</h1>-->
       <h1 class="font-weight-light">#Попробовать сервис на Android</h1>
      <div class="download-block-title">
        <h2 class="font-weight-light">Просто наведите камеру Android устройства на QR-код ниже:</h2>
        <img class="qr-download"  src="/images/qr-download.png"/>
        <h2 class="font-weight-light">или</h2>
        <form method="get" action="/download/beeIT-MADI.apk">
          <button type="submit" class="btn btn-primary">Скачать BETA</button>
      </form>
      </div>
      </div>


       <div class="waveWrapper waveAnimation">
         <div class="waveWrapperInner bgTop">
             <div class="wave waveTop" style="background-image: url('images/wave-main-dark.png')">
             </div>
         </div>
         <div class="waveWrapperInner bgMiddle">
             <div class="wave waveMiddle" style="background-image: url('images/wave-main-dark.png')">
             </div>
         </div>
           <div class="waveWrapperInner bgBottom">
               <div class="wave waveBottom" style="background-image: url('images/wave-main-dark.png')">
               </div>
           </div>
       </div>
    </section>
    <section id="contacts">
        <h1 class="contacs-contact-us">Contact us</h1>
        <div id="contacts-us-block" class='d-flex justify-content-center'>
<form class="needs-validation" name="myform" id='action_form'>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationDefault01" class="new-class-form-contact-us">First name</label>
      <input name="FIRST_NAME" id="fn" type="text" class="form-control" id="validationDefault01" placeholder="First name" value="Сергей" required>

    </div>
    <div class="col-md-4 mb-3">
      <label for="validationDefault02" class="new-class-form-contact-us">Last name</label>
      <input name="LAST_NAME" id="ln" type="text" class="form-control" id="validationDefault02" placeholder="Last name" value="Иванов" required>
    </div>
    <div class="col-md-4 mb-3">
      <label for="inputEmail4" class="new-class-form-contact-us">Email</label>
      <input name="EMAIL" id="em" type="email" class="form-control" id="inputEmail4" placeholder="Email" required>
    </div>
  </div>

  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationDefault03" class="new-class-form-contact-us">City</label>
      <input name="CITY" id="ct" type="text" class="form-control" id="validationDefault03" placeholder="City" required>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault04" class="new-class-form-contact-us">State</label>
      <input name="STATE" id="st" type="text" class="form-control" id="validationDefault04" placeholder="State" required>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationDefault05" class="new-class-form-contact-us">Zip</label>
      <input name="ZIP" id="zi" type="text" class="form-control" id="validationDefault05" placeholder="Zip" required>
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
      <label class="form-check-label new-class-form-contact-us" for="invalidCheck2">
        Agree to terms and conditions
      </label>
    </div>
  </div>
  <button id="submit_button" hr class="btn btn-primary mobile-size-fix" type="submit" style="width: 130px;height: 40px;position: absolute;">
    Send message
  </button>
</form>
      </div>
      <div id="message_alert" class='alerts-class-contacts'>
        </div>
    </section>
    <section id="information">
      <div id="ThirdBlock1">
        <a id="thInst" href="https://www.instagram.com/instasm0ke/" target="_blank" rel="noopener">
        </a>
        <a id="thFacb" href="https://www.facebook.com/profile.php?id=100006578020092" target="_blank" rel="noopener">
        </a>
        <a id="thVk" href="https://vk.com/omegasmoke" target="_blank" rel="noopener">
        </a>
      </div>
        <div id="bottom-block-down">
          <div class="block-info-bottom">© 2019 Sergej Shastin  <div style="display: inline-block;font-size: 15px;padding: 5px;background: #DBDBDB;color: #171717;font-weight: bold;border-radius: 3px;"> SHASS.Team </div></div>
        </div>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <!-- local JavaScript -->
    <script src="js/main.js"></script>
    <!-- ========== CHAT ========================-->
    <script src="js/chat.js"></script>
  </body>
</html>
