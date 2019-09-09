$(".message-block-faq").click(function (e){
var parent = $(event.target).closest(".message-block-faq-main");
if (location.hash!="#"+$(parent).attr('id'))
location.hash="#"+$(parent).attr('id');
else{
openTabQuestion(parent);
}
});

function openTabQuestion(parent){
  var transform=$(parent).attr("showed")==undefined?false:true;
  if (!transform){
  $(".block-arrow-faq").css({transform:"rotate(0deg)"});
  $(".message-block-faq-info").removeClass("message-block-faq-info-open");
  $(".message-block-faq-main").removeAttr("showed");
  $(parent).find(".block-arrow-faq").css({transform:"rotate(90deg)"});
  $(parent).find(".message-block-faq-info").addClass("message-block-faq-info-open");
  $(parent).attr("showed","");
  }else {
  $(parent).find(".block-arrow-faq").css({transform:"rotate(0deg)"});
  $(parent).find(".message-block-faq-info").removeClass("message-block-faq-info-open");
  $(parent).removeAttr("showed");
  }
}
if($(location.hash).length)
  openTabQuestion($(location.hash));

function locationHashChanged() {
  if($(location.hash).length)
    openTabQuestion($(location.hash));
}

window.onhashchange = locationHashChanged;
