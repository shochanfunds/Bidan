$(function(){
  var searchButton = $("#slide_menu");
  $("#button").click(function(){
  searchButton.toggleClass("open");

  if(searchButton.hasClass('open')){
    $(".search-box-wrapper").css('margin-left','0px');
    $(".search-box > input").css('width','80%');
    $("#slide_menu").css('display', 'block');
  }else{
    $("#slide_menu").css('display', 'none');
    $(".search-box > input").css('width','65%');
    $(".search-box-wrapper").css('margin-left','23%');
  }
  });
});
