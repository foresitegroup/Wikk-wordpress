<?php get_header(); ?>

<div class="site-width">
  <div id="product-header">
    <?php
    $tax = $wp_query->get_queried_object();

    echo "<div>";
      echo '<h1>'. $tax->name;
      //if ($tax->slug == "ingressr") echo '<sup class="reg">&reg;</sup>';
      echo '</h1>';

      // if ($tax->slug == "bollards") {
      //   echo "<h2>Stock Bollards - Ready in 24hrs</h2>";
      //   echo "<h2>Custom Bollards - Variable Lead Time</h2>";
        // echo '<h3>For complete listing of bollard offerings, see our Price Catalog in the <a href="'.home_url().'/pro/">Pro Area</a></h3>';
      // }
    echo "</div>";

    if (has_term(array('bollards', 'ingressr', 'switches'), 'product-category')) {
      $ContactLink = (has_term('bollards', 'product-category')) ? "/request-for-quote/?bollard" : "/request-for-quote/";
      ?>
      <div id="contact-button">
        Not quite what you need?
        <div>Wikk does fully custom work.</div>
        <a href="<?php echo home_url() . $ContactLink; ?>" class="button">Contact Us</a>
      </div>
    <?php } ?>
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
        <!-- <form action="<?php //echo home_url($wp->request.'/'); ?>" method="POST" name="filter" id="filter"> -->
        <form action="<?php echo home_url(); ?>/product-category/<?php echo $tax->slug; ?>/" method="POST" name="filter" id="filter">
          <?php
          if ($tax->slug == "bollards") {
            echo "<h5>Shape</h5>";
            products_attributes_frontend('bollard_shape');

            echo "<br><br><h5>Material</h5>";
            products_attributes_frontend('bollard_material');

            echo "<br><br><h5>Finish</h5>";
            products_attributes_frontend('bollard_finish');

            echo "<br><br><h5>Type</h5>";
            products_attributes_frontend('bollard_type');
          }

          if ($tax->slug == "ingressr") {
            // echo "<h5>Material</h5>";
            // products_attributes_frontend('ingressr_material');

            echo "<h5>Product Group</h5>";
            products_attributes_frontend('ingressr_product_group');
          }

          if ($tax->slug == "switches") {
            echo "<h5>Style</h5>";
            products_attributes_frontend('switch_style');
          }

          if ($tax->slug == "transmitters-receivers") {
            echo "<h5>Type</h5>";
            products_attributes_frontend('tranrec_type');

            echo "<br><br><h5>Frequency</h5>";
            products_attributes_frontend('tranrec_frequency');
          }
          ?>
        </form>
      </div>

      <div class="sideheader"><h1>Filters</h1></div>
    </div>

    <script type="text/javascript">
      $(document).ready(function() {
        function HeaderLineProduct() {
          $('.sideheader').each(function() {
            $('#product-index-sidebar .sideheader').css({ "height": $('#filter-search').height()+28 });
          });
        }

        HeaderLineProduct();

        $(window).resize(function(){ setTimeout(function() { HeaderLineProduct(); },100); });
      });
    </script>

    <div id="product-index-links"<?php if ($tax->slug == "switches" || $tax->slug == "transmitters-receivers") echo ' class="switches"'; ?>>
      <?php
      global $wp_query;

      $meta_query = array('relation' => 'AND');

      $modifications = array();
      $modifications['posts_per_page'] = 12;

      foreach ($attnames as $attname) {
        if (isset($_REQUEST[$attname])) {
          $meta_query_shape = array('relation' => 'OR');
          foreach ($_REQUEST[$attname] as $value) {
            $meta_query_shape[] = array('key' => $attname, 'value' => $value, 'compare' => 'LIKE');
            $modifications['posts_per_page'] = 9999;
          }
          $meta_query[] = $meta_query_shape;
        }
      }

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
          if ($images->exist()) {
            $image = $images->src('full', 0);
            while($images->get()) :
              if ($images->field('option') != "") $image = $images->src('full');
            endwhile;
          }

          echo '<div class="image" style="background-image: url('.$image.');"></div>';
          
          echo '<div class="text">';
            if ($tax->slug == "bollards") echo "<h3>Bollard</h3>";
            if ($tax->slug == "ingressr") echo "<h3>INGRESS'R</h3>";
            
            if ($tax->slug == "ingressr") {
              echo "<h2>" . preg_replace('/\(.+?\)/', '<div>$0</div>', get_the_title()) . "</h2>";
            } else {
              the_title('<h2>', '</h2>');
            }

            if ($post->products_part_number != "") echo '<h4>#' . $post->products_part_number . "</h4>\n";

            if ($tax->slug == "bollards" && $post->bollard_type != "") echo "<h5>".$post->bollard_type."</h5>";
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
if (has_term(array('bollards', 'ingressr', 'switches'), 'product-category')) {
  $FooterTextClass = "prodcat";
  $FooterText = "Not quite what you need? <span>Wikk does fully custom work.</span>";
}

if (has_term(array('bollards'), 'product-category')) $ShowCBR = "yes";

get_footer();
?>