<?php get_header(); ?>

<div class="site-width">
  <div id="product-header">
    <?php
    $tax = $wp_query->get_queried_object();
    echo '<h1>'. $tax->name . '</h1>';
    ?>
  </div>
</div>

<div class="site-width pi">
  <div id="product-index">
    <div id="product-index-sidebar">
      <div class="pagination">
        <?php
        $paginate_args = array('show_all' => true, 'prev_text' => '&laquo;', 'next_text' => '&raquo;');
        echo paginate_links($paginate_args);
        ?>
      </div>

      <input type="checkbox" id="toggle-filter" role="button">
      <label for="toggle-filter">Filters</label>
      
      <div id="filter-search">
        <form action="<?php echo home_url($wp->request.'/'); ?>" method="POST" name="filter" id="filter">
          <?php
          if ($tax->name == "Bollards") {
            echo "<h5>Shape</h5>";
            products_attributes_frontend('bollard_shape');

            echo "<br><br><h5>Material</h5>";
            products_attributes_frontend('bollard_material');
          }

          if ($tax->name == "Ingress'r") {
            echo "<h5>Space</h5>";
            products_attributes_frontend('ingressr_space');

            echo "<br><br><h5>Mounting</h5>";
            products_attributes_frontend('ingressr_mounting');

            echo "<br><br><h5>Material</h5>";
            products_attributes_frontend('ingressr_material');
          }

          if ($tax->name == "Switches") {
            echo "<h5>Style</h5>";
            products_attributes_frontend('switch_style');

            echo "<br><br><h5>Active Area</h5>";
            products_attributes_frontend('switch_active_area');
          }
          ?>
        </form>
      </div>

      <div class="sidetitle"><h1>Filters</h1></div>
    </div>

    <script type="text/javascript">
      $(document).ready(function() {
        function TitleLineProduct() {
          $('.sidetitle').each(function() {
            $('#product-index-sidebar .sidetitle').css({ "width": $('#filter-search').height()+28 });
          });
        }

        TitleLineProduct();

        $(window).resize(function(){ setTimeout(function() { TitleLineProduct(); },100); });
      });
    </script>

    <div id="product-index-links"<?php if ($tax->name == "Switches") echo ' class="switches"'; ?>>
      <?php
      global $wp_query;

      $meta_query = array('relation' => 'AND');

      foreach ($attnames as $attname) {
        if (isset($_REQUEST[$attname])) {
          $meta_query_shape = array('relation' => 'OR');
          foreach ($_REQUEST[$attname] as $value) {
            $meta_query_shape[] = array('key' => $attname, 'value' => $value, 'compare' => 'LIKE');
          }
          $meta_query[] = $meta_query_shape;
        }
      }

      $modifications = array();
      $modifications['meta_query'][] = $meta_query;

      $args = array_merge($wp_query->query_vars, $modifications);
      query_posts($args);

      if(have_posts()) :
        while(have_posts()) : the_post();
          echo '<a href="';
          the_permalink();
          echo '">';
          
          $image = "";
          $images = new Attachments('products_gallery');
          if ($images->exist()) $image = $images->src('full', 0);
          echo '<div class="image" style="background-image: url('.$image.');"></div>';
          
          echo '<div class="text">';
            // if ($tax->name != "Switches") echo '<h3>'. $tax->description . '</h3>';
            if ($tax->name == "Bollards") echo "<h3>Bollard</h3>";
            if ($tax->name == "Ingress'r") echo "<h3>Ingress'r</h3>";

            the_title('<h2>','</h2>');

            if ($post->products_part_number != "") echo '<h4>#' . $post->products_part_number . "</h4>\n";
          echo "</div>\n";

          echo "</a>\n";
        endwhile;
      endif;
      ?>
    </div>
  </div>
  
  <div class="pagination">
    <?php
    $paginate_args = array('show_all' => true, 'prev_text' => '&laquo;', 'next_text' => '&raquo;');
    echo paginate_links($paginate_args);
    ?>
  </div>
</div>

<?php
$FooterTextClass = "prodcat";
$FooterText = "Not quite what you need? <span>Wikk does fully custom work.</span>";
get_footer();
?>