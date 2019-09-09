



/*AUTH*/
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

var charts=[];

function timerUpdateValues(){
  (async () => {
    var data=new FormData();
  if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
  const rawResponse = await fetch('https://api.shass.ru/drone/control.php?event=get_drone', {
  method: 'POST',
  credentials: 'same-origin',
  body: data
  });
  const content = await rawResponse.json();
  try{
  if (content['status'])
  {

    $("#count_drones").html("Найдено дронов: "+(content['result']==null?0:content['result'].length));

    if (content['result']!=null){
    content['result'].forEach(function (item,i,arr){
      var elem=document.getElementById("drone_"+item['drone_id']);

      $(".drone-info").each(function (i_){
        try{
          var attr=$(this).attr('id').replace('drone_','');

        if (!(content['result'].find(function(value__, index__, arr1__){
            return value__['drone_id']==attr;
      }))) {
          $(this).remove();
          charts=charts.filter(function(value, index, arr1){
              return attr!=value['index'];
        });
        }
      }catch(e){
        }
    });

      if (elem===null) {
        $(".search-block").append("<div id='drone_"+item['drone_id']+"' class='drone-info'><h1 class='drone-id-info'><strong>#"+item['drone_id']+"</strong></h1><canvas id='canvas1_"+item['drone_id']+"' style='position: relative;width: 100%;height:300px;'></canvas><h1 id='rot_"+item['drone_id']+"' class='drone-id-info'>Поворот: "+item['rotate']+"</h1><h1 id='height_"+item['drone_id']+"' class='drone-id-info'>Высота: "+item['height']+"</h1><h1 id='left_"+item['drone_id']+"' class='drone-id-info'>Первое расстояние: "+item['left_d']+"</h1><h1 id='right_"+item['drone_id']+"' class='drone-id-info'>Второе расстояние: "+item['right_d']+"</h1><div>");

        var ctx = document.getElementById("canvas1_"+item['drone_id']).getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'line',

            // The data for our dataset
            data: {
          labels: [1,2,3,4,5,6,7],
                datasets: [
                  {
                    label: 'Напряжение',
                    backgroundColor: 'rgba(20, 209, 0,0.3)',
                    borderColor: 'rgba(0, 0, 0,0.0)',
                    data: [0, 0, 0, 0, 0, 0, Math.abs(parseFloat(item['voltage'])*(100.0/5.0))]
                },
                {
                  label: 'Ток',
                  backgroundColor: 'rgba(17, 68, 170,0.3)',
                  borderColor: 'rgba(0, 0, 0,0.0)',
                  data: [0, 0, 0, 0, 0, 0, parseFloat(item['current'])*(100.0/25.0)]
              },
              {
                label: 'Температура',
                backgroundColor: 'rgba(255, 111, 0,0.3)',
                borderColor: 'rgba(0, 0, 0,0.0)',
                data: [0, 0, 0, 0, 0, 0, parseFloat(item['temp'])*(100.0/50.0)]
            }
              ]
            },

            // Configuration options go here
            options : {
    scales: {
        yAxes: [{
            ticks: {
                max: 100,
                min: 0,
                stepSize: 10
            }
        }]
    }
}
        });
        charts.push({index:item['drone_id'],chart_:chart});
      }else {
        $("#rot_"+item['drone_id']).html("Поворот: "+item['rotate']);
        $("#height_"+item['drone_id']).html("Высота: "+item['height']);
        $("#left_"+item['drone_id']).html("Первое расстояние: "+item['left_d']);
        $("#right_"+item['drone_id']).html("Второе расстояние: "+item['right_d']);
        charts.forEach(function (item_,i,arr){
            if (item_['index']==item['drone_id']) {
              for (var i=0;i<item_['chart_'].data.datasets[0].data.length-1;i++) {
                item_['chart_'].data.datasets[0].data[i]=item_['chart_'].data.datasets[0].data[i+1];
              }
              item_['chart_'].data.datasets[0].data[6]=Math.abs(parseFloat(item['voltage']))*(100.0/5.0);

              for (var i=0;i<item_['chart_'].data.datasets[1].data.length-1;i++) {
                item_['chart_'].data.datasets[1].data[i]=item_['chart_'].data.datasets[1].data[i+1];
              }
              item_['chart_'].data.datasets[1].data[6]=parseFloat(item['current'])*(100.0/25.0);

              for (var i=0;i<item_['chart_'].data.datasets[2].data.length-1;i++) {
                item_['chart_'].data.datasets[2].data[i]=item_['chart_'].data.datasets[2].data[i+1];
              }
              item_['chart_'].data.datasets[2].data[6]=parseFloat(item['temp'])*(100.0/50.0);

              item_['chart_'].update();
            }
        });
      }
      });
  }else $(".drone-info").remove();
}
}catch (e){
}
  })();
}

function clickNext(){
  $(".main-block").html($(".main-block").html()+"<div class='search-block'></div>");
  $("#h1_text").css("opacity", "0");
  $("#box_logo_main").css("opacity", "0");
  $("#box_logo_info").css("opacity", "0");
  setTimeout(function(){
    $("#h1_text").css("display", "none");
    $("#box_logo_main").css("display", "none");
    $("#box_logo_info").css("display", "none");



    $(".search-block").html("<div class='loader'></div>");
    (async () => {
      var data=new FormData();
    if (getCookie('authID')!=null) data.append('Authorization',getCookie('authID'));
    const rawResponse = await fetch('https://api.shass.ru/drone/control.php?event=get_drone', {
    method: 'POST',
    credentials: 'same-origin',
    body: data
    });
    const content = await rawResponse.json();
    try{
    if (content['status'])
    {
      $(".search-block").html("<div id='count_drones' class='info-common-drones'> Найдено дронов: "+(content['result']==null?0:content['result'].length)+"</div>");

      if (content['result']!=null){
        content['result'].forEach(function (item,i,arr){
          $(".search-block").append("<div id='drone_"+item['drone_id']+"' class='drone-info'><h1 class='drone-id-info'><strong>#"+item['drone_id']+"</strong></h1><canvas id='canvas1_"+item['drone_id']+"' style='position: relative;width: 100%;height:300px;'></canvas><h1 id='rot_"+item['drone_id']+"' class='drone-id-info'>Поворот: "+item['rotate']+"</h1><h1 id='height_"+item['drone_id']+"' class='drone-id-info'>Высота: "+item['height']+"</h1><h1 id='left_"+item['drone_id']+"' class='drone-id-info'>Первое расстояние: "+item['left_d']+"</h1><h1 id='right_"+item['drone_id']+"' class='drone-id-info'>Второе расстояние: "+item['right_d']+"</h1><div>");


          var ctx = document.getElementById("canvas1_"+item['drone_id']).getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'line',

                // The data for our dataset
                data: {
              labels: [1,2,3,4,5,6,7],
                    datasets: [
                      {
                        label: 'Напряжение',
                        backgroundColor: 'rgba(20, 209, 0,0.3)',
                        borderColor: 'rgba(0, 0, 0,0.0)',
                        data: [0, 0, 0, 0, 0, 0, Math.abs(parseFloat(item['voltage'])*(100.0/5.0))]
                    },
                    {
                      label: 'Ток',
                      backgroundColor: 'rgba(17, 68, 170,0.3)',
                      borderColor: 'rgba(0, 0, 0,0.0)',
                      data: [0, 0, 0, 0, 0, 0, parseFloat(item['current'])*(100.0/25.0)]
                  },
                  {
                    label: 'Температура',
                    backgroundColor: 'rgba(255, 111, 0,0.3)',
                    borderColor: 'rgba(0, 0, 0,0.0)',
                    data: [0, 0, 0, 0, 0, 0, parseFloat(item['temp'])*(100.0/50.0)]
                }
                  ]
                },

                // Configuration options go here
                options : {
        scales: {
            yAxes: [{
                ticks: {
                    max: 100,
                    min: 0,
                    stepSize: 10
                }
            }]
        }
    }
            });
              charts.push({index:item['drone_id'],chart_:chart});


          });
              setInterval(timerUpdateValues,7500);
  }
  }
  }catch (e){
  }
    })();


  },300);
};


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
    $('#h1_text').html('Для продолжения авторизируйтесь');
    $('#box_logo_info').html("<button data-toggle=\"modal\" data-target=\"#loginModal\" type=\"button\" class=\"btn btn-outline-success title-block-login\" style='width: 75px'>Log in</button>");
  }else {
    $('#h1_text').html('С возращением, <strong>'+content['display_name']+'</strong>');
    $('#box_logo_info').html("<a onclick=\"if ($('.title-block-login-info-closed').hasClass('title-block-login-info-open')) $('.title-block-login-info-closed').removeClass('title-block-login-info-open'); else $('.title-block-login-info-closed').addClass('title-block-login-info-open');\" class='title-block-login main-block-login-ava' style='outline: none;background-image: url("+content['logo']+")'></a><div class='title-block-login-info-closed'><h1 class='title-block-login-info'>"+content['display_name']+"</h1><button onclick='clickNext();' type=\"button\" class=\"btn btn-outline-success title-block-login-next\">Дальше</button><button data-toggle=\"modal\" data-target=\"#logoutModal\" type=\"button\" class=\"btn btn-outline-danger title-block-login-logout\">Log out</button></div>");
  }
  dispName=content['disp_name'];
  typeAuth=content['type_auth'];


  setCookie('SAUTH',false,{ expires: 604800, path: '/' });
  $('#logo_loader').css('display','none');
  }catch (e){
  setCookie('SAUTH',true,{ expires: 604800, path: '/' });
  $('#logo_loader').css('display','none');
  }
  })();
}else {
  $('#h1_text').html('Для продолжения авторизируйтесь');
$('#box_logo_info').html("<button data-toggle=\"modal\" data-target=\"#loginModal\" type=\"button\" class=\"btn btn-outline-success title-block-login\" style='width: 75px'>Log in</button>");
}
}
LoginBoxR();


  $( "#logoutSuccess" ).click(function() {
    $('#logoutModal').modal('hide');
      setCookie('SAUTH',true,{ expires: 604800, path: '/',domain: '.shass.ru' });
      location.href='https://api.shass.ru/auth/logout.php?type=remote_drone';
  });


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
              document.location.reload(true);
        }

        $("#form_login_button").html('Ввойти');
        $("#form_login_button").removeAttr("disabled");
      }catch (e){
          $("#form_login_button").html('Ввойти');
          $("#form_login_button").removeAttr("disabled");
      }
    })();
    });
