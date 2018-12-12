<?php
if (is_single()) : ?>
  <div class="site-width news-single-header">
    <?php
    $id = get_the_ID();

    the_title('<h1>', '</h1>');

    $category = get_the_category();

    $cats = wp_get_post_categories(get_the_ID(), array('parent' =>  $category[0]->category_parent));
    if (!empty($cats)) {
      $sep = ', '; $output = '';
      foreach($cats as $cat) {
        $c = get_category($cat);
        $output .= esc_html($c->name) . $sep;
      }
      echo '<span class="purpletext">'.trim($output, $sep) . "</span> &bull; ";
    }

    echo get_the_date('n/j/y');
    ?>

    <input type="checkbox" id="toggle-share" role="button">
    <label for="toggle-share">Share <i class="fas fa-share-alt"></i></label>
    <div id="share-links">
      <?php
      $sharesearch = array(' ', '|', '&#038;');
      $treplace = array('+', '%7C', '%26');
      $lreplace = array('+', '%20', '%26');
      ?>
      <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); if (has_post_thumbnail()) echo '&picture='.get_the_post_thumbnail_url(); ?>" target="new" class="facebook"></a>
      <a href="http://www.twitter.com/share?url=<?php the_permalink(); ?>&text=<?php echo str_replace($sharesearch, $treplace, the_title('','',false)); ?>" target="new" class="twitter"></a>
      <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php echo str_replace($sharesearch, $lreplace, the_title('','',false)); ?>" target="new" class="linkedin"></a>
    </div>
  </div> <!-- .news-single-header -->
  
  <div class="site-width news-single">
    <div id="news-single-sidebar">
      <?php if (has_post_thumbnail()) { ?>
        <div id="news-single-image" style="background-image: url(<?php echo wp_get_attachment_url(get_post_thumbnail_id()); ?>);"></div>

        <?php if ($post->featured_image_caption != "") { ?>
          <div id="news-single-image-caption">
            <?php echo $post->featured_image_caption; ?>
          </div>
        <?php } ?>
        
        <div id="news-single-image-spacer"></div>
      <?php } ?>
      
      <?php
      $recent = new WP_Query(array('post_type' => 'post', 'category_name' => 'innovations', 'post__not_in' => array(get_the_ID()), 'posts_per_page' => 3));
      
      if($recent->have_posts()) :
        echo '<h3>Recent Innovations</h3>';
        while($recent->have_posts()) : $recent->the_post();
          echo '<a href="'.get_permalink().'" class="recent-link">'.get_the_title()." &raquo;</a><br><br>\n";
        endwhile;
      endif;

      wp_reset_postdata();
      ?>
    </div>
    
    <div id="news-single-text">
      <?php the_content(); ?>
    </div>
  </div>
  
  <?php
  $gallimages = new Attachments('posts_gallery');
  if($gallimages->exist()) :
    ?>
    <div class="post-gallery-wrap site-width">
      <h4>Image Gallery</h4>

      <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.css">
      <script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.min.js"></script>
      <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/slick.css">
      <script src="<?php echo get_template_directory_uri(); ?>/inc/slick.min.js"></script>
      <script src="<?php echo get_template_directory_uri(); ?>/inc/gallery.js"></script>

      <div class="post-gallery">
        <?php
        while($gallimages->get()) :
          echo '<a href="'.$gallimages->src('full').'" data-fancybox="gallery"></a>';
        endwhile;
        ?>
      </div>
    </div>
  <?php endif; ?>
  
<?php endif; ?>