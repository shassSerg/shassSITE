var no_enable=
[
  {index:0,message:"Отсутствует подключение к Интернет?",text_yes:"Да",text_no:"Нет",to_index_yes:1,to_index_no:2},
  {index:1,message:"Восстановите подключение",text_yes:"Готово",text_no:null,to_index_yes:0,to_index_no:2},
  {index:2,message:"Вы ввели правильный логин и пароль?",text_yes:"Да",text_no:"Нет",to_index_yes:4,to_index_no:1},
  {index:3,message:"Внимательно введите логин и пароль",text_yes:"Готово",text_no:null,to_index_yes:2,to_index_no:-1},
  {index:4,message:"Имя сервера указано не верно?",text_yes:"Да",text_no:"Нет",to_index_yes:5,to_index_no:6},
  {index:5,message:"Укажите верное имя сервера",text_yes:"Готово",text_no:null,to_index_yes:4,to_index_no:6},
  {index:6,message:"Перезагрузите систему. Помогло?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:7},
  {index:7,message:"Обратитесь к специалисту",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:2}
];
var no_connect=
[
  {index:0,message:"Подключен ли сервер к блоку питания или розетке?",text_yes:"Да",text_no:"Нет",to_index_yes:2,to_index_no:1},
  {index:1,message:"Восстановите подключение сервера к блоку питания или розетке",text_yes:"Готово",text_no:null,to_index_yes:0,to_index_no:2},
  {index:2,message:"Включен ли сервер?",text_yes:"Да",text_no:"Нет",to_index_yes:4,to_index_no:3},
  {index:3,message:"Включите сервер",text_yes:"Готово",text_no:null,to_index_yes:2,to_index_no:-1},
  {index:4,message:"Загрузилась ли операционная система?",text_yes:"Да",text_no:"Нет",to_index_yes:6,to_index_no:5},
  {index:5,message:"Обратитесь к специалисту",text_yes:"Готово",text_no:null,to_index_yes:4,to_index_no:6},
  {index:6,message:"Отсутствует подключение к Интернет?",text_yes:"Да",text_no:"Нет",to_index_yes:7,to_index_no:8},
  {index:7,message:"Восстановите подключение.",text_yes:"Готово",text_no:null,to_index_yes:6,to_index_no:2},
  {index:8,message:"Помогло?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:9},
  {index:9,message:"Обратитесь к специалисту",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:2}
];

var no_answer=
[
  {index:0,message:"Проверьте системы охлаждения",text_yes:"Готово",text_no:null,to_index_yes:1,to_index_no:2},
  {index:1,message:"Работают ли системы?",text_yes:"Да",text_no:"Нет",to_index_yes:4,to_index_no:2},
  {index:2,message:"Запустите систему охлаждения. Запустились?",text_yes:"Да",text_no:"Нет",to_index_yes:1,to_index_no:3},
  {index:3,message:"Обратитесь к специалисту",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:2},
  {index:4,message:"Проверить систему на вирусы. Есть ли вирусы?",text_yes:"Да",text_no:"Нет",to_index_yes:5,to_index_no:7},
  {index:5,message:"Почистите систему от вирусов.",text_yes:"Готово",text_no:null,to_index_yes:6,to_index_no:5},
  {index:6,message:"Помогло?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:3},
  {index:7,message:"Есть ли загрязнения в кулере",text_yes:"Да",text_no:"Нет",to_index_yes:8,to_index_no:3},
  {index:8,message:"Почистите загрязнения в кулере",text_yes:"Готово",text_no:null,to_index_yes:6,to_index_no:2}
];

var no_command=
[
  {index:0,message:"Цело ли оборудование на внешний вид?",text_yes:"Да",text_no:"Нет",to_index_yes:1,to_index_no:2},
  {index:1,message:"Запустился ли запасной сервер?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:3},
  {index:2,message:"Возможно ли самостоятельно исправить деффекты?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:3},
  {index:3,message:"Обратитесь к специалисту",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:2}
];

var no_wrong=
[
  {index:0,message:"Попробуйте обновить драйвера. Все равно возникает ошибка?",text_yes:"Да",text_no:"Нет",to_index_yes:1,to_index_no:-1},
  {index:1,message:"Откатите драйвера и систему до предыдущей версии",text_yes:"Готово",text_no:null,to_index_yes:2,to_index_no:1},
  {index:2,message:"Помогло?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:3},
  {index:3,message:"Проверьте систему на вирусы",text_yes:"Готово",text_no:null,to_index_yes:4,to_index_no:0},
  {index:4,message:"Есть ли вирусы?",text_yes:"Да",text_no:"Нет",to_index_yes:5,to_index_no:6},
  {index:5,message:"Запустите антивирусную программу и очитстите систему от вирусов. Помогло",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:7},
  {index:6,message:"Запустите стресс-тест в приложении AIDA64 или ее аналогах. Тест прошел успешно?",text_yes:"Да",text_no:"Нет",to_index_yes:-1,to_index_no:7},
  {index:7,message:"Обратитесь в тех. поддержку",text_yes:"Готово",text_no:null,to_index_yes:-1,to_index_no:1},
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
