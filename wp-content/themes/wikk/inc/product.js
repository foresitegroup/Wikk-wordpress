$(document).ready(function() {
  $('.scroller').each(function (idx, item) {
    var carouselId = "carousel" + idx;
    $(this).parent().attr('id', carouselId);

    $(this).slick({
      slidesToShow: 3,
      slidesToScroll: 3,
      appendArrows: $('#'+carouselId+' .scroller'),
      prevArrow: '<a href="#" class="prev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 143 331"><path d="M139.5 306L33.75 165.006 139.5 24c4.971-6.628 3.627-16.03-3-21-6.627-4.971-16.03-3.626-21 3L3 156.005a15 15 0 0 0 0 18L115.5 324a14.975 14.975 0 0 0 12.012 6c3.131 0 6.29-.977 8.988-3 6.628-4.971 7.971-14.373 3-21z"/></svg></a>',
      nextArrow: '<a href="#" class="next"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 143 331"><path d="M139.501 155.997L27.001 6c-4.972-6.628-14.372-7.97-21-3s-7.97 14.373-3 21l105.75 140.997L3.001 306c-4.97 6.627-3.627 16.03 3 21a14.93 14.93 0 0 0 8.988 3c4.561 0 9.065-2.071 12.012-6l112.5-150.004a15 15 0 0 0 0-18z"/></svg></a>',
      infinite: false,
      responsive: [
        {
          breakpoint: 751,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 481,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });

    function SlideCounter() {
      var firsttile = $('#' + carouselId + ' .slick-slide.slick-active').data("slick-index")+1;
      var lasttile = $('#' + carouselId + ' .slick-slide.slick-active').data("slick-index")+$('#' + carouselId + ' .slick-slide.slick-active').length;
      $('#' + carouselId + ' .sidetitle H1').text('Showing '+firsttile+'-'+lasttile+'/'+$('#' + carouselId + ' .slick-slide').not($('.slick-cloned')).length);
    }

    $('#' + carouselId + ' .slick-prev, #' + carouselId + ' .slick-next').click(function() { SlideCounter(); });

    SlideCounter();
  });

  function TitleLineProduct() {
    $('.sidetitle').each(function() {
      $('#image .sidetitle').css({ "width": $('#images').height() });
    });

    $('[id^="carousel"').each(function() {
      $(this).find('.sidetitle').css({ "width": $(this).find('.scroller').height()-50 });
    });
  }

  TitleLineProduct();

  $(window).resize(function(){ setTimeout(function() { TitleLineProduct(); },100); });

  function SetActive(target) {
    $('#caption').html($(target).html());

    $('#bigimage').height($('#tabs').height()-$('#imagethumbs').height()-$('#caption').outerHeight());

    // Get the active thumbnail background and set it as the main image
    var bg = $(target).css("background-image");
    bg = bg.replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
    $('#bigimage').html("<img src=\""+bg+"\" alt=\"\">");

    $('#imagethumbs > DIV').removeClass('active');
    $(target).addClass('active');

    var ImgIndex = $(target).index()+1;

    // Create Fancybox image pop-up
    var il, ImgLinks = "";
    for (var i = 1; i <= $('#imagethumbs > DIV').length; ++i) {
      il = $('#imagethumbs > DIV:nth-of-type('+i+')').css("background-image").replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');

      // Need to have all the links with "data-fancybox" listed for the carousel to work
      ImgLinks += '<a href="'+il+'" data-fancybox="product"';

      // Copy thumbnail caption to Fancybox caption
      if ($('#imagethumbs > DIV:nth-of-type('+i+')').html() != '') {
        var str = $('#imagethumbs > DIV:nth-of-type('+i+')').html().replace(/(['])/g, "\\$1");
        ImgLinks += " data-caption='"+str+"'";
      }

      if (ImgIndex == i) ImgLinks += ' class="activeimg"';

      ImgLinks += '><i class="fas fa-search-plus fa-rotate-180"></i></a>';
    }

    if ($('#imagethumbs > DIV').length == 1) $(target).addClass('singleimg');

    $('#image .sidetitle H1').html("Image "+ImgIndex+"/"+$('#imagethumbs > DIV').length+ImgLinks);

    // Set Fancybox options
    $('[data-fancybox="product"]').fancybox({ infobar: false, buttons: ['close'], loop : true });
  }

  SetActive('#imagethumbs > DIV:first-of-type');
  $(window).resize(function(){ setTimeout(function() { SetActive('#imagethumbs > DIV:first-of-type'); },100); });

  $('#imagethumbs > DIV').click(function() { SetActive(this); });
});