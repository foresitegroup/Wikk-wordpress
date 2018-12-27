<?php
/* Template Name: FAQ */

get_header();
?>

<script type="text/javascript">
  jQuery(document).ready(function(){
    jQuery("dd").hide();

    jQuery("dl dt").click(function(){
      $(this).toggleClass('show');
      jQuery(this).next('dd').slideToggle();
      return false;
    });
  });
</script>

<div class="site-width page-content faq-content">
  <?php
  if ( have_posts() ) :
  	while ( have_posts() ) : the_post();
      the_title('<h1 class="page-title">', '</h1>');
  		the_content();
  	endwhile;
  endif;
  ?>
</div>

<?php
$FooterTextClass = "faq-prefooter";
$FooterText = "Have other questions?";

get_footer();
?>