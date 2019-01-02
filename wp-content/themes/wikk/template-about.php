<?php
/* Template Name: About */

get_header();
?>

<div id="about">
  <div class="site-width">
    <?php
    if ( have_posts() ) :
    	while ( have_posts() ) : the_post();
        the_title('<h1 class="news-title">', '</h1>');
        
        echo '<div class="text">';
          the_content();
        echo "</div>\n";
    	endwhile;
    endif;
    ?>
  </div>

  <div id="image"<?php if (has_post_thumbnail()) echo ' style="background-image: url('.get_the_post_thumbnail_url().');"' ?>>
    <?php if ($post->featured_image_caption != "") echo '<div>'.$post->featured_image_caption.'</div>' ?>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    function CaptionPosition() {
      if (window.innerWidth > 1739) {
        $('#image').width($('#image').outerHeight()*0.83);
      } else {
        $('#image').width('');
      }
    }

    CaptionPosition();

    $(window).resize(function(){ setTimeout(function() { CaptionPosition(); },100); });
  });
</script>

<?php
echo do_shortcode('[testimonials]');

echo do_shortcode('[map]');

$FooterText = "Want to say Hi? Come visit Wikk's plant!";

get_footer();
?>