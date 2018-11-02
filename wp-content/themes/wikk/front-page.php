<?php get_header(); ?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/slick.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/slick.min.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $('.hero').slick({
      autoplay: true,
      autoplaySpeed: 7000,
      fade: true,
      speed: 2000,
      arrows: false
    });
  });
</script>

<div class="hero">
  <div class="slide1" style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/slide1.jpg);">
    <div class="site-width">
      <h1>Elevating spaces through accessibility.</h1>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis tortor quis fringilla placerat. Suspendisse eget eros metus. In in dictum nisi. Praesent venenatis, tortor nec sollicitudin cursus, lectus aliquam mauris, id malesuada enim urna at leo. Etiam imperdiet risus massa, ut sollicitudin ipsum tristique ut. Morbi dignissim quis arcu a viverra. Sed nec diam at felis luctus iaculis.<br>

      <a href="#" class="button">Learn More About Our Mission</a>
    </div>
  </div>

  <div class="slide2" style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/slide2.jpg);">
    <div class="site-width">
      <img src="<?php echo get_template_directory_uri(); ?>/images/slide2-haptikk.png" alt="Haptikk Solutions"><br>
      <a href="#" class="button">Learn More About Our Innovations</a>
    </div>
  </div>
</div>

<!-- <div id="hero">
  <div class="site-width">
    <div>
      <h1>Elevating spaces through accessibility.</h1>
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis tortor quis fringilla placerat. Suspendisse eget eros metus. In in dictum nisi. Praesent venenatis, tortor nec sollicitudin cursus, lectus aliquam mauris, id malesuada enim urna at leo. Etiam imperdiet risus massa, ut sollicitudin ipsum tristique ut. Morbi dignissim quis arcu a viverra. Sed nec diam at felis luctus iaculis.
    </div>
  </div>
</div> -->

<div class="home-featured">
  <div class="site-width">
    <div class="sidetitle"><h1>Featured Solution</h1></div>

    <div class="image">
      <div id="fic"><img src="<?php echo get_template_directory_uri(); ?>/images/product-background.png" alt=""></div>
      <img src="<?php echo get_template_directory_uri(); ?>/images/home-featured.png" alt="" id="fi">
    </div>

    <div class="text">
      <h2>The RD-17 Bollard</h2>
      <h3>with SFA Switch</h3>
      A robust bollard for everyday use. Removable Bollard for In-ground mounting,  Flat Recessed area for ADA switch and Card Reader, 1 Prep on the angle top for intercom, Welded Angle top to the front.<br>

      <a href="#" class="button">See All Standard Bollard Options</a>
    </div>
  </div>
</div>

<div id="home-testimonials">
  <div class="site-width">
    <div class="sidetitle"><h1>Testimonials</h1></div>

    <div id="slides">
      <img src="<?php echo get_template_directory_uri(); ?>/images/paren-left.svg" alt="" id="pl">
      <img src="<?php echo get_template_directory_uri(); ?>/images/paren-right.svg" alt="" id="pr">

      <div>
        "Wikk has provided us with a wide bredth of accessibility solutions that has not only helped us become a more inclusive environment, but has provided us with peace of mind as well. They are always there to help."<br>
        <br>
        <span>- Jane Jones,</span> Business Manager
      </div>

      <div>
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis tortor quis fringilla placerat. Suspendisse eget eros metus. In in dictum nisi. Praesent venenatis, tortor nec sollicitudin cursus, lectus aliquam mauris, id malesuada enim urna at leo."<br>
        <br>
        <span>- John Smith,</span> Doctor
      </div>
    </div>
  </div>
</div>

<div id="home-blog">
  <div class="site-width">
    <div class="sidetitle"><h1>Innovations / Blogs</h1></div>

    <div id="blog-tiles">
      <a href="#">
        <h5>Innovation</h5>

        <div class="image" style="background-image: url(https://picsum.photos/640/360);"></div>

        <h4>Wikk Touchless Switch</h4>

        <div class="text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis tortor quis fringilla placerat. Suspendisse eget eros metus. In in dictum nisi. Praesent venenatis, tortor nec sollicitudin cursus...</div>
      </a>

      <a href="#">
        <h5>Blog</h5>

        <div class="image" style="background-image: url(https://picsum.photos/641/361);"></div>

        <h4>Accessibility takes the big stage</h4>

        <div class="text">Praesent venenatis, tortor nec sollicitudin cursus, lectus aliquam mauris, id malesuada enim urna at leo. Ut convallis tortor quis fringilla placerat.</div>
      </a>

      <a href="#">
        <h5>Blog</h5>

        <div class="image" style="background-image: url(https://picsum.photos/642/362);"></div>

        <h4>Access for everyone</h4>

        <div class="text">Ut convallis tortor quis fringilla placerat. Suspendisse eget eros metus. In in dictum nisi. Praesent venenatis, tortor nec sollicitudin cursus, lectus aliquam mauris, id malesuada enim urna at leo...</div>
      </a>
    </div>
  </div>
</div>

<div id="home-blog-more">
  <a href="#" class="button">See All Innovations &amp; Blogs</a>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('.home-featured .image').height($('.home-featured .image #fi').height()-45);

    $(window).scroll(function() {
      var theta = $(window).scrollTop() / 3000 % Math.PI;
      $('#fic IMG').css({ transform: 'rotate(' + theta + 'rad)' });
    });

    var ParenTime = 1500;
    var FadeTime = 1000;
    var DelayTime = 5000;
    var CrossFade = 500;
    var TotalTime = (ParenTime*2) + (FadeTime*2) + DelayTime - (CrossFade*2);
    var slideIndex = 0;

    function SlideShow() {
      $("#slides DIV").css("display", "none");
      slideIndex++;
      if (slideIndex > $("#slides DIV").length) slideIndex = 1;

      $("#pl").animate({ left: "0" }, ParenTime);
      $("#pr").animate({ left: $('#slides').width() - $('#pr').width() }, ParenTime);

      setTimeout(function() {
      $('#slides DIV:nth-of-type('+slideIndex+')').css("display", "block")
        .animate({ opacity: 1 }, FadeTime)
        .delay(DelayTime)
        .animate({ opacity: 0 }, FadeTime);
      }, ParenTime - CrossFade);
      
      setTimeout(function() {
        $("#pl").animate({ left: ($('#slides').width()*0.48) - $('#pl').width() }, ParenTime);
        $("#pr").animate({ left: "52%" }, ParenTime);
      }, DelayTime + (FadeTime*2));

      setTimeout(SlideShow, TotalTime);
    }
    
    SlideShow();
  });
</script>

<?php get_footer(); ?>