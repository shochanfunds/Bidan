$(function(){
    var targetId = $("#nav-list");
    $(".humbarger-button").on("click",function(){
      targetId.toggleClass('open');
      if(targetId.hasClass('open')){
        targetId.animate({'left' : 0 }, 500);
      }else{
        targetId.animate({'left' :-200} ,500);
      }
    });
});

$(function(){
  $(".button").mouseover(function(){
    $(this).css({
      opacity: "0.4",
      filter: "alpha(opacity=40)"
    });
    $(this).fadeTo("slow", 1.0);
  });
});

$(function(){
  $("#search-icon").on("click",function(){
    $("#search-form").toggle();
  });
});


//toTop
$(window).scroll(function(){
  var distanceFromTop = $(window).scrollTop();
  if(distanceFromTop > 1500){
    $("#toTopButton").fadeIn('slow');
  }else{
    $("#toTopButton").fadeOut('slow');
  }
});

$(function(){
  $("#toTopButton").on("click",function(){
      $('html,body').animate({
        scrollTop:0
      }
      ,'slow'
    );
  });
});
