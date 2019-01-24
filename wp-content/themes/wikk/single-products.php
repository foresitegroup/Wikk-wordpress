<?php
get_header();

if(have_posts()) : while(have_posts()) : the_post();
?>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.fancybox.min.js"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/slick.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/slick.min.js"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.min.js"></script>

<script src="<?php echo get_template_directory_uri(); ?>/inc/product.js"></script>

<div class="site-width">
  <div id="product-header">
    <div>
      <h1><?php if (has_term('bollards', 'product-category')) echo "Bollard "; the_title(); ?></h1>
      <?php if ($post->products_part_number != "") echo '<h2>Part # <span>' . $post->products_part_number . "</span></h2>\n"; ?>
    </div>
    
    <div id="buttons">
      <?php if (has_term(array('bollards', 'ingressr', 'switches'), 'product-category')) { ?>
      <div class="text">
        Not quite what you need?
        <div>Wikk does fully custom work.</div>
      </div>
      <?php } ?>
      
      <div class="buttons">
        <?php
        if ($post->products_spec_sheet != "") echo '<div><a href="'.$post->products_spec_sheet.'" class="button fa">Print Spec Sheet <i class="fas fa-print"></i></a></div>';

        if (has_term(array('bollards', 'ingressr', 'switches'), 'product-category')) {
          $ContactLink = (has_term('bollards', 'product-category')) ? "/request-for-quote/?bollard" : "/request-for-quote/";
        ?>
        <div><a href="<?php echo home_url() . $ContactLink; ?>" class="button contact">Contact Us</a></div>
        <?php } ?>
      </div>
    </div>
  </div>

  <div id="product">
    <div id="image">
      <div class="sideheader bottom"><h1></h1></div>

      <div id="images">
        <div id="bigimage"></div>

        <div id="imagethumbs">
          <?php
          $images = new Attachments('products_gallery');
          if($images->exist()) :
            while($images->get()) :
              echo '<div style="background-image: url('.$images->src('full').');">';
                echo $images->field('caption');
              echo "</div>\n";
            endwhile;
          endif;
          ?>
        </div>
      </div>

      <div id="caption"></div>
    </div>

    <div id="tabs">
      <?php if ($post->products_models != "") { ?>
      <input id="tab-models" type="radio" name="tabs" checked>
      <label for="tab-models">Models</label>
      <?php } ?>
      <?php if ($post->products_overview != "") { ?>
      <input id="tab-overview" type="radio" name="tabs"<?php if ($post->products_models == "") echo " checked"; ?>>
      <label for="tab-overview">Overview</label>
      <?php } ?>
      <?php if ($post->products_options != "") { ?>
      <input id="tab-options" type="radio" name="tabs">
      <label for="tab-options">Custom Options</label>
      <?php } ?>
      <?php if ($post->products_literature != "") { ?>
      <input id="tab-literature" type="radio" name="tabs">
      <label for="tab-literature">Literature</label>
      <?php } ?>
      
      <?php if ($post->products_models != "") { ?>
      <div id="content-models">
        <div>
          <?php echo $post->products_models; ?>
        </div>
      </div>
      <?php } ?>
      
      <?php if ($post->products_overview != "") { ?>
      <div id="content-overview">
        <div>
          <?php echo $post->products_overview; ?>
        </div>
      </div>
      <?php } ?>
      
      <?php if ($post->products_options != "") { ?>
      <div id="content-options">
        <div>
          <?php echo $post->products_options; ?>
        </div>
      </div>
      <?php } ?>
      
      <?php if ($post->products_literature != "") { ?>
      <div id="content-literature">
        <div>
          <?php echo $post->products_literature; ?>
        </div>
      </div>
      <?php } ?>
    </div> <!-- #tabs -->
  </div> <!-- #product -->
</div> <!-- .site-width -->

<?php if (has_term(array('bollards', 'ingressr', 'switches'), 'product-category')) { ?>
<div class="site-width product-contact">
  Not quite what you need? <span>Wikk does fully custom work.</span> <a href="<?php echo home_url(); ?>/request-for-quote/" class="button">Contact Us</a>
</div>
<?php } ?>

<div class="site-width">
  <?php
  if ($post->products_mounting != "") echo $post->products_mounting;

  global $related;
  $rel = $related->show(get_the_ID(), true);

  if (is_array($rel) && count($rel) > 0) {
  ?>
  <div class="related<?php if (has_term(array('switches', 'transmitters-receivers'), 'product-category')) echo ' switches'; ?>">
    <h3>
      <?php
      if (has_term('bollards', 'product-category')) echo "Related Bollards";
      if (has_term('ingressr', 'product-category')) echo "Related INGRESS'Rs";
      if (has_term(array('switches', 'transmitters-receivers'), 'product-category')) echo "Available Accessories";
      ?>
    </h3>

    <div class="scroller">
      <?php
      foreach ($rel as $r) {
        if ($r->post_status != 'trash') {
          $ri = "";
          $relimgs = new Attachments('products_gallery', $r->ID);
          if($relimgs->exist()) :
            if($relimg = $relimgs->get_single(0)) :
              $ri = $relimgs->src('full', 0);
            endif;
          endif;
          ?>
          <a href="<?php echo get_permalink($r->ID); ?>" class="tile">
            <div class="image" style="background-image: url(<?php echo $ri; ?>);"></div>

            <div class="text">
              <?php 
              if (has_term('bollards', 'product-category', $r->ID)) echo "<h2>Bollard</h2>";
              if (has_term('ingressr', 'product-category', $r->ID)) {
                echo "<h2>INGRESS'R</h2>";
                echo "<h1>" . preg_replace('/\(.+?\)/', '<div>$0</div>', get_the_title($r->ID)) . "</h1>";
              } else {
                echo "<h1>" . get_the_title($r->ID) . "</h1>";
              }

              $part_num = get_post_meta($r->ID, 'products_part_number', true);
              if (!empty($part_num)) echo "<h3>#" . $part_num . "</h3>\n";
              ?>
            </div>
          </a>
          <?php
          }
        }
      ?>
    </div>

    <div class="sideheader bottom"><h1></h1></div>
  </div> <!-- .related -->
  <?php } ?>
</div> <!-- .site-width -->

<?php
endwhile; endif;

get_footer();
?>