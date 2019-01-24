<?php get_header(); ?>

<div class="site-width gallery-single">
  <?php
  while(have_posts()) : the_post();
    ?>
    <div class="gallery-single-header">
      Gallery
      <?php the_title('<h1 class="news-title">', '</h1>'); ?>
      <a href="<?php echo home_url(); ?>/gallery/">&laquo; Back to Gallery Index</a>
    </div>

    <?php
    the_content();

    $gallimages = new Attachments('gallery_gallery');
    $gallimagesnav = new Attachments('gallery_gallery');
    if($gallimages->exist()) :
      ?>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.css">
      <script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.min.js"></script>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/slick.css">
      <script src="<?php echo get_template_directory_uri(); ?>/inc/slick.min.js"></script>

      <script type="text/javascript">
        $(document).ready(function() {
          $('.gallery-images-main').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.gallery-images-nav'
          });

          $('.gallery-images-nav').slick({
            slidesToShow: 6,
            slidesToScroll: 1,
            asNavFor: '.gallery-images-main',
            focusOnSelect: true,
            appendArrows: $('.gallery-images-nav'),
            prevArrow: '<a href="#" class="prev"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 143 331"><path d="M139.5 306L33.75 165.006 139.5 24c4.971-6.628 3.627-16.03-3-21-6.627-4.971-16.03-3.626-21 3L3 156.005a15 15 0 0 0 0 18L115.5 324a14.975 14.975 0 0 0 12.012 6c3.131 0 6.29-.977 8.988-3 6.628-4.971 7.971-14.373 3-21z"/></svg></a>',
            nextArrow: '<a href="#" class="next"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 143 331"><path d="M139.501 155.997L27.001 6c-4.972-6.628-14.372-7.97-21-3s-7.97 14.373-3 21l105.75 140.997L3.001 306c-4.97 6.627-3.627 16.03 3 21a14.93 14.93 0 0 0 8.988 3c4.561 0 9.065-2.071 12.012-6l112.5-150.004a15 15 0 0 0 0-18z"/></svg></a>',
            infinite: true,
            responsive: [
              { breakpoint: 901, settings: { slidesToShow: 5 } },
              { breakpoint: 801, settings: { slidesToShow: 4 } },
              { breakpoint: 601, settings: { slidesToShow: 3 } },
              { breakpoint: 481, settings: { slidesToShow: 2 } }
            ]
          });

          function LoadBackgroundImages() {
            $('.gallery-images-nav .gallery-image-nav').each(function() {
              var imgurl = $(this).data('image');
              $(this).css({ "background-image": "url("+imgurl+")" });
            });
          }

          LoadBackgroundImages();

          $(window).resize(function(){ setTimeout(function() { LoadBackgroundImages(); },100); });
        });
      </script>

      <?php
      echo '<div id="mainimage">';
        echo '<div class="sideheader bottom"><h1></h1></div>';

        echo '<div class="gallery-images-main">' . "\n";
          while($gallimages->get()) :
            echo '
            <div class="gallery-image-main" style="background-image: url('.$gallimages->src('full').');">
              <div class="gallery-image-main-caption">'.$gallimages->field('caption')."</div>
            </div>\n";
          endwhile;
        echo "</div>\n";
      echo "</div>\n";

      echo '<div class="gallery-images-nav">' . "\n";
        while($gallimagesnav->get()) :
          echo '<div class="gallery-image-nav" data-image="'.$gallimagesnav->src('full').'"></div>';
        endwhile;
      echo "</div>\n";
    endif;
  endwhile;
  ?>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    function HeaderLineGallery() {
      $('.sideheader').each(function() {
        $('#mainimage .sideheader').css({ "height": $('#mainimage .slick-slide').height()-5 });
      });
    }

    HeaderLineGallery();

    $(window).resize(function(){ setTimeout(function() { HeaderLineGallery(); },100); });

    function SlideCounter() {
      var il = $('#mainimage .slick-current .gallery-image-main').css("background-image").replace(/.*\s?url\([\'\"]?/, '').replace(/[\'\"]?\).*/, '');
      var ImgLink = '<a href="'+il+'" data-fancybox="gallery"><i class="fas fa-search-plus fa-rotate-180"></i></a>';
      
      var slideindex = $('#mainimage .slick-slide.slick-active').data("slick-index");
      var firsttile = slideindex+1;
      $('#mainimage .sideheader H1').html('Image '+firsttile+'/'+$('#mainimage .slick-slide').not($('.slick-cloned')).length+ImgLink);

      $('[data-fancybox="gallery"]').fancybox({ infobar: false, buttons: ['close'], loop : true });
    }

    $('.gallery-images-nav .slick-arrow, .gallery-images-nav .slick-slide').click(function() { SlideCounter(); });

    SlideCounter();
  });
</script>

<?php get_footer(); ?>