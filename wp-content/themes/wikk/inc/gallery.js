$(document).ready(function() {
  $('.post-gallery').each(function (idx, item) {
    var carouselId = "carousel" + idx;
    $(this).parent().attr('id', carouselId);

    $(this).slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      appendArrows: $('#'+carouselId+' .post-gallery'),
      prevArrow: '<a href="#" class="prev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 143 331"><path d="M139.5 306L33.75 165.006 139.5 24c4.971-6.628 3.627-16.03-3-21-6.627-4.971-16.03-3.626-21 3L3 156.005a15 15 0 0 0 0 18L115.5 324a14.975 14.975 0 0 0 12.012 6c3.131 0 6.29-.977 8.988-3 6.628-4.971 7.971-14.373 3-21z"/></svg></a>',
      nextArrow: '<a href="#" class="next"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 143 331"><path d="M139.501 155.997L27.001 6c-4.972-6.628-14.372-7.97-21-3s-7.97 14.373-3 21l105.75 140.997L3.001 306c-4.97 6.627-3.627 16.03 3 21a14.93 14.93 0 0 0 8.988 3c4.561 0 9.065-2.071 12.012-6l112.5-150.004a15 15 0 0 0 0-18z"/></svg></a>',
      infinite: true,
      responsive: [
        {
          breakpoint: 751,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 481,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
  });
  
  function LoadBackgroundImages() {
    $('.post-gallery .slick-slide DIV').each(function() {
      var href = $("A", this).attr('href');
      $(this).css({ "background-image": "url("+href+")" });
    });

    $('[data-fancybox="gallery"]').fancybox({ infobar: false, buttons: ['close'], loop : true });
  }

  LoadBackgroundImages();

  $(window).resize(function(){ setTimeout(function() { LoadBackgroundImages(); },100); });
});