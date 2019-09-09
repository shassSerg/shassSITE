$(".photo-drone").click(function (e){
  $('#body_image_modal').html($(e.target).closest(".photo-drone").find('img').clone());
  $('#modal_photo').modal('show');
});
