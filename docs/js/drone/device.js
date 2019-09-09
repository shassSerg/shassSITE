$(".code-class-copy").click(function(){
  var $temp = $("<input>");
    $("body").append($temp);
    $temp.val($("#code_arduino").text()).select();
    document.execCommand("copy");
    $temp.remove();
});

$(".photo-drone").click(function (e){
  $('#body_image_modal').html($(e.target).closest(".photo-drone").find('img').clone());
  $('#modal_photo').modal('show');
});
