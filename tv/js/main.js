



function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : null;
}
function setCookie(name, value, options) {
  options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires * 1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) {
    options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for (var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];
    if (propValue !== true) {
      updatedCookie += "=" + propValue;
    }
  }

  document.cookie = updatedCookie;
}

function extractHostname(url) {
    var array=['','',''];
    //find & remove protocol (http, ftp, etc.) and get hostname
    if (url.indexOf("//") > -1) {
        array[0] =  url.split(':')[0];
        array[1] = url.split('/')[2];
    }
    else {
        array[1]  = url.split('/')[0];
    }
    //find & remove port number
    array[1]  = array[1] .split(':')[0];
    //find & remove "?"
    array[1]  = array[1] .split('?')[0];
    if (url.indexOf("//") > -1) {
    array[2]= url.replace(array[0]+"://"+array[1],'');
  }else{
        array[2]= url.replace(array[1],'');
  }
    return array;
}


function getfilesurls(url,array){
  (async () => {
    try{
  const rawResponse = await fetch(url);
  if (rawResponse){
      return rawResponse.toString();
  }else{
      return rawResponse.toString();
  }
}catch(e) {
  return null;
}
})();
}
var finalurl;
var online_=false;

function TryToStartStreamAgain(){
  if (finalurl!=''){
  fetch(finalurl,{ method: 'HEAD'}).then(function(response) {
    if (response.status==200 && !online_){
      videojs('video-stream').src(finalurl);
    }
    else  if (response.status!=200){
      //if (online_)
      videojs('video-stream').src(finalurl);
      finalurl='';
    }
});
}else {
  (async () => {
  const rawResponse = await fetch('https://api.shass.ru/live/get_url.php?login='+login, {
  method: 'GET'
  });
  const content = await rawResponse.json();
  try{
  if (content['status'])
  {
    if (content['url_stream']=='' || content['url_stream']==null || !content['url_stream'])
    finalurl='';
    else{
      finalurl= PrepareUrl(content['url_stream']);
  }
}
}
catch(e){}
})();
}
}

function Stats(){
  try{
  (async () => {
  const rawResponse = await fetch('https://api.shass.ru/live/watch.php?login='+login, {
  method: 'GET'
  });
  })();

(async () => {
const rawResponse = await fetch('https://api.shass.ru/stats?get=online&login='+login, {
method: 'GET'
});
const content = await rawResponse.json();
try{
  if (content['status'])
  {
    if (content['online']>0){
    $('#counter-live').html(content['online']+' online');
        $('#class_info_under_video_online').html('Сейчас смотрят: '+content['online']);
  }
    else{
    $('#class_info_under_video_online').html('Сейчас смотрят: 1');
    $('#counter-live').html('1 online');
  }
  }
}
catch(e){}
})();

}catch(e){}
}

function PrepareUrl(url){
  var retURL=null;
  var url_new=extractHostname(url);
  retURL='https://'+url_new[1]+':4430'+url_new[2];
  retURL+='/index.m3u8';
  return retURL;
}

function LoginBox(){
  if (login!=''){
  $('body').append("<div class='loader'></div>");
  (async () => {
  const rawResponse = await fetch('https://api.shass.ru/live/get_url.php?login='+login, {
  method: 'GET'
  });
  const content = await rawResponse.json();
  try{
  if (content['status'])
  {
    if (content['url_stream']=='' || content['url_stream']==null || !content['url_stream'])
    finalurl='';
    else{
      finalurl= PrepareUrl(content['url_stream']);
  }
$('.loader').addClass('loader-none');
    $('body').append($('body').html()+"<div id='ip' class='up'><div id='logo' class='logo-up'></div> <div id='box_logo_main' class='logo-box-upper-block-right'><div id='logo_loader' class=\"loader\" style='display: none'></div></div><div id='box_logo_info' class='logo-box-upper-block-right'></div></div><section id='video_stream' class='stream-block-new'><div class='stream-block-new-inner'><div class='info-streamer'><div style='background-image: url("+content['logo_img']+")' class='logo-img'></div><h1 class='login-info-stream'>"+login+"</h1><h1 class='name-info-stream'>"+content['name_stream']+"</h1><h1 id='info-online' class='right-info-stream'>"+'Offline'+"</h1></div><div class='div-counter'><h1 id='counter-live' class='counter'></h1></div><video id=\"video-stream\" class=\"video-js vjs-default-skin stream-video\" controls preload=\"auto\" muted autoplay poster=\""+content['back_img']+"\" data-setup='{\"autoplay\":true,\"preload\":\"auto\"}' type=\"application/x-mpegURL\"></video></div></section><section class='class-info-under-video'><div class='class-info-under-video-inner'><div class='class-info-under-video-logo' id='class_info_under_video_logo' style='background-image: url("+content['logo_img']+")'></div><h1 class='class-info-under-video-login' id='class_info_under_video_login'>"+login+"</h1><h1 class='class-info-under-video-name' id='class_info_under_video_name'>"+content['name_stream']+"</h1><h1 class='class-info-under-video-online' id='class_info_under_video_online'></h1></div></section><section id='chat' class='chat-block-new'><div class='chat-block-new-inner'><div class='chat-messages-block' id='chat-app'></div><div class='button-open-stickers-block' id='button_open_stickers_block'></div><div class='button-open-stickers' id='button_open_stickers'></div><div id='help_users' class='help-users-block'></div><button id='button_scroll_auto' class='scroll-auto-block'>Новые сообщения</button><div class='send-message-block'><div class=\"input-group mb-3\"><input id='input_chat_text' type=\"text\" class=\"form-control\" placeholder=\"Введите сообщение...\" aria-label=\"Введите сообщение...\" aria-describedby=\"basic-addon2\"><div class=\"input-group-append\"><button class=\"btn btn-outline-secondary\" type=\"button\" id='send_message_chat'>Отправить</button></div></div></div></div></section>");


LogChange();
try{
  var res=arraystickers.map(function(a){ return '<img class="button-open-stickers-sticker" onclick="insertAtCursor($(\'#input_chat_text\')[0],\' '+a.substring(0, a.length - 4)+' \');" src="/images/stickers/'+a+'" alt="'+a.substring(0, a.length - 4)+'"></img>'});
  $("#button_open_stickers_block").html(res);
  $("#button_open_stickers").click(function() { if($("#button_open_stickers_block").is(":visible")) $('#button_open_stickers_block').hide();else $('#button_open_stickers_block').show();});
  $('#button_open_stickers').focusout(function(){$('#button_open_stickers_block').hide();});
    LoginBoxR();
}catch(eT){}


    videojs('video-stream').src(finalurl);
    videojs('video-stream').on('error', function() {
      online_=false;
      $('.vjs-loading-spinner').addClass('vjs-loading-spinner-after');
        $('#info-online').html('Offline');
    });

    videojs('video-stream').on('loadedmetadata', function() {
        $('#info-online').html('🔴Online');
        $('.vjs-loading-spinner').removeClass('vjs-loading-spinner-after');
        online_=true;
    });

    videojs('video-stream').on('userinactive', function() {
        $('.info-streamer').addClass('info-streamer-after');
        $('.div-counter').addClass('div-counter-after');
    });
    videojs('video-stream').on('useractive', function() {
        $('.info-streamer').removeClass('info-streamer-after');
        $('.div-counter').removeClass('div-counter-after');
    });

    setInterval(TryToStartStreamAgain,15000);
    setInterval(Stats,50000);
    Stats();


    //videojs('video-stream').load();
/*  var myPlayer = this;

  // EXAMPLE: Start playing the video.
  myPlayer.play();

});*/

    /*var FILE = finalurl;
    var video = document.querySelector('video');

    window.MediaSource = window.MediaSource || window.WebKitMediaSource;
    if (!!!window.MediaSource) {
      alert('MediaSource API is not available');
    }
    var mediaSource = new MediaSource();
    //video.src = window.URL.createObjectURL(mediaSource);

    var arrayURLs=[];


    var result=getfilesurls(finalurl+'/index.m3u8',arrayURLs);
    //var getListURLs=setInterval(updateBuffer,5000,);

    //sourceBuffer = mediaSource.addSourceBuffer();
    //sourceBuffer.appendBuffer(new Uint8Array(e.target.result));

    //mediaSource.addEventListener('sourceopen', callback, false);
    //mediaSource.addEventListener('webkitsourceopen', callback, false);

    //mediaSource.addEventListener('webkitsourceended', function(e) {
    //  console.log('mediaSource readyState: ' + this.readyState);
    //}, false);*/


    ReactDOM.render(React.createElement(Messages,null), document.getElementById('chat-app'));
  }else {
    $('body').html("<div class='main-undefinded-block'><div class='undefinded-img'></div><h1 class='undefinded-block'>Что-то явно пошло не так:(</h1></div>");
  }
  }catch (e){
    $('body').html("<div class='main-undefinded-block'><div class='undefinded-img'></div><h1 class='undefinded-block'>Что-то явно пошло не так:(</h1></div>");
  }
  })();
}else LoadStreamers();
}
LoginBox();


var dispName='';
var typeAuth='';

function LoginBoxR(){
  var statusauth=getCookie('SAUTH');
  if (statusauth=='false'){
  $('#logo_loader').css('display','block');
  (async () => {
    var data=new FormData();
  if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
  const rawResponse = await fetch('https://api.shass.ru/auth', {
  method: 'POST',
  credentials: 'same-origin',
  body: data
  });
  const content = await rawResponse.json();
  try{
  if (!content['status'])
  {
    $('#box_logo_info').html("<button data-toggle=\"modal\" data-target=\"#loginModal\" type=\"button\" class=\"btn btn-outline-success title-block-login\" style='width: 75px'>Log in</button>");
  }else {
    $('#box_logo_info').html("<a onclick=\"if ($('.title-block-login-info-closed').hasClass('title-block-login-info-open')) $('.title-block-login-info-closed').removeClass('title-block-login-info-open'); else $('.title-block-login-info-closed').addClass('title-block-login-info-open');\" class='title-block-login main-block-login-ava' style='outline: none;background-image: url("+content['logo']+")'></a><div class='title-block-login-info-closed'><h1 class='title-block-login-info'>"+content['display_name']+"</h1><button data-toggle=\"modal\" data-target=\"#logoutModal\" type=\"button\" class=\"btn btn-outline-danger title-block-login-logout\">Log out</button></div>");
  }
  dispName=content['disp_name'];
  typeAuth=content['type_auth'];
  //<a onclick=\"if ($('.title-block-login-info-closed').hasClass('title-block-login-info-open')) $('.title-block-login-info-closed').removeClass('title-block-login-info-open'); else $('.title-block-login-info-closed').addClass('title-block-login-info-open');
  setCookie('SAUTH',false,{ expires: 604800, path: '/' });
  $('#logo_loader').css('display','none');
  }catch (e){
  setCookie('SAUTH',true,{ expires: 604800, path: '/' });
  $('#logo_loader').css('display','none');
  }
  })();
}else $('#box_logo_info').html("<button data-toggle=\"modal\" data-target=\"#loginModal\" type=\"button\" class=\"btn btn-outline-success title-block-login\" style='width: 75px'>Log in</button>");
}


$( "#vk_button_login" ).click(function (){
    setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
  window.open("https://api.shass.ru/auth?type=vk&redirect=tv","_self");
});
$( "#yandex_button_login" ).click(function (){
    setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
  window.open("https://api.shass.ru/auth?type=yandex&redirect=tv","_self");
});
$( "#twitch_button_login" ).click(function (){
    setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
  window.open("/https://api.shass.ru/auth?type=twitch&redirect=tv","_self");
});
  $( "#logoutSuccess" ).click(function() {
    $('#logoutModal').modal('hide');
      setCookie('SAUTH',true,{ expires: 604800, path: '/',domain: '.shass.ru' });
      location.href='https://api.shass.ru/auth/logout.php?type=tv';
  });

  function LogChange(){
    $('#form_to_login').submit(function(e) {
        $("#form_login_button").html("<div id='form_login_button' class='loader-submit'></div>");
        $("#form_login_button").attr("disabled", true);
        e.preventDefault();
        var data = new FormData($(this)[0]);
        if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
        (async () => {
      const rawResponse = await fetch('https://api.shass.ru/auth/self.php', {
        method: 'POST',
        //credentials: 'include',
        body: data
      });
      const content = await rawResponse.json();
      try{
        if (!content['status']){
          $('#login_message_alert')
          $('#login_message_alert').html("<div id=\"login_message_alert_internal\" class=\"alert "+(content['status']?("alert-success"):("alert-warning"))+" alert-dismissible fade show  login-alerts-class-contacts-closed\" role=\"alert\"><strong id=\"contact-us-main-message\">"+(content['status']?("Успешно!"):("Ошибка!"))+"</strong> "+(content['status']?("Ваше сообщение было успешно отправлено."):(content['error']))+"<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span></button></div>");
          $('#login_message_alert_internal').addClass('login-alerts-class-contacts-open');
        }else{
              setCookie('authID',content['authID'],{ expires: 604800, path: '/',domain: '.shass.ru' });
              setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
              location.href='https://tv.shass.ru/';
        }

        $("#form_login_button").html('Ввойти');
        $("#form_login_button").removeAttr("disabled");
      }catch (e){
          $("#form_login_button").html('Ввойти');
          $("#form_login_button").removeAttr("disabled");
      }
    })();
    });
  }
