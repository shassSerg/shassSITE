




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
function LoginBox(){
  var statusauth=getCookie('SAUTH');
  if (statusauth=='false'){
  $('#logo_loader').css('display','block');
  (async () => {
  var data = new FormData();
  if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
  const rawResponse = await fetch('https://api.shass.ru/auth', {
  method: 'POST',
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
  //<a onclick=\"if ($('.title-block-login-info-closed').hasClass('title-block-login-info-open')) $('.title-block-login-info-closed').removeClass('title-block-login-info-open'); else $('.title-block-login-info-closed').addClass('title-block-login-info-open');
  setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
  $('#logo_loader').css('display','none');
  }catch (e){
    setCookie('SAUTH',true,{ expires: 604800, path: '/',domain: '.shass.ru' });
  $('#logo_loader').css('display','none');
  }
  })();
}else $('#box_logo_info').html("<button data-toggle=\"modal\" data-target=\"#loginModal\" type=\"button\" class=\"btn btn-outline-success title-block-login\" style='width: 75px'>Log in</button>");
}
LoginBox();

var indexOfPage=0;
var lastScroll=null;
var ignore_=0;
var ignore_1=false;


function AnimateBlock(indexofblock){
  $('#id-smartphone-download').removeClass('smartphone-download-after');

  //about
  $('.about-first-image').removeClass('about-first-image-after');
  $('.about-second-image').removeClass('about-second-image-after');
  $('#id-drone-row').removeClass('drone-row-after');

  //Drone
  $('.drone-image').removeClass('drone-image-after');
  $('.drone-image-under').removeClass('drone-image-under-after');

    $('.members-container').removeClass('members-container-after');
  switch(indexofblock){
    case 1:
    $('.about-first-image').addClass('about-first-image-after');
    $('.about-second-image').addClass('about-second-image-after');
    break;
    case 2:
    $('.drone-image').addClass('drone-image-after');
    $('.drone-image-under').addClass('drone-image-under-after');
    $('#id-drone-row').addClass('drone-row-after');
    break;
    case 3:
    $('.members-container').addClass('members-container-after');
    break;
    case $('section').length-3:
    $('#id-smartphone-download').addClass('smartphone-download-after');
    break;
}
}


window.onload = function() {
  if (lastScroll===null) {
  lastScroll=window.pageYOffset || document.documentElement.scrollTop;
  for(var i=0;i<$('section').length-1;i++){
    if ($('section')[i].offsetTop <=lastScroll || lastScroll+document.documentElement.clientHeight==document.documentElement.scrollHeight) indexOfPage=i;
  }
  AnimateBlock(indexOfPage);
}
Array.prototype.slice.call(document.getElementsByTagName("section")).forEach(function (el){el.addEventListener("wheel", onWheel)});
};


var isTitleL=false;
window.onscroll = function(e) {
  e.preventDefault();
  var scrolled = window.pageYOffset || document.documentElement.scrollTop;
  //title-block
  if (scrolled>0 && !isTitleL && screen.width>500){
    isTitleL=true;
    $( ".main-upper-block" ).addClass("main-upper-block-after");
    $( ".main-upper-block-logo" ).addClass("main-upper-block-logo-after");
    $( ".main-upper-block-logo-behind" ).addClass("main-upper-block-logo-behind-after");
  }
  else if(isTitleL && scrolled==0) {
    isTitleL=false;
    $( ".main-upper-block" ).removeClass("main-upper-block-after");
    $( ".main-upper-block-logo" ).removeClass("main-upper-block-logo-after");
    $( ".main-upper-block-logo-behind" ).removeClass("main-upper-block-logo-behind-after");
  }
/*
if(document.documentElement.clientWidth>500){

if (lastScroll===null || Math.abs(scrolled-lastScroll)>100) {
  ignore_1=true;
  lastScroll=scrolled;
  for(var i=0;i<$('section').length-1;i++){
    if ($('section')[i].offsetTop <=lastScroll || scrolled+document.documentElement.clientHeight==document.documentElement.scrollHeight) indexOfPage=i;
  }
}

if (ignore_==0){
if (!ignore_1){
if (scrolled-lastScroll>0) indexOfPage++;
else if (scrolled-lastScroll<0) indexOfPage--;
else if (scrolled==$('section')[indexOfPage].offsetTop || (indexOfPage==$('section').length-2  && scrolled+document.documentElement.clientHeight==document.documentElement.scrollHeight)){
  lastScroll=scrolled;return;
}
}else ignore_1=false;

if (indexOfPage>=$('section').length-1) {indexOfPage=$('section').length-1;
lastScroll=scrolled; return;}
if(indexOfPage<0) indexOfPage=$('section').length-2;
else if(indexOfPage>=$('section').length-1) indexOfPage=0;
var  t = $('section')[indexOfPage].getBoundingClientRect().top;
var Vhor= 0.5;
var Vver= 0.10;
var k__=700;
var w = window.pageYOffset;
var start = null;
ignore_=2;
requestAnimationFrame(step);
function step(time) {
    if (start === null) start = time;
    var progress = time - start;
    var procent__=(progress/k__);//% 0-1;
    if (procent__>1) procent__=1;

    procent__+=(1-(Math.abs((procent__-Vhor))/Vhor))*Vver;

    if (procent__<0) procent__=0;
    else if (procent__>1) procent__=1;

    var t_=Math.abs(t)*procent__;


    if (progress>=k__) r=w + t;
    else
    r = (t < 0 ? Math.max(w - t_, w + t) : Math.min(w + t_, w + t));


    window.scrollTo(0,r);
    if (r != w + t) {
        requestAnimationFrame(step);
    }else ignore_=1;
}
}else if (ignore_==1) ignore_=0;

}*/
lastScroll=scrolled;
for(var i=0;i<$('section').length-1;i++){
  if ($('section')[i].offsetTop <=scrolled || scrolled+document.documentElement.clientHeight==document.documentElement.scrollHeight) indexOfPage=i;
}
  AnimateBlock(indexOfPage);

}

//window.addEventListener("wheel", onWheel);
//$( "#main" ).mousewheel(function(){onWheel(null);});

function onWheel(e) {


var scrollPagesAccess=false;


//e.path.forEach(function (element) {
///if (element.nodeName=="SECTION")
scrollPagesAccess=true;
//});
if (scrollPagesAccess)  {
e.preventDefault();

  e = e || window.event;

  // wheelDelta не дает возможность узнать количество пикселей
  var delta = e.deltaY || e.detail || e.wheelDelta;

  scrolled=lastScroll+delta;
  if(document.documentElement.clientWidth>500){

  if (lastScroll===null) {
    lastScroll=scrolled;
    for(var i=0;i<$('section').length-1;i++){
      if ($('section')[i].offsetTop <=scrolled || scrolled+document.documentElement.clientHeight==document.documentElement.scrollHeight) indexOfPage=i;
    }
  }

  if (ignore_==0){
  if (scrolled-lastScroll>0) indexOfPage++;
  else if (scrolled-lastScroll<0) indexOfPage--;
  else if (scrolled==$('section')[indexOfPage].offsetTop || (indexOfPage==$('section').length-2  && scrolled+document.documentElement.clientHeight==document.documentElement.scrollHeight)){
    lastScroll=scrolled;return;
  }

  if(indexOfPage<0) indexOfPage=0;
  else if(indexOfPage>=$('section').length-1) {
    lastScroll=scrolled;
    indexOfPage=$('section').length-2;
    return;
  }
  var  t = $('section')[indexOfPage].getBoundingClientRect().top;
  var Vhor= 0.5;
  var Vver= 0.10;
  var k__=700;
  var w = window.pageYOffset;
  var start = null;
  ignore_=2;
  requestAnimationFrame(step);
  function step(time) {
      if (start === null) start = time;
      var progress = time - start;
      var procent__=(progress/k__);//% 0-1;
      if (procent__>1) procent__=1;

      procent__+=(1-(Math.abs((procent__-Vhor))/Vhor))*Vver;

      if (procent__<0) procent__=0;
      else if (procent__>1) procent__=1;

      var t_=Math.abs(t)*procent__;


      if (progress>=k__) r=w + t;
      else
      r = (t < 0 ? Math.max(w - t_, w + t) : Math.min(w + t_, w + t));


      window.scrollTo(0,r);
      if (r != w + t) {
          requestAnimationFrame(step);
      }else ignore_=0;
  }
  }else if (ignore_==1) ignore_=0;

  }
  lastScroll=scrolled;


  return false;
}
}
function GoToHash(hash){
  switch (hash) {
    case '#main':
        indexOfPage=0;
      break;
      case '#about':
      indexOfPage=1;
        break;
        case '#contacts':
        indexOfPage=$('section').length-2;
          break;
    default:
  }

  if(ignore_==0){
    var  t = $('section')[indexOfPage].getBoundingClientRect().top;
    var Vhor= 0.5;
    var Vver= 0.10;
    var k__=700;
    var w = window.pageYOffset;
    var start = null;
    ignore_=2;
    requestAnimationFrame(step);
    function step(time) {
        if (start === null) start = time;
        var progress = time - start;
        var procent__=(progress/k__);//% 0-1;
        if (procent__>1) procent__=1;

        procent__+=(1-(Math.abs((procent__-Vhor))/Vhor))*Vver;

        if (procent__<0) procent__=0;
        else if (procent__>1) procent__=1;

        var t_=Math.abs(t)*procent__;


        if (progress>=k__) r=w + t;
        else
        r = (t < 0 ? Math.max(w - t_, w + t) : Math.min(w + t_, w + t));


        window.scrollTo(0,r);
        if (r != w + t) {
            requestAnimationFrame(step);
        }else ignore_=0;
    }
    }else if (ignore_==1) ignore_=0;
}
$('a').click( function(e) {
e.preventDefault();
history.pushState(null, null, e.target.hash);
var hash=e.target.hash;
GoToHash(hash);
return false;
} );
$(window).bind( 'hashchange', function(e) {
  //e.preventDefault();

 });




$( "#logoutSuccess" ).click(function() {
  $('#logoutModal').modal('hide');
  setCookie('SAUTH',true,{ expires: 604800, path: '/',domain: '.shass.ru' });
  location.href='https://api.shass.ru/auth/logout.php?type=main';
});


/*class LogoBox extends React.Component {
  render() {
    return (
      //<div id="message_alert_internal" class="alert {this.props.status?("alert-success"):("alert-warning"))} alert-dismissible fade show  alerts-class-contacts-closed" role="alert"><strong id="contact-us-main-message">{this.props.status?("Успешно!"):("Ошибка!"))}</strong> {(this.props.status?("Ваше сообщение было успешно отправлено."):(this.props.error))}<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;<span></button></div>
<div> </div>
    );
  }
}*/

$('#action_form').submit(function(e) {
    $("#submit_button").html("<div id='logo_loader_submit' class='loader-submit'></div>");
    $("#submit_button").attr("disabled", true);
    e.preventDefault();
    var data = new FormData($(this)[0]);
    if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
    (async () => {
  const rawResponse = await fetch('https://api.shass.ru/submit', {
    method: 'POST',
    headers: {
    },
    body: data
  });
  const content = await rawResponse.json();
  try{
    if (!content['status'] && content['error']=="Unauth")
    $('#loginModal').modal('show');
    else{
      $('#message_alert').html("<div id=\"message_alert_internal\" class=\"alert "+(content['status']?("alert-success"):("alert-warning"))+" alert-dismissible fade show  alerts-class-contacts-closed\" role=\"alert\"><strong id=\"contact-us-main-message\">"+(content['status']?("Успешно!"):("Ошибка!"))+"</strong> "+(content['status']?("Ваше сообщение было успешно отправлено."):(content['error']))+"<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"> <span aria-hidden=\"true\">&times;</span></button></div>");
      $('#message_alert_internal').addClass('alerts-class-contacts-open');
    }
    $("#submit_button").html('Send message');
     $("#submit_button").removeAttr("disabled");
  }catch (e){
        $("#submit_button").html('Send message');
         $("#submit_button").removeAttr("disabled");
  }
})();
});

$('#form_to_login').submit(function(e) {
    $("#form_login_button").html("<div id='form_login_button' class='loader-login'></div>");
    $("#form_login_button").attr("disabled", true);
    e.preventDefault();
    var data = new FormData($(this)[0]);
    if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
    (async () => {
  const rawResponse = await fetch('https://api.shass.ru/auth/self.php', {
    method: 'POST',
//    credentials: 'include',
    headers: {
    },
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

          location.href='https://shass.ru/';
    }

    $("#form_login_button").html('Ввойти');
    $("#form_login_button").removeAttr("disabled");
  }catch (e){
      $("#form_login_button").html('Ввойти');
      $("#form_login_button").removeAttr("disabled");
  }
})();
});



$( "#vk_button_login" ).click(function (){
    setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
  window.open("https://api.shass.ru/auth?type=vk","_self");
});
$( "#yandex_button_login" ).click(function (){
    setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
  window.open("https://api.shass.ru/auth?type=yandex","_self");
});
$( "#twitch_button_login" ).click(function (){
    setCookie('SAUTH',false,{ expires: 604800, path: '/',domain: '.shass.ru' });
  window.open("https://api.shass.ru/auth?type=twitch","_self");
});
