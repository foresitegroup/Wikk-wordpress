<?php
/* Template Name: Social Responsibility */

get_header();
?>

<div id="sr">
  <?php
	while (have_posts()) : the_post();
    the_title('<div class="site-width"><h1 class="news-title">', '</h1></div>');
    
    echo '<div id="sr-content">';
      echo '<div class="site-width">';
        the_content();
      echo '</div>';
    echo '</div>';
	endwhile;
  ?>

  <div id="sr-partners" class="site-width">
    <h2>Our Partners</h2>
    
    <?php
    $partners = new WP_Query(array('post_type'=>'partners', 'orderby'=>'menu_order', 'order'=> 'ASC', 'showposts' => -1));

    while($partners->have_posts()) : $partners->the_post();
    ?>
      <div class="sr-partner">
        <div class="image">
          <?php if (has_post_thumbnail()) echo '<img src="'.get_the_post_thumbnail_url().'" alt="">' ?>
        </div>

        <div class="text">
          <?php
          the_title('<h3>','</h3>');

          the_content();

          if (isset($post->partners_link)) echo '<a href="'.$post->partners_link.'" class="sr-link">Visit Their Site &raquo;</a>';
          ?>
        </div>
      </div>
    <?php
    endwhile;

    wp_reset_query();
    ?>
  </div>
</div>

<?php
$FooterTextClass = "prefooter-hide";

get_footer();
?>