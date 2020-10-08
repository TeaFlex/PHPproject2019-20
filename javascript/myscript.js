$(document).ready(function(){
  var gheight = $('#lienbouton').height();
  $('#lienbouton').height($(window).width() <= 940 ? 0 : 'auto');
  $('a#hamburger').click(function(){
    var element = $('#lienbouton');
    if(element.height() == 0){
      element.animate({height: gheight}, 200);
    }
    else{
      element.animate({height: 0}, 200);
    }
  });

  $('.cadre').css({opacity: 0});
  $('.cadre').animate({opacity: 1}, 600);

  $('section#introsite h1').css({opacity: 0});
  $('section#introsite h1').animate({opacity: 1}, 200);

  $('.galerie').css({opacity: 0});
  $('.galerie').animate({opacity: 1}, 500);
});