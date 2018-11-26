<?php get_header(); ?>

<div class="site-width page-content">
  <?php
  if ( have_posts() ) :
  	while ( have_posts() ) : the_post();
      the_title('<h1 class="page-title">', '</h2>');
  		the_content();
  	endwhile;
  endif;
  ?>
</div>

<?php get_footer(); ?>