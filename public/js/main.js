$(document).ready(function() {
  $(".youtube-link").grtyoutube({
        autoPlay:true
     });

});
$("#loginForm").submit(function(e) {

    e.preventDefault(); // avoid to execute the actual submit of the form.

    var form = $(this);
    var actionUrl = form.attr('action');

    $.ajax({
        type: "POST",
        url: actionUrl,
        data: form.serialize(), // serializes the form's elements.
        success: function(data)
        {
            location="/";
        },
        error: function(data)
        {
            let error = "";
            for (const [key, value] of Object.entries(data.responseJSON.errors)) {
                errorr = value[0];
            }

            $('#errorTag').replaceWith($('<span style="color:red;" id="errorTag">'+errorr+'</span>'));
        },
    });

});

(function ( $ ) {

$.fn.grtyoutube = function( options ) {

  return this.each(function() {

     // Get video ID
     var getvideoid = $(this).attr("youtubeid");

     // Default options
     var settings = $.extend({
        videoID: getvideoid,
        autoPlay: true
     }, options );

     // Convert some values
     if(settings.autoPlay === true) { settings.autoPlay = 1 } else { settings.autoPlay = 0 }

     // Initialize on click
     if(getvideoid) {
        $(this).on( "click", function() {
            $("body").append('<div class="grtvideo-popup">'+
                    '<div class="grtvideo-popup-content">'+
                       '<span class="grtvideo-popup-close">&times;</span>'+
                       '<iframe class="grtyoutube-iframe" src="https://www.youtube.com/embed/'+settings.videoID+'?rel=0&wmode=transparent&autoplay='+settings.autoPlay+'&iv_load_policy=3" allowfullscreen frameborder="0"></iframe>'+
                    '</div>'+
                 '</div>');
        });
     }

     // Close the box on click or escape
     $(this).on('click', function (event) {
        event.preventDefault();
        $(".grtvideo-popup-close, .grtvideo-popup").click(function(){
           $(".grtvideo-popup").remove();
        });
     });

     $(document).keyup(function(event) {
        if (event.keyCode == 27){
           $(".grtvideo-popup").remove();
        }
     });
  });
};

}( jQuery ));
// Burger
$('.menu .button').click(function(event) {
  $(this).toggleClass('active');
  $('.burger').toggleClass('active');
  return false;
});
$('.rev__slider').slick({
  infinite: true,
  slidesToShow: 2,
  slidesToScroll: 1,
  arrows: true,
  dots: true,
  dotsClass: 'custom_paging',
    customPaging: function (slider, i) {
        var slideNumber   = (i + 1),
            totalSlides = slider.slideCount;
        return '<a class="custom-dot" role="button" title="' + slideNumber + ' of ' + totalSlides + '"><span class="current">'+ slideNumber  +'</span><span class="string">' + '</span><span class="line"> /</span>' + totalSlides + '</span></a>';   },
  prevArrow: '<button type="button" class="slick-prev"><img src="img/left.svg" class="svg"></button>',
  nextArrow: '<button type="button" class="slick-next"><img src="img/right.svg" class="svg"></button>',
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 2

      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: 1
      }
    },
    {
      breakpoint: 576,
      settings: {
        slidesToShow: 1,
        arrows: false,
        dotsClass: 'dot',
        customPaging: function (slider, i) {
            var slideNumber   = (i + 1),
                totalSlides = slider.slideCount;
            return '<a class="dot" ' + ' of '+ '"><span class="current">'  +'</span><span class="string">' + '</span><span class="line"> /</span>' + '</span></a>';   },
      }
    }
  ]
});
$('.articmodal-close').click(function (e) {
  $.arcticmodal('close');
});
$('.nav__reg').click(function (e) {
  e.preventDefault();
  $('#popup1').arcticmodal({
  });
});
$('.header__btn').click(function (e) {
  e.preventDefault();
  $('#popup1').arcticmodal({
  });
});
$('.bttlogin').click(function (e) {
    $.arcticmodal('close');

    e.preventDefault();
    $('#popup3').arcticmodal({
    });
});
$('.bttreg').click(function (e) {
    $.arcticmodal('close');

    e.preventDefault();
    $('#popup1').arcticmodal({
    });
});
$('.nav__btn').click(function (e) {
  e.preventDefault();
  $('#popup3').arcticmodal({
  });
});
$('.rev__btn').click(function (e) {
    e.preventDefault();
    $('#popup1').arcticmodal({
    });
});
   var accordeonButtons = document.getElementsByClassName("accordeon__button");

   //пишем событие при клике на кнопки - вызов функции toggle
   for(var i = 0; i < accordeonButtons.length; i++) {
       var accordeonButton = accordeonButtons[i];

       accordeonButton.addEventListener("click", toggleItems, false);
   }

   //пишем функцию
   function toggleItems() {

       // переменная кнопки(актульная) с классом
       var itemClass = this.className;

       // добавляем всем кнопкам класс close
       for(var i = 0; i < accordeonButtons.length; i++) {
           accordeonButtons[i].className = "accordeon__button closed";
       }

       // закрываем все открытые панели с текстом
       var pannels = document.getElementsByClassName("accordeon__panel");
       for (var z = 0; z < pannels.length; z++) {
           pannels[z].style.maxHeight = 0;
       }

       // проверка. если кнопка имеет класс close при нажатии
       // к актуальной(нажатой) кнопке добававляем активный класс
       // а панели - которая находится рядом задаем высоту
       if(itemClass == "accordeon__button closed") {
           this.className = "accordeon__button active";
           var panel = this.nextElementSibling;
           panel.style.maxHeight = panel.scrollHeight + "px";
       }

   }
    // Scrollto
$('.go_to').click( function(){ // ловим клик по ссылке с классом go_to
  var scroll_el = $(this).attr('href'); // возьмем содержимое атрибута href, должен быть селектором, т.е. например начинаться с # или .
  if ($(scroll_el).length != 0) { // проверим существование элемента чтобы избежать ошибки
      $('html, body').animate({ scrollTop: $(scroll_el).offset().top -0 }, 800); // анимируем скроолинг к элементу scroll_el
  }
  return false; // выключаем стандартное действие
});
$('.burger li a').click(function(event) {
  $('.menu .button').toggleClass('active');
  $('.burger').toggleClass('active');
  return false;
});
// svg
$(function(){
  jQuery('img.svg').each(function(){
      var $img = jQuery(this);
      var imgID = $img.attr('id');
      var imgClass = $img.attr('class');
      var imgURL = $img.attr('src');

      jQuery.get(imgURL, function(data) {
          // Get the SVG tag, ignore the rest
          var $svg = jQuery(data).find('svg');

          // Add replaced image's ID to the new SVG
          if(typeof imgID !== 'undefined') {
              $svg = $svg.attr('id', imgID);
          }
          // Add replaced image's classes to the new SVG
          if(typeof imgClass !== 'undefined') {
              $svg = $svg.attr('class', imgClass+' replaced-svg');
          }

          // Remove any invalid XML tags as per http://validator.w3.org
          $svg = $svg.removeAttr('xmlns:a');

          // Check if the viewport is set, else we gonna set it if we can.
          if(!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
              $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
          }

          // Replace image with new SVG
          $img.replaceWith($svg);

      }, 'xml');

  });
});
