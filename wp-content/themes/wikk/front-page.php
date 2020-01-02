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
  <!-- <div class="slide1" style="background-image: url(<?php //echo get_template_directory_uri(); ?>/images/slide1.jpg);">
    <div class="site-width">
      <h1>Elevating spaces through accessibility.</h1>
      Since its founding in 1980, Wikk&reg; has been a trusted resource to bridge the "accessibility gap" by delivering patented, code compliant solutions with user-friendly designs.  Our products are being used in some of the most iconic buildings in North America, including the Empire State Building, World Trade Center Oculus, Los Angeles Stadium, and the United States Capitol to name a few.  We are a family-owned business that strives on a daily basis to continually exceed our customers' increasing expectations.<br>
      <br>

      Let us show you <strong class="redtext">simply. accessible.</strong><br>

      <a href="<?php //echo home_url(); ?>/about/" class="button">Learn More About Our Mission</a>
    </div>
  </div> -->

  <!-- <div class="slide2" style="background-image: url(<?php //echo get_template_directory_uri(); ?>/images/slide2.jpg);">
    <div class="site-width">
      <img src="<?php //echo get_template_directory_uri(); ?>/images/slide2-haptikk.png" alt="Haptikk Solutions"><br>
      <a href="<?php //echo home_url(); ?>/news/innovations/" class="button">Learn More About Our Innovations</a>
    </div>
  </div> -->

  <div class="slide40" style="background-image: url(<?php echo get_template_directory_uri(); ?>/images/slide-40-years.jpg);">
    <div class="site-width">
      <img src="<?php echo get_template_directory_uri(); ?>/images/40-years.png" alt="Celebrating 40 years of service"><br>
      <a href="<?php echo home_url(); ?>/about/" class="button">Learn More About Wikk's Impact</a>
    </div>
  </div>
</div>

<div id="featured-solution">
  <div class="site-width">
    <div class="sideheader"><h1>Featured Solution</h1></div>

    <div class="image">
      <div id="fsbg"></div>
      <img src="https://wikk.com/wp-content/uploads/2019/09/Bollards.png" alt="" id="fsi">
    </div>

    <div class="text">
      <h2>Built Right.<br>Built by<br>Wikk.</h2>
      <br>

      <a href="<?php home_url(); ?>/product-category/bollards/" class="button">Learn More</a>
    </div>
  </div>
</div>

<div id="cbr-banner">
  <div class="site-width">
    <div class="image">
      <img src="<?php echo get_template_directory_uri(); ?>/images/cbr.png" alt="">
    </div>

    <div class="text">
      <h2>Custom Bollard Resources</h2>

      Wikk Industries stands as an industry pioneer in providing custom bollard solutions to our clients. With almost every aspect of our bollards being customizable, we aim to provide the most personal and effective solution to each of our clients.<br>

      <a href="<?php home_url(); ?>/custom-bollard-resources/" class="button">View Resources</a>
    </div>
  </div>
</div>

<?php echo do_shortcode('[testimonials]'); ?>

<div id="home-blog">
  <div class="site-width">
    <div class="sideheader"><h1>Innovations / News</h1></div>

    <div id="blog-tiles">
      <?php
      $innovations = new WP_Query(array('showposts' => 1, 'category_name' => 'innovations'));

      if ($innovations->have_posts()) {
        while ($innovations->have_posts() ) : $innovations->the_post();
          echo '<a href="'.get_permalink().'">';
            echo '<h5>Innovations</h5>';

            $BlogImage = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : "";
            echo '<div class="image" style="background-image: url('.$BlogImage.');"></div>';

            the_title('<h4>','</h4>');

            echo '<div class="text">'.fg_excerpt(28, "...").'</div>';
          echo '</a>';
        endwhile;
      }

      $news = new WP_Query(array('showposts' => 2, 'category_name' => 'news'));

      if ($news->have_posts()) {
        while ($news->have_posts() ) : $news->the_post();
          echo '<a href="'.$post->news_link.'">';
            echo '<h5>News</h5>';

            $BlogImage = (has_post_thumbnail()) ? get_the_post_thumbnail_url() : get_template_directory_uri()."/images/footer-logo.svg";
            echo '<div class="image news" style="background-image: url('.$BlogImage.');"></div>';

            the_title('<h4>','</h4>');

            echo '<div class="text">'.$post->news_source.'</div>';
          echo '</a>';
        endwhile;
      }
      ?>
    </div>
  </div>
</div>

<div id="home-blog-more">
  <a href="<?php echo home_url(); ?>/news/innovations/" class="button">See All Innovations &amp; News</a>
</div>

<?php get_footer(); ?>