<?php $category = get_queried_object(); ?>

<div class="site-width news-index">
  <div class="sidetitle"><h1><?php echo $category->name; ?></h1></div>

  <script type="text/javascript">
    $(document).ready(function() {
      function TitleLineNews() {
        $('.sidetitle').each(function() {
          $('.sidetitle').css({ "width": $('.news-posts').height()-45 });
        });
      }

      TitleLineNews();

      $(window).resize(function(){ setTimeout(function() { TitleLineNews(); },100); });
    });
  </script>
  
  <div class="news-posts">
    <?php
    if(have_posts()) :
      while(have_posts()) : the_post();
        if ($post->news_tab != "news") {
          $text = fg_excerpt(30) . "...";
          $link = get_permalink();
        } else {
          $text = $post->news_source;
          $link = $post->news_link;
        }

        echo '<a href="'.$link.'" class="news-post">';
          echo '<div class="cat-date">';
            $cats = wp_get_post_categories(get_the_ID());
            if (!empty($cats)) {
              $sep = ', '; $output = '';
              foreach($cats as $cat) {
                $c = get_category($cat);
                $output .= esc_html($c->name) . $sep;
              }
              echo '<div>'.trim($output, $sep).'</div>';
            }

            echo '<div>'.get_the_date('n/j/y')."</div>
          </div>\n";

          if (has_post_thumbnail()) {
            echo '<div class="image" style="background-image: url('.get_the_post_thumbnail_url(get_the_ID(),'full').');"></div>';
          }

          the_title('<h1>','</h1>');

          echo $text;

        echo '</a>';
      endwhile;
    endif;
    ?>
  </div> <!-- /.news-posts -->

  <div class="pagination news">
    <?php
    $paginate_args = array('show_all' => true, 'prev_text' => '<', 'next_text' => '>');
    echo paginate_links($paginate_args);
    ?>
  </div> <!-- /.pagination -->
</div> <!-- /.news-index -->