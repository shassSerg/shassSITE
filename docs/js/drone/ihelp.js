var no_enable=
[
  {index:0,message:"Убедитесь в том, что нажата кнопка включения",text_yes:"Нажата",text_no:null,to_index_yes:4,to_index_no:0},
  {index:1,message:"Подключите исправное зарядное устройство к дрону и проверьте загорелся ли индикатор зарядки дрона",text_yes:"Загорелся",text_no:"Не загорелся",to_index_yes:5,to_index_no:2},
  {index:2,message:"Исправно ли зарядное устройство?",text_yes:"Да",text_no:"Нет",to_index_yes:3,to_index_no:1},
  {index:3,message:"Обратитесь в сервисный центр для устранения неисправности дрона",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:-1},
  {index:4,message:"Включился ли дрон?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:1},
  {index:5,message:"Проверьте подключение к дрону с помощью программного обеспечения управления дроном. Удалось подключиться?",text_yes:"Да",text_no:"Нет",to_index_yes:6,to_index_no:3},
  {index:6,message:"Выключите зарядное устройство через 10 минут, если оно было подключено. Проверьте включается ли дрон?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:3}
];
var no_connect=
[
  {index:0,message:"Откройте программное обеспечения для управление дроном на устройстве управления",text_yes:"Готово",text_no:null,to_index_yes:1,to_index_no:0},
  {index:1,message:"Перейдите в раздел 'Дрон' и нажмите на кнопку 'Сбросить привязку' или 'Привязать устройство'. Если привязка выполнена успешно, обновятся данные и не появится ошибка получения данных. Привязка выполнена успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:3,to_index_no:2},
  {index:2,message:"Обратитесь в сервисный центр для устранения неисправности дрона",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:-1},
  {index:3,message:"Обновите информацию о дроне. Для этого потяните главное окно раздела 'Дрон' вниз касанием экрана. Обновление завершено успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:4},
  {index:4,message:"Выполните перепрошивку устройства",text_yes:"Готово",text_no:null,to_index_yes:0,to_index_no:1},
];

var no_answer=
[
  {index:0,message:"Попробуйте снова отправить запрос дрону. Ответил ли дрон?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:1},
  {index:1,message:"Отправьте пакет данных, состоящий из 6 байт дрону.",text_yes:"Готово",text_no:null,to_index_yes:2,to_index_no:1},
  {index:2,message:"Отправьте запрос дрону на получение информации. Дрон ответил?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:3},
  {index:3,message:"Откройте программное обеспечения для управление дроном на устройстве управления",text_yes:"Готово",text_no:null,to_index_yes:4,to_index_no:0},
  {index:4,message:"Перейдите в раздел 'Дрон' и нажмите на кнопку 'Сбросить привязку' или 'Привязать устройство'. Если привязка выполнена успешно, обновятся данные и не появится ошибка получения данных. Привязка выполнена успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:6,to_index_no:5},
  {index:5,message:"Обратитесь в сервисный центр для устранения неисправности дрона",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:-1},
  {index:6,message:"Обновите информацию о дроне. Для этого потяните главное окно раздела 'Дрон' вниз касанием экрана. Обновление завершено успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:0,to_index_no:7},
  {index:7,message:"Выполните перепрошивку устройства",text_yes:"Готово",text_no:null,to_index_yes:0,to_index_no:1}
];

var no_command=
[
  {index:0,message:"Откройте программное обеспечения для управление дроном на устройстве управления",text_yes:"Готово",text_no:null,to_index_yes:1,to_index_no:0},
  {index:1,message:"Перейдите в раздел 'Дрон' и нажмите на кнопку 'Сбросить привязку' или 'Привязать устройство'. Если привязка выполнена успешно, обновятся данные и не появится ошибка получения данных. Привязка выполнена успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:3,to_index_no:2},
  {index:2,message:"Обратитесь в сервисный центр для устранения неисправности дрона",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:-1},
  {index:3,message:"Обновите информацию о дроне. Для этого потяните главное окно раздела 'Дрон' вниз касанием экрана. Обновление завершено успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:5,to_index_no:4},
  {index:4,message:"Выполните перепрошивку устройства",text_yes:"Готово",text_no:null,to_index_yes:0,to_index_no:1},
  {index:5,message:'Проанализируйте данные, полученные после обновления информации о дроне, на предмет соответствия данным полученными с раздела "Дрон->Датчики" в программном обеспечении управления дроном. Если значения датчиков выходят за диапозоны, указанные в информации о дроне, то вероятно это и послужило причиной того, что дрон не выполняет команды. Эти не соответствия необходимо исправить в соответствии <a href="/docs/drone/device">с условиями</a>. Или произведите временную <a href="/docs/drone/device#build">перепрошивку</a> дрона.</p>',text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:1},
];

var no_wrong=
[
  {index:0,message:"Попробуйте снова отправить запрос дрону. Ответил ли дрон корректно?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:1},
  {index:1,message:"Отправьте пакет данных, состоящий из 6 байт дрону.",text_yes:"Готово",text_no:null,to_index_yes:2,to_index_no:1},
  {index:2,message:"Отправьте запрос дрону на получение информации. Дрон ответил корректно?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:3},
  {index:3,message:"Откройте программное обеспечения для управление дроном на устройстве управления",text_yes:"Готово",text_no:null,to_index_yes:4,to_index_no:0},
  {index:4,message:"Перейдите в раздел 'Дрон' и нажмите на кнопку 'Сбросить привязку' или 'Привязать устройство'. Если привязка выполнена успешно, обновятся данные и не появится ошибка получения данных. Привязка выполнена успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:6,to_index_no:5},
  {index:5,message:"Обратитесь в сервисный центр для устранения неисправности дрона",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:-1},
  {index:6,message:"Обновите информацию о дроне. Для этого потяните главное окно раздела 'Дрон' вниз касанием экрана. Обновление завершено успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:0,to_index_no:7},
  {index:7,message:"Выполните перепрошивку устройства",text_yes:"Готово",text_no:null,to_index_yes:0,to_index_no:1},
  {index:8,message:"Попробуйте снова отправить запрос дрону. Ответил ли дрон корректно?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:9},
  {index:9,message:"Обратитесь в сервисный центр для устранения неисправности дрона",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:-1}
];


var startValue=$("#buttons_ihelp").html();

function loadStartScreen(){
  pre_index=[];
  cur_index=0;
  cur_type=0;
  setTimeout(function(){$("#message_ihelp").css({transform:"translate(-150%,0)"});},50);
  $(".ihelp-class-item").each(function(i,value){
      setTimeout(function(){
        $(value).css({transform:"translate(-150%,0)"});
      },(i+1)*50.0+50);
  });
  setTimeout(function(){
  $("#message_ihelp").html("<strong>Что у вас случилось?</strong>");
  $("#buttons_ihelp").html(startValue);

  setTimeout(function(){$("#message_ihelp").css({transform:"translate(0%,0)"});},50);
  $(".ihelp-class-item").each(function(i,value){
      setTimeout(function(){$(value).css({transform:"translate(0%,0)"});},(i+1)*50.0+50);
  });
},($(".ihelp-class-item").length)*(300.0/($(".ihelp-class-item").length))+300);

}

var pre_index=[];
var cur_index=0;
var cur_type=0;
function changeQuestion(yes_no){
  var questions;
  switch (cur_type) {
    case 0:
      questions=no_enable;
      break;
      case 1:
        questions=no_connect;
        break;
        case 2:
          questions=no_answer;
          break;
          case 3:
            questions=no_command;
            break;
            case 4:
              questions=no_wrong;
              break;
    default:
    return;
  }

  var question;
  if (yes_no!=null){
  if (cur_index<0 || cur_index>=questions.lenght) {
    loadStartScreen();return;
  }
    cur_index=yes_no?questions[cur_index].to_index_yes:questions[cur_index].to_index_no;
  }
  if (cur_index<0 || cur_index>=questions.lenght) {
    loadStartScreen();return;
  }
  question=questions[cur_index];
  setTimeout(function(){
    $("#message_ihelp").css({transform:"translate(-150%,0)"});
  },50);
  $(".ihelp-class-item").each(function(i,value){
      setTimeout(function(){
        $(value).css({transform:"translate(-150%,0)"});
      },(i+1)*50.0+50);
  });
  setTimeout(function(){
      $("#message_ihelp").html(question.message);
      $("#buttons_ihelp").html(
        (question.text_yes!=null?('<button type="button" id="id_yes" class="ihelp-class-item list-group-item list-group-item-action">'+question.text_yes+'</button>'):"")+
        (question.text_no!=null?('<button type="button" id="id_no" class="ihelp-class-item list-group-item list-group-item-action">'+question.text_no+'</button>'):"")+
        (pre_index.length>0 && pre_index[pre_index.length-1]!=cur_index?('<button type="button" id="id_back" class="ihelp-class-item list-group-item list-group-item-action">Назад</button>'):"")+
        '<button type="button" id="id_main" class="ihelp-class-item list-group-item list-group-item-action">На главную</button>'
      );

      $("#id_yes").click(function(){
        pre_index.push(cur_index);
        changeQuestion(true);
      });
      $("#id_no").click(function(){
         pre_index.push(cur_index);
         changeQuestion(false);
       });
      $("#id_back").click(function(){
         cur_index=pre_index[pre_index.length-1];
         pre_index.pop();
         changeQuestion(null);
       });
      $("#id_main").click(function(){
        loadStartScreen();
      });



      setTimeout(function(){$("#message_ihelp").css({transform:"translate(0%,0)"});},50);
      $(".ihelp-class-item").each(function(i,value){
          setTimeout(function(){$(value).css({transform:"translate(0%,0)"});},(i+1)*50.0+50);
      });
  },($(".ihelp-class-item").length)*(300.0/($(".ihelp-class-item").length))+300);
}
