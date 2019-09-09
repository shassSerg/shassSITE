var needtochange=false;
if ($(window).width()<=700){
  needtochange=true;
}

var startPos;
var handlingTouch = false;


var startToSwipe=false;
document.addEventListener('touchstart', function(e) {
  // Is this the first finger going down?
  //e.preventDefault();
  if (!rightS || (e.touches[0].clientX<=$(window).width()/4.0)){
  if (e.touches.length == e.changedTouches.length) {
    startPos = {
      x: e.touches[0].clientX,
      y: e.touches[0].clientY
    };
  }
  startToSwipe=true;
}
});

document.addEventListener('touchmove', function(e) {
  //e.preventDefault();
  // If this is the first movement event in a sequence:
  if (startToSwipe){
  if (startPos) {
    // Is the axis of movement horizontal?
    if (Math.abs(e.changedTouches[0].clientX - startPos.x) > Math.abs(e.changedTouches[0].clientY - startPos.y)) {
      handlingTouch = true;
      onSwipeStart(e);
    }
    startPos = undefined;
  } else if (handlingTouch) {
    onSwipeMove(e);
  }
}
});

document.addEventListener('touchend', function(e) {
  //e.preventDefault();
  if (handlingTouch && e.touches.length == 0) {
    onSwipeEnd(e);
    handlingTouch = false;
    startToSwipe=false;
  }
});

function slide(x) {
  if (needtochange){
  if (x>0) x=0;
  if (x<-100) x=-100;
   $(".left-block").css({transform: "translate("+x+"%,0px)"});
  $(".upper-block-image").css({transform: "translate(0,-50%) rotate("+53.0*(Math.abs(x)/100.0)+"deg)"});
 }
}


   var swipeOrigin, x,rightS=true;
   function onSwipeStart(e) {
     swipeOrigin = e.touches[0].clientX;
   }

   function onSwipeMove(e) {
     x = e.touches[0].clientX - swipeOrigin;
     if (rightS)
     slide(-100+x);
     else
     slide(x);
   }

   function onSwipeEnd(e) {
     var dif=35;
     if (!rightS) dif=-dif;
     if (x < dif) {
    rightS=true;
    if (needtochange) {
      slide(-100);
      swipeBlock(false);
    }
     }
     else {
    rightS=false;

    if (needtochange) {
      slide(0);
      swipeBlock(true);
    }
   }
   }


var cur_value=false;
function swipeBlock(right_left){
if (right_left){
  $(".upper-block-image").css({transform: "translate(0,-50%) rotate(0deg)"});
  $(".left-block").css({transform: "translate(0%,0)"});
}else {
  $(".upper-block-image").css({transform: "translate(0,-50%) rotate(53deg)"});
  $(".left-block").css({transform: "translate(-100%,0)"});
}
  cur_value=right_left;
}

$(window).resize(function() {
if ($(window).width()>700){
  needtochange=false;
  $(".upper-block-image").css({transform: "translate(0,-50%) rotate(0deg)"});
  $(".left-block").css({transform: "translate(0%,0)"});
}else {
  swipeBlock(cur_value);
  needtochange=true;
}
});

$(".upper-block-image").click(function() {
  if ($(window).width()<=700){
  swipeBlock(!cur_value);
}
});





switch(main_check){
case 0:
$("#id_drone").css('color', '#DBDBDB');
$("#id_drone_second").addClass('open-block');
$(("#id_drone_second"+second_check)).css('color', 'white');
break;
case 1:
$("#id_device").css('color', '#DBDBDB');
$("#id_device_second").addClass('open-block');
$(("#id_device_second"+second_check)).css('color', 'white');
break;
case 2:
$("#id_server").css('color', '#DBDBDB');
$("#id_server_second").addClass('open-block');
$(("#id_server_second"+second_check)).css('color', 'white');
break;
default:

break;
}
