<?php get_header(); ?>

<div class="site-width gallery-index">
  <h1 class="news-title">Gallery</h1>

  <?php
  while(have_posts()) : the_post();
    echo '<div class="gallery">';
      the_title('<h2>','</h2>');

      the_content();

      $gallimages = new Attachments('gallery_gallery');
      if($gallimages->exist()) :
        echo '<div class="gallery-images">';
          for ($i = 0; $i < 4; $i++) {
            echo '<a href="'.get_permalink().'" style="background-image: url('.$gallimages->src('full', $i).');"></a>';
          }
        echo "</div>\n";
      endif;

      echo '<a href="'.get_permalink().'" class="gallery-link">See Full Gallery</a>';
    echo "</div>\n";
  endwhile;
  ?>
  
  <div class="pagination">
    <?php
    $paginate_args = array('show_all' => true, 'prev_text' => '<', 'next_text' => '>');
    echo paginate_links($paginate_args);
    ?>
  </div> <!-- /.pagination -->
</div> <!-- /.site-width -->

<?php get_footer(); ?>