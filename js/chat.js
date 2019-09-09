function getCookie(name) {
  var matches = document.cookie.match(new RegExp(
    "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
  ));
  return matches ? decodeURIComponent(matches[1]) : undefined;
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

var id_support=null;
function showChat(){
  $( ".support-chat" ).addClass("support-chat-after");
  //$( ".main-upper-block-logo" ).removeClass("main-upper-block-logo-after");


  if (getCookie("IDSUPPORT")!=undefined) id_support=getCookie("IDSUPPORT");
  else {
    id_support=Math.floor(Math.random() * (9999999 - 1000000) + 1000000);
    setCookie("IDSUPPORT", id_support, {
      expires: 86400
    });
  }

   GetMessages();
   intervalOfUpdateChat=setInterval(GetMessages, 2000);

}
var intervalOfUpdateChat=null;
function hideChat(){
$( ".support-chat" ).removeClass("support-chat-after");
 if (intervalOfUpdateChat!=null) clearInterval(intervalOfUpdateChat);
}

$("#input_chat_support").on('keypress',function(e) {
    if(e.which == 13) {
        SendMessage();
    }
});

var curindex_chat=-1;

var stop=false;
function GetMessages(){
  if (!stop){
  stop=true;
  //query to get messages
  //if (curindex_chat==null) curindex_chat=-1;
  try{
  (async () => {
const rawResponse = await fetch('https://api.shass.ru/support_chat.php?event=get&index='+curindex_chat+'&id='+id_support, {
  method: 'GET',
  headers: {
  }
});
const content = await rawResponse.json();
try{
    if (content['status'] && content['result']!=null){
          if (curindex_chat==-1)
            $(".msg_history").html("");
            if (content['index']!=null) curindex_chat=content['index'];


            content['result'].forEach(function(element) {
                AddMessagesToChat(element['TEXT'],element['GET_ANSWER']==0?true:false,formatAMPM(new Date(parseInt(element['TIME'])*1000)));
            });



    }
    stop=false;
}catch (e){
  stop=false;
}
})();
}catch(e){
stop=false;
}
}
}
function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'AM' : 'PM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;

var month = new Array();
month[0] = "Jan";
month[1] = "Febr";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "Aug";
month[8] = "Sep";
month[9] = "Oct";
month[10] = "Nove";
month[11] = "Dec";
var n = month[date.getMonth()];
  return strTime+ ' | ' + n +" "+ date.getDate();
}


function SendMessage(){
  var data = new FormData($(this)[0]);
  var send_message_buf=$("#input_chat_support").val();


    data.append('message',send_message_buf);

    $("#input_chat_support").val("");
    try{
  (async () => {
const rawResponse = await fetch('https://api.shass.ru/support_chat.php?event=send&id='+id_support, {
  method: 'POST',
  headers: {
  },
  body: data
});
const content = await rawResponse.json();
try
{
  //clearInterval(intervalOfUpdateChat);
  GetMessages();
  //intervalOfUpdateChat=setInterval(GetMessages, 2000);
  /*if (content['status']){
  var dateTime=new Date(content['time']*1000);
  AddMessagesToChat(send_message_buf,true,formatAMPM(dateTime));*/
//}
}catch (e){
}
})();
}catch(e){}
}

function AddMessagesToChat(message,type,time){
if (type){
  var element_new='<div class="outgoing_msg"><div class="sent_msg"><p>'+message+'</p><span class="time_date">'+time+'</span> </div></div>';
  $(".msg_history").html($(".msg_history").html()+element_new);
}else {
  var element_new='<div class="incoming_msg"><div class="incoming_msg_img"> <img src="/images/support_helper.png" alt="support"> </div><div class="received_msg"><div class="received_withd_msg"><p>'+message+'</p><span class="time_date">'+time+'</span></div></div></div>';
  $(".msg_history").html($(".msg_history").html()+element_new);
}
//$(".msg_history")[0].animate({ scrollTop: $('.msg_history')[0].scrollHeight }, "slow");
$('.msg_history').scrollTop($('.msg_history')[0].scrollHeight);
}
