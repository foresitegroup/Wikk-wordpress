<?php
// We want Featured Images on Pages and Posts
add_theme_support( 'post-thumbnails' );

// ...and add a caption field to it
add_filter( 'admin_post_thumbnail_html', 'add_featured_image_display_settings', 10, 2 );
function add_featured_image_display_settings($content, $post) {
  $fic = get_post_meta($post, "featured_image_caption", true);
  
  $fi_caption = '<strong>Caption</strong><br>';
  $fi_caption .= '<input type="text" name="featured_image_caption" value="';
  if ($fic != "") $fi_caption .= $fic;
  $fi_caption .= '" style="width: 100%;">';

  return $content .= $fi_caption;
}

add_action('save_post', 'save_featured_image_display_settings', 10, 3);
function save_featured_image_display_settings($post_id, $post, $update) {
  if (!empty($_POST['featured_image_caption'])) {
    update_post_meta($post_id, 'featured_image_caption', $_POST['featured_image_caption']);
  } else {
    delete_post_meta($post_id, 'featured_image_caption');
  }
}



// Don't resize Featured Images
function my_thumbnail_size() {
  set_post_thumbnail_size();
}
add_action('after_setup_theme', 'my_thumbnail_size', 11);


// Don't wrap images in P tags
add_filter('the_content', 'filter_ptags_on_images');
function filter_ptags_on_images($content){
  return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}


// Wrap video embed code in DIV for responsive goodness
add_filter('embed_oembed_html', 'my_oembed_filter', 10, 4);
function my_oembed_filter($html, $url, $attr, $post_ID) {
  $return = '<div class="video">'.$html.'</div>';
  return $return;
}


// Define menus
function register_my_menus() {
  register_nav_menus(
    array(
      // 'top-menu' => __('Top Menu'),
      'main-menu' => __('Main Menu'),
      // 'footer-buttons' => __('Footer Buttons'),
      // 'social' => __('Footer Social'),
      'footer-menu' => __('Footer Menu')
    )
  );
}
add_action( 'init', 'register_my_menus' );


// Show site styles in visual editor
function add_editor_styles() {
  add_editor_style('editor-style.css');
}
add_action('admin_init', 'add_editor_styles');


// Remove emojis
function disable_wp_emojicons() {
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
  add_filter( 'emoji_svg_url', '__return_false' );
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


function fg_excerpt($limit, $more = '') {
  return wp_trim_words(get_the_excerpt(), $limit, $more);
}


function meta_og() {
  global $post;

  if (is_single()) {
    if(has_post_thumbnail($post->ID))
      $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');

    $excerpt = strip_tags($post->post_content);
    $excerpt_more = '';

    if (strlen($excerpt ) > 155) {
      $excerpt = substr($excerpt,0,155);
      $excerpt_more = ' ...';
    }

    $excerpt = str_replace('"', '', $excerpt);
    $excerpt = str_replace("'", '', $excerpt);
    $excerptwords = preg_split('/[\n\r\t ]+/', $excerpt, -1, PREG_SPLIT_NO_EMPTY);
    array_pop($excerptwords);
    $excerpt = implode(' ', $excerptwords) . $excerpt_more;
    ?>

    <meta name="author" content="Wikk Industries">
    <meta name="description" content="<?php echo $excerpt; ?>">
    <meta property="og:title" content="<?php echo the_title(); ?>">
    <meta property="og:description" content="<?php echo $excerpt; ?>">
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?php echo the_permalink(); ?>">
    <meta property="og:site_name" content="Wikk Industries">
    <meta property="og:image" content="<?php echo $img_src[0]; ?>">
    <?php
  } else {
    return;
  }
}
add_action('wp_head', 'meta_og', 5);


/////////////
// PRODUCTS
/////////////
add_action('init', 'products');
function products() {
  register_post_type('products', array(
      'labels' => array(
        'name' => 'Products',
        'singular_name' => 'Product',
        'add_new_item' => 'Add New Product',
        'edit_item' => 'Edit Product',
        'search_items' => 'Search Products',
        'not_found' => 'No Products found'
      ),
      'show_ui' => true,
      'menu_position' => 53,
      'menu_icon' => 'dashicons-cart',
      'supports' => array('title'),
      'taxonomies' => array('product-category'),
      'has_archive' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'show_in_nav_menus' => true
  ));
}

add_action('init', 'products_create_taxonomy');
function products_create_taxonomy() {
  register_taxonomy('product-category', 'products', array('labels' => array('name' => 'Product Categories', 'singular_name' => 'Product Category'), 'hierarchical' => true));
}

add_filter('enter_title_here', 'products_title');
function products_title($input) {
  if (get_post_type() === 'products') return "Enter product name here";
  return $input;
}

// Place fields after the title
add_action('edit_form_after_title', 'product_after_title');
function product_after_title($post) {
  if (get_post_type() == 'products') {
    echo '<input type="text" name="products_part_number" placeholder="Enter part number here" value="';
    if ($post->products_part_number != "") echo $post->products_part_number;
    echo '" id="products_part_number">';

    echo '<input type="text" name="products_spec_sheet" placeholder="Spec Sheet" id="products_spec_sheet" class="with_button" value="';
    if ($post->products_spec_sheet != "") echo $post->products_spec_sheet;
    echo '">
    <input type="button" id="products_spec_sheet_button" class="button" value="Add/Edit PDF">';
    ?>
    <script>
      function WWDimage($image_id) {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        wp.media.editor.send.attachment = function(props, attachment) {
          jQuery($image_id).val(attachment.url);
          wp.media.editor.send.attachment = send_attachment_bkp;
        }
        wp.media.editor.open();
        return false;
      }

      jQuery('#products_spec_sheet_button').click(function(){ WWDimage("#products_spec_sheet");});
    </script>
    <?php
  }
}

add_action('add_meta_boxes', 'products_mb');
function products_mb() {
  add_meta_box('products_mb', 'Tabs', 'products_mb_content', 'products', 'normal');
  add_meta_box('products_mb_mounting', 'Available Mounting Options', 'products_mb_mounting_content', 'products', 'normal');
  add_meta_box('products_mb_sort', 'Title Sort', 'products_mb_sort_content', 'products', 'side', 'high');
  add_meta_box('products_mb_attributes', 'Attributes', 'products_mb_attributes_content', 'products', 'side');
}

function products_mb_content($post) {
  ?>
  <h3>Models</h3>
  <?php
  wp_editor(html_entity_decode($post->products_models, ENT_QUOTES), 'products_models', array('textarea_rows' => 20, 'wpautop' => false, 'tinymce' => false));
  ?>

  <hr>

  <h3>Overview</h3>
  <?php
  wp_editor(html_entity_decode($post->products_overview, ENT_QUOTES), 'products_overview', array('textarea_rows' => 20, 'wpautop' => false, 'tinymce' => false));
  ?>

  <hr>

  <h3>Custom Options</h3>
  <?php
  wp_editor(html_entity_decode($post->products_options, ENT_QUOTES), 'products_options', array('textarea_rows' => 20, 'wpautop' => false, 'tinymce' => false));
  ?>

  <hr>

  <h3>Literature</h3>
  <?php
  wp_editor(html_entity_decode($post->products_literature, ENT_QUOTES), 'products_literature', array('textarea_rows' => 20, 'wpautop' => false, 'tinymce' => false));
  ?>

  <hr>

  <h3>CUSTOM TAB</h3>
  <?php
  echo '<input type="text" name="products_custom_tab_text" placeholder="Enter tab text here" value="';
  if ($post->products_custom_tab_text != "") echo $post->products_custom_tab_text;
  echo '" id="products_custom_tab_text" maxlength="18">';

  wp_editor(html_entity_decode($post->products_custom_tab, ENT_QUOTES), 'products_custom_tab', array('textarea_rows' => 20, 'wpautop' => false, 'tinymce' => false));
  ?>
  <?php
}

function products_mb_mounting_content($post) {
  ?>
  <?php
  wp_editor(html_entity_decode($post->products_mounting, ENT_QUOTES), 'products_mounting', array('textarea_rows' => 20, 'wpautop' => false, 'tinymce' => false));
  ?>
  <?php
}

function products_mb_sort_content($post) {
  echo '<input type="text" name="products_title_sort" placeholder="Enter sort title here" value="';
  if ($post->products_title_sort != "") echo $post->products_title_sort;
  echo '" id="products_title_sort">';
}

function products_mb_attributes_content($post) {
  echo "<strong>Bollard Shape</strong><br>\n";
  products_attributes('bollard_shape');

  echo "<br><strong>Bollard Material</strong><br>\n";
  products_attributes('bollard_material');

  echo "<br><strong>Bollard Finish</strong><br>\n";
  products_attributes('bollard_finish');

  echo "<br><strong>Bollard Type</strong><br>\n";
  products_attributes('bollard_type');

  echo "<br><strong>INGRESS'R Finish</strong><br>\n";
  products_attributes('ingressr_material');

  echo "<br><strong>INGRESS'R Product Group</strong><br>\n";
  products_attributes('ingressr_product_group');

  echo "<br><strong>Switch Style</strong><br>\n";
  products_attributes('switch_style');

  echo "<br><strong>Transmitter/Receiver Type</strong><br>\n";
  products_attributes('tranrec_type');

  echo "<br><strong>Transmitter/Receiver Frequency</strong><br>\n";
  products_attributes('tranrec_frequency');
}

$products_attributes = array(
  array('name' => 'bollard_shape', 'value' => 'Round'),
  array('name' => 'bollard_shape', 'value' => 'Square'),
  array('name' => 'bollard_shape', 'value' => 'Tri/Rect'),
  array('name' => 'bollard_material', 'value' => 'Aluminum'),
  array('name' => 'bollard_material', 'value' => 'Stainless Steel'),
  array('name' => 'bollard_finish', 'value' => 'Clear Anodized'),
  array('name' => 'bollard_finish', 'value' => 'Dark Bronze Anodized'),
  array('name' => 'bollard_finish', 'value' => 'Light Bronze Anodized'),
  array('name' => 'bollard_finish', 'value' => 'Satin Stainless Steel'),
  array('name' => 'bollard_type', 'value' => 'Stock'),
  array('name' => 'bollard_type', 'value' => 'Custom'),
  array('name' => 'ingressr_material', 'value' => 'Aluminum'),
  array('name' => 'ingressr_material', 'value' => 'Stainless Steel'),
  array('name' => 'ingressr_product_group', 'value' => 'I09'),
  array('name' => 'ingressr_product_group', 'value' => 'I24'),
  array('name' => 'ingressr_product_group', 'value' => 'I36'),
  array('name' => 'ingressr_product_group', 'value' => 'I36 NAR'),
  array('name' => 'switch_style', 'value' => 'Round'),
  array('name' => 'switch_style', 'value' => 'Square'),
  array('name' => 'switch_style', 'value' => 'Rectangular (SFA)'),
  array('name' => 'switch_style', 'value' => 'Narrow (AA)'),
  array('name' => 'switch_style', 'value' => 'Key Switch'),
  array('name' => 'switch_style', 'value' => 'Combo'),
  array('name' => 'switch_style', 'value' => 'Touchless'),
  array('name' => 'tranrec_type', 'value' => 'Transmitter'),
  array('name' => 'tranrec_type', 'value' => 'Receiver'),
  array('name' => 'tranrec_frequency', 'value' => '300'),
  array('name' => 'tranrec_frequency', 'value' => '310'),
  array('name' => 'tranrec_frequency', 'value' => '433'),
  array('name' => 'tranrec_frequency', 'value' => '868')
);

$attnames = array_unique(array_map(function ($i) { return $i['name']; }, $products_attributes));

function products_attributes($type) {
  global $post, $products_attributes;

  foreach ($products_attributes as $att) {
    if ($att['name'] == $type) {
      $values = ($post->$type != "") ? explode("|", $post->$type) : array();

      echo '<input type="checkbox" name="'.$att['name'].'[]" value="'.$att['value'].'"';
      if (in_array($att['value'], $values)) echo " checked";
      echo '> '.$att['value']."<br>\n";
    }
  }
}

function products_attributes_frontend($type) {
  global $products_attributes, $attnames;
  
  $i = 1;

  foreach ($products_attributes as $att) {
    if ($att['name'] == $type) {
      echo '<input type="checkbox" name="'.$att['name'].'[]" value="'.$att['value'].'" id="'.$att['name'].$i.'"';

      foreach ($attnames as $attname) {
        if (isset($_REQUEST[$attname]) && in_array($att['value'], $_REQUEST[$attname])) echo " checked";
      }

      echo ' onchange="document.filter.submit()"><label for="'.$att['name'].$i.'">'.$att['value']."</label>\n";

      $i++;
    }
  }
}


add_filter('wp_insert_post_data', 'products_custom_permalink');
function products_custom_permalink($data) {
  if ($data['post_type'] == 'products') {
    $data['post_name'] = sanitize_title($data['post_title']);
  }
  return $data;
}

add_action('save_post', 'products_save');
function products_save($post_id) {
  if (get_post_type() != 'products') return;
  
  if (!empty($_POST['products_part_number'])) {
    update_post_meta($post_id, 'products_part_number', $_POST['products_part_number']);
  } else {
    delete_post_meta($post_id, 'products_part_number');
  }

  if (!empty($_POST['products_spec_sheet'])) {
    update_post_meta($post_id, 'products_spec_sheet', $_POST['products_spec_sheet']);
  } else {
    delete_post_meta($post_id, 'products_spec_sheet');
  }

  if (!empty($_POST['products_models'])) {
    update_post_meta($post_id, 'products_models', $_POST['products_models']);
  } else {
    delete_post_meta($post_id, 'products_models');
  }

  if (!empty($_POST['products_overview'])) {
    update_post_meta($post_id, 'products_overview', $_POST['products_overview']);
  } else {
    delete_post_meta($post_id, 'products_overview');
  }

  if (!empty($_POST['products_options'])) {
    update_post_meta($post_id, 'products_options', $_POST['products_options']);
  } else {
    delete_post_meta($post_id, 'products_options');
  }

  if (!empty($_POST['products_literature'])) {
    update_post_meta($post_id, 'products_literature', $_POST['products_literature']);
  } else {
    delete_post_meta($post_id, 'products_literature');
  }

  if (!empty($_POST['products_custom_tab_text'])) {
    update_post_meta($post_id, 'products_custom_tab_text', $_POST['products_custom_tab_text']);
  } else {
    delete_post_meta($post_id, 'products_custom_tab_text');
  }

  if (!empty($_POST['products_custom_tab'])) {
    update_post_meta($post_id, 'products_custom_tab', $_POST['products_custom_tab']);
  } else {
    delete_post_meta($post_id, 'products_custom_tab');
  }

  if (!empty($_POST['products_mounting'])) {
    update_post_meta($post_id, 'products_mounting', $_POST['products_mounting']);
  } else {
    delete_post_meta($post_id, 'products_mounting');
  }

  $pts = ($_POST['products_title_sort'] == "") ? $_POST['post_title'] : $_POST['products_title_sort'];
  update_post_meta($post_id, 'products_title_sort', $pts);

  global $attnames;
  foreach ($attnames as $attname) {
    $value = ($_POST[$attname] != "") ? implode('|', $_POST[$attname]) : "";

    if (!empty($value)) {
      update_post_meta($post_id, $attname, $value);
    } else {
      delete_post_meta($post_id, $attname);
    }
  }
}

add_action('admin_head', 'products_css');
function products_css() {
  if (get_post_type() == 'products') {
    echo '<style>
      #products_part_number { padding: 3px 8px; font-size: 1.7em; line-height: 100%; height: 1.7em; width: 100%; outline: 0; }
      #products_spec_sheet { width: 87%; padding: 0.32em 8px; box-sizing: border-box; margin: 1.5em 0.75em 1.5em 0; }
      #products_spec_sheet_button { margin: 1.5em 0; }
      #products_mb H3 { margin: 0 0 0.5em; }
      #products_mb .wp-editor-wrap { margin: 1em 0 2em; }
      #products_mb HR { margin: 3em 0 2.5em; border-top: 1px dashed #000000; }
      #filter-by-date { display: none; }
      #products_title_sort, #products_custom_tab_text { width: 100%; padding: 0.32em 8px; box-sizing: border-box; }
      .related-posts-select .chosen-container { min-width: 0; }
    </style>';
  }
}

add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');
function tsm_filter_post_type_by_taxonomy() {
  global $typenow;
  $post_type = 'products'; // change to your post type
  $taxonomy  = 'product-category'; // change to your taxonomy
  if ($typenow == $post_type) {
    $selected      = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
    $info_taxonomy = get_taxonomy($taxonomy);
    wp_dropdown_categories(array(
      'show_option_all' => __("Show All {$info_taxonomy->label}"),
      'taxonomy'        => $taxonomy,
      'name'            => $taxonomy,
      'orderby'         => 'name',
      'selected'        => $selected,
      'show_count'      => true,
      'hide_empty'      => true,
    ));
  };
}

add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query) {
  global $pagenow;
  $post_type = 'products'; // change to your post type
  $taxonomy  = 'product-category'; // change to your taxonomy
  $q_vars    = &$query->query_vars;
  if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type && isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0 ) {
    $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
    $q_vars[$taxonomy] = $term->slug;
  }
}

add_filter('manage_products_posts_columns', 'set_custom_edit_products_columns');
function set_custom_edit_products_columns($columns) {
  unset($columns['title']);
  unset($columns['date']);

  $columns['title'] = "Name";
  $columns['part_number'] = "Part #";
  $columns['product-category'] = "Categories";

  return $columns;
}

add_action('manage_products_posts_custom_column', 'custom_products_column', 10, 2);
function custom_products_column($column, $post_id) {
  switch ($column) {
    case 'part_number':
      echo get_post_meta($post_id, 'products_part_number', true);
      break;
    case 'product-category':
      $terms = get_the_terms($post_id, 'product-category');

      if (!empty( $terms)) {
        $out = array();

        foreach ($terms as $term) {
          $out[] = sprintf('<a href="%s">%s</a>',
            esc_url(add_query_arg(array('post_type' => $post->post_type, 'product-category' => $term->slug), 'edit.php')),
            esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'product-category', 'display'))
          );
        }

        echo join(', ', $out);
      }
      break;
  }
}

add_action('pre_get_posts','products_default_order', 9);
function products_default_order($query){
  if ($query->get('post_type')=='products') {
    $query->set('meta_key','products_title_sort');
    if ($query->get('orderby') == '') $query->set('orderby','meta_value');
    if ($query->get('order') == '') $query->set('order','ASC');
  }
}

add_action('pre_get_posts', 'products_index_order');
function products_index_order($query) {
  if ($query->is_tax('product-category') && $query->is_main_query()) {
    $query->set('meta_key','products_title_sort');
    $query->set('orderby','meta_value');
    $query->set('order', 'ASC');
    $query->set('posts_per_page', 9);
  }
}


// Setting for Attachments plugin
add_filter('attachments_default_instance', '__return_false');
add_action('attachments_register', 'products_gallery');
function products_gallery($attachments) {
  $fields = array(
    array(
      'name' => 'caption',
      'type' => 'textarea',
      'label' => __( 'Caption (HTML allowed)', 'attachments' ),
      'default' => 'caption'
    ),
    array(
      'name' => 'option',
      'type' => 'select',
      'label' => __( 'Make this the index image?', 'attachments' ),
      'meta' => array('options' => array('' => 'Select "Yes"...', 'indeximage' => 'Yes'))
    )
  );

  $args = array(
    'label' => 'Image Gallery',
    'post_type'  => array('products'),
    'filetype' => 'image',
    'button_text'  => __( 'Add Image', 'attachments' ),
    'modal_text'  => __( 'Add Image', 'attachments' ),
    'fields' => $fields
  );

  $attachments->register('products_gallery', $args);
}


/////////
// NEWS
////////
add_action('add_meta_boxes', 'news_mb');
function news_mb() {
  add_meta_box('news_mb_radio', 'News Tabs', 'news_mb_content_radio', 'post', 'side', 'high');
  add_meta_box('news_mb_input', 'Source & Link', 'news_mb_content_input', 'post', 'normal', 'high');
}

function news_mb_content_radio($post) {
  $news_tab = $post->news_tab;
  if ($news_tab == "") $news_tab = "innovations";
  ?>
  <label><input type="radio" name="news_tab" value="innovations" id="ni"<?php if ($news_tab == "innovations") echo " checked"; ?>> Innovations</label><br>
  <label><input type="radio" name="news_tab" value="news" id="nn"<?php if ($news_tab == "news") echo " checked"; ?>> News</label>

  <script>
    jQuery(function($) {
      if ($('#ni').is(':checked')) {
        $('#news_mb_input').hide();
        $('#wp-content-wrap, #post-status-info, #postimagediv, #attachments-posts_gallery').show();
        $('#tagsdiv-post_tag').hide();
        $('#in-category-1').prop('checked', true);
      } else {
        $('#news_mb_input').show();
        $('#wp-content-wrap, #post-status-info, #tagsdiv-post_tag, #postimagediv, #attachments-posts_gallery').hide();
        $('#in-category-20').prop('checked', true);
      }

      $('input[type=radio]').change(function(){
        if (this.value == 'innovations') {
          $('#news_mb_input').hide();
          $('#wp-content-wrap, #post-status-info, #postimagediv, #attachments-posts_gallery').show();
          $('#tagsdiv-post_tag').hide();
          $('#in-category-20').prop('checked', false);
          $('#in-category-1').prop('checked', true);
          $('#news_source, #news_link').val('');
        } else {
          $('#news_mb_input').show();
          $('#wp-content-wrap, #post-status-info, #tagsdiv-post_tag, #postimagediv, #attachments-posts_gallery').hide();
          $('#in-category-20').prop('checked', true);
          $('#in-category-1').prop('checked', false);
        }
      });
    });
  </script>
  <?php
}

function news_mb_content_input($post) {
  ?>
  <input type="text" name="news_source" id="news_source" placeholder="Source" value="<?php if ($post->news_source != "") echo $post->news_source; ?>">
  <input type="text" name="news_link" id="news_link" placeholder="Link" value="<?php if ($post->news_link != "") echo $post->news_link; ?>">
  <?php
}

add_action('admin_head', 'news_css');
function news_css() {
  if (get_post_type() == 'post') {
    echo '<style>
      #news_mb_input INPUT[type="text"] { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
      #news_mb_input LABEL { margin-right: 1em; }
      .attachment-field-posts_gallery TEXTAREA { height: 80px !important; }
    </style>';
  }
}

add_action('save_post', 'news_save');
function news_save($post_id) {
  if (get_post_type() == 'post') {
    update_post_meta($post_id, 'news_tab', $_POST['news_tab']);

    if (!empty($_POST['news_source'])) {
      update_post_meta($post_id, 'news_source', $_POST['news_source']);
    } else {
      delete_post_meta($post_id, 'news_source');
    }

    if (!empty($_POST['news_link'])) {
      update_post_meta($post_id, 'news_link', $_POST['news_link']);
    } else {
      delete_post_meta($post_id, 'news_link');
    }
  }
}

add_action('attachments_register', 'posts_gallery');
function posts_gallery($attachments) {
  $fields = array(
    array(
      'name' => 'caption',
      'type' => 'textarea',
      'label' => __( 'Caption (HTML allowed)', 'attachments' ),
      'default' => 'caption'
    )
  );

  $args = array(
    'label' => 'Image Gallery',
    'post_type'  => array('post'),
    'filetype' => 'image',
    'button_text'  => __( 'Add Image', 'attachments' ),
    'modal_text'  => __( 'Add Image', 'attachments' ),
    'fields' => $fields
  );

  $attachments->register('posts_gallery', $args);
}



add_action('wp_ajax_get_products_by_ajax', 'get_products_by_ajax_callback');
add_action('wp_ajax_nopriv_get_products_by_ajax', 'get_products_by_ajax_callback');
function get_products_by_ajax_callback() {
  echo '<option value="">Select...</option>';

  $prodcats = new WP_Query(array('post_type' => 'products', 'posts_per_page' => -1, 'tax_query' => array(array('taxonomy' => 'product-category', 'field' => 'slug', 'terms' => $_POST['prodcat']))));

  if ($prodcats->have_posts()) {
    while ($prodcats->have_posts()) {
      $prodcats->the_post();
      echo '<option value="'.get_the_title().'">'.get_the_title()."</option>\n";
    }
    wp_reset_postdata();
  }

  wp_die();
}


///////////////
// GALLERY
///////////////
add_action('init', 'gallery');
function gallery() {
  register_post_type('gallery', array(
      'labels' => array(
        'name' => 'Gallery',
        'singular_name' => 'Gallery',
        'add_new_item' => 'Add New Gallery',
        'edit_item' => 'Edit Gallery',
        'search_items' => 'Search Galleries',
        'not_found' => 'No Galleries found'
      ),
      'show_ui' => true,
      'menu_position' => 53,
      'menu_icon' => 'dashicons-camera',
      'supports' => array('title','editor'),
      'has_archive' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'show_in_nav_menus' => true
  ));
}

add_action('attachments_register', 'gallery_gallery');
function gallery_gallery($attachments) {
  $fields = array(
    array(
      'name' => 'caption',
      'type' => 'textarea',
      'label' => __( 'Caption (HTML allowed)', 'attachments' ),
      'default' => 'caption'
    )
  );

  $args = array(
    'label' => 'Images',
    'post_type'  => array('gallery'),
    'filetype' => 'image',
    'button_text'  => __( 'Add Image', 'attachments' ),
    'modal_text'  => __( 'Add Image', 'attachments' ),
    'fields' => $fields
  );

  $attachments->register('gallery_gallery', $args);
}

add_action('admin_head', 'gallery_css');
function gallery_css() {
  if (get_post_type() == 'gallery') {
    echo '<style>
      #content_ifr, .wp-editor-area,
      .attachment-field-gallery_gallery TEXTAREA { height: 80px !important; }
    </style>';
  }
}

add_filter('manage_gallery_posts_columns', 'set_custom_edit_gallery_columns');
function set_custom_edit_gallery_columns($columns) {
  unset($columns['date']);

  return $columns;
}


/////////////////
// TESTIMONIALS
/////////////////
add_action('init', 'testimonials');
function testimonials() {
  register_post_type('testimonials', array(
      'labels' => array(
        'name' => 'Testimonials',
        'singular_name' => 'Testimonial',
        'add_new_item' => 'Add New Testimonial',
        'edit_item' => 'Edit Testimonial',
        'search_items' => 'Search Testimonials',
        'not_found' => 'No Testimonials found'
      ),
      'show_ui' => true,
      'menu_position' => 55,
      'menu_icon' => 'dashicons-testimonial',
      'supports' => array('title', 'editor')
  ));
}

add_filter('enter_title_here', 'testimonials_title');
function testimonials_title($input) {
  if (get_post_type() === 'testimonials') return "Enter person's name here";
  return $input;
}

add_filter('wp_insert_post_data', 'testimonials_custom_permalink');
function testimonials_custom_permalink($data) {
  if ($data['post_type'] == 'testimonials') {
    $data['post_name'] = sanitize_title($data['post_title']);
  }
  return $data;
}

// Place fields after the title
add_action('edit_form_after_title', 'testimonials_after_title');
function testimonials_after_title($post) {
  if (get_post_type() == 'testimonials') {
    echo '<input type="text" name="testimonials_persons_t" placeholder="Enter person\'s title here (optional)" value="';
    if ($post->testimonials_persons_t != "") echo $post->testimonials_persons_t;
    echo '" id="testimonials_persons_title">';
  }
}

add_action('admin_head', 'testimonials_css');
function testimonials_css() {
  if (get_post_type() == 'testimonials') {
    echo '<style>
      #testimonials_persons_title { padding: 3px 8px; font-size: 1.7em; line-height: 100%; height: 1.7em; width: 100%; outline: 0; }
    </style>';
  }
}

add_action('save_post', 'testimonials_save');
function testimonials_save($post_id) {
  if (get_post_type() != 'testimonials') return;
  
  if (!empty($_POST['testimonials_persons_t'])) {
    update_post_meta($post_id, 'testimonials_persons_t', $_POST['testimonials_persons_t']);
  } else {
    delete_post_meta($post_id, 'testimonials_persons_t');
  }
}

add_filter('manage_testimonials_posts_columns', 'set_custom_edit_testimonials_columns');
function set_custom_edit_testimonials_columns($columns) {
  unset($columns['title']);
  unset($columns['date']);

  $columns['title'] = "Person's Name";
  $columns['testimonials_persons_t'] = "Person's Title";
  $columns['post_excerpt'] = "Testimonial";

  return $columns;
}

add_action('manage_testimonials_posts_custom_column', 'custom_testimonials_column', 10, 2);
function custom_testimonials_column($column, $post_id) {
  switch ($column) {
    case 'testimonials_persons_t':
      echo get_post_meta($post_id, 'testimonials_persons_t', true);
      break;
    case 'post_excerpt':
      the_excerpt();
      break;
  }
}

add_filter('manage_edit-testimonials_sortable_columns', 'custom_testimonials_sortable_columns' );
function custom_testimonials_sortable_columns($column) {
  unset($column['title']);
  return $column;
}

add_action('admin_head', 'admin_css');
function admin_css() {
  echo '<style>
    .widefat { width: 96%; box-sizing: border-box; }
    .post-type-testimonials #post_excerpt { width: 50%; }
  </style>';
}

add_shortcode('testimonials','get_testimonials');
function get_testimonials() {
  ob_start();

  global $post;

  $testimonials = new WP_Query(array('post_type'=>'testimonials', 'orderby'=>'menu_order', 'order'=> 'ASC', 'showposts' => -1));
  if ($testimonials->have_posts()) :
  ?>
    <div id="testimonials">
      <div class="site-width">
        <div class="sideheader"><h1>Testimonials</h1></div>

        <div id="slides">
          <img src="<?php echo get_template_directory_uri(); ?>/images/paren-left.svg" alt="" id="pl">
          <img src="<?php echo get_template_directory_uri(); ?>/images/paren-right.svg" alt="" id="pr">
          
          <?php
          while($testimonials->have_posts()) : $testimonials->the_post();
            echo '<div>"'.get_the_content().'"<br><br><span>- '.get_the_title();
              if ($post->testimonials_persons_t != "") echo ',';
              echo '</span>';
              if ($post->testimonials_persons_t != "") echo ' '.$post->testimonials_persons_t;
            echo '</div>';
          endwhile;
          ?>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      $(document).ready(function() {
        var ParenTime = 1500;
        var FadeTime = 1000;
        var DelayTime = 10000;
        var CrossFade = 500;
        var TotalTime = (ParenTime*2) + (FadeTime*2) + DelayTime - (CrossFade*2);
        var slideIndex = 0;

        function SlideShow() {
          $("#slides DIV").css("display", "none");
          slideIndex++;
          if (slideIndex > $("#slides DIV").length) slideIndex = 1;

          $("#pl").animate({ left: "0" }, ParenTime);
          $("#pr").animate({ left: $('#slides').width() - $('#pr').width() }, ParenTime);

          setTimeout(function() {
          $('#slides DIV:nth-of-type('+slideIndex+')').css("display", "block")
            .animate({ opacity: 1 }, FadeTime)
            .delay(DelayTime)
            .animate({ opacity: 0 }, FadeTime);
          }, ParenTime - CrossFade);

          setTimeout(function() {
            $("#pl").animate({ left: ($('#slides').width()*0.48) - $('#pl').width() }, ParenTime);
            $("#pr").animate({ left: "52%" }, ParenTime);
          }, DelayTime + (FadeTime*2));

          setTimeout(SlideShow, TotalTime);
        }

        SlideShow();
      });
    </script>
  <?php
  endif;

  wp_reset_query();
  return ob_get_clean();
}



add_shortcode('map','get_map');
function get_map() {
  ob_start();
  ?>

  <div id="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5842.319313033677!2d-87.9992533677441!3d42.93276092758381!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x880511f28b528109%3A0xbf954d848b9bd3d7!2sWikk+Industries+Inc!5e0!3m2!1sen!2sus!4v1545838851361" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>

    <div id="map-text">
      <div>
        <h1>Wikk Industries, Inc.</h1>
        6169A Industrial Ct.<br>
        Greendale, WI 53129<br>
        <br>

        <h2>Phone: 414-421-9490</h2>
        <h2>Toll-Free: 877-421-9490</h2>
      </div>
    </div>
  </div>

  <?php
  return ob_get_clean();
}


/////////////
// PRO AREA
/////////////
add_action('init', 'pro');
function pro() {
  register_post_type('pro', array(
      'labels' => array(
        'name' => 'Pro Area',
        'singular_name' => 'Item',
        'add_new_item' => 'Add New Item',
        'edit_item' => 'Edit Item',
        'search_items' => 'Search Items',
        'not_found' => 'No Items found'
      ),
      'show_ui' => false,
      'menu_position' => 56,
      'menu_icon' => 'dashicons-download',
      'supports' => array('title'),
      'taxonomies' => array('pro-category'),
      'has_archive' => true,
      'exclude_from_search' => false,
      'publicly_queryable' => true,
      'show_in_nav_menus' => true
  ));
}

add_action('init', 'pro_create_taxonomy');
function pro_create_taxonomy() {
  register_taxonomy('pro-category', 'pro', array('labels' => array('name' => 'Pro Area Categories', 'singular_name' => 'Pro Area Category'), 'hierarchical' => true));
}


/////////////////////
// FORM SUBMISSIONS
/////////////////////
if (!class_exists('WP_List_Table')) require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class Form_Submissions_List_Table extends WP_List_Table {
  function __construct() {
    global $status, $page;
            
    //Set parent defaults
    parent::__construct( array(
      'singular' => 'form_submission',  //singular name of the listed records
      'plural'   => 'form_submissions', //plural name of the listed records
      'ajax'     => false               //does this table support ajax?
    ));
  }

  function column_default($item, $column_name){
    switch($column_name){
      case 'firstname':
      case 'lastname':
      case 'company':
      case 'email':
      case 'phone':
      case 'address':
      case 'address2':
      case 'city':
      case 'state':
      case 'zip':
      case 'country':
      case 'what_form':
        return $item[$column_name];
      case 'sendupdates':
        return ($item[$column_name] != "") ? "Yes" : "No";
      case 'date_submitted':
        return date("n/j/y g:ia", $item[$column_name]);
      default:
        return print_r($item,true); //Show the whole array for troubleshooting purposes
    }
  }
  
  // Required for bulk actions checkbox
  function column_cb($item){
    return '<input type="checkbox" name="fsb[]" value="'.$item['id'].'" />';
  }

  function get_columns(){
    $columns = array(
      'cb' => '<input type="checkbox" />',
      'firstname' => 'First Name',
      'lastname' => 'Last Name',
      'company' => 'Company',
      'email' => 'Email',
      'phone' => 'Phone',
      'address' => 'Address',
      'address2' => 'Address 2',
      'city' => 'City',
      'state' => 'State',
      'zip' => 'Zip',
      'country' => 'Country',
      'sendupdates' => 'Send Updates',
      'what_form' => 'What Form',
      'date_submitted' => 'Date'
    );
    return $columns;
  }

  function get_sortable_columns() {
    $sortable_columns = array(
      'firstname' => array('firstname',true),
      'lastname' => array('lastname',true),
      'company' => array('company',true),
      'email' => array('email',true),
      'phone' => array('phone',true),
      'address' => array('address',true),
      'address2' => array('address2',true),
      'city' => array('city',true),
      'state' => array('state',true),
      'zip' => array('zip',true),
      'country' => array('country',true),
      'sendupdates' => array('sendupdates',true),
      'what_form' => array('what_form',true),
      'date_submitted' => array('date_submitted',true)
    );
    return $sortable_columns;
  }

  function get_bulk_actions() {
    $actions = array(
      'delete' => 'Delete'
    );
    return $actions;
  }

  function process_bulk_action() {
    global $wpdb;

    //Detect when a bulk action is being triggered...
    if('delete'===$this->current_action()) {
      foreach ($_GET['fsb'] as $id) {
        $wpdb->delete("form_submissions", ['id' => $id], ['%d']);
      }
    }
  }

  function prepare_items() {
    global $wpdb;

    // Define column headers and build an array
    $columns = $this->get_columns();
    $hidden = array();
    $sortable = $this->get_sortable_columns();

    $this->_column_headers = array($columns, $hidden, $sortable);
    
    // Handle bulk actions
    $this->process_bulk_action();
    
    // Get the data from the database
    $data = $wpdb->get_results("SELECT * FROM form_submissions", ARRAY_A);

    // Sort columns
    function usort_reorder($a,$b){
      $orderby = (!empty($_REQUEST['orderby'])) ? $_REQUEST['orderby'] : 'date_submitted';
      $order = (!empty($_REQUEST['order'])) ? $_REQUEST['order'] : 'desc';
      $result = strcmp($a[$orderby], $b[$orderby]);
      return ($order==='asc') ? $result : -$result;
    }
    usort($data, 'usort_reorder');
    
    /*
    *  The remainder of this subfunction deals with pagination
    */
    // How many records per page to display
    $per_page = 100;

    $current_page = $this->get_pagenum();

    $total_items = count($data);

    $data = array_slice($data,(($current_page-1)*$per_page),$per_page);

    $this->items = $data;

    $this->set_pagination_args(array(
      'total_items' => $total_items,                //WE have to calculate the total number of items
      'per_page'    => $per_page,                   //WE have to determine how many items to show on a page
      'total_pages' => ceil($total_items/$per_page) //WE have to calculate the total number of pages
    ));
  }
}

function form_submissions_add_menu_items(){
  add_menu_page('Form Submissions', 'Form Submissions', 'activate_plugins', 'form_submissions', 'form_submissions_page', 'dashicons-clipboard', 55);
}
add_action('admin_menu', 'form_submissions_add_menu_items');

function form_submissions_page(){
  date_default_timezone_set('America/Chicago');

  //Create an instance of our package class...
  $FSListTable = new Form_Submissions_List_Table();

  //Fetch, prepare, sort, and filter our data...
  $FSListTable->prepare_items();

  echo '<style>
    .form_submissions TH { font-size: 10px; font-weight: bold; }
    .form_submissions TD { font-size: 10px; }
  </style>';

  echo '<div class="wrap">';
    echo '<h2>Form Submissions</h2>';

    echo '<a href="'.admin_url('admin-ajax.php?action=fs_export').'" class="button">Export List to CSV</a>';

    echo '<form id="form_submissions-filter" method="get">';
      echo '<input type="hidden" name="page" value="'. $_REQUEST['page'] . '" />';
      $FSListTable->display();
    echo '</form>';

    echo '<a href="'.admin_url('admin-ajax.php?action=fs_export').'" class="button">Export List to CSV</a>';
  echo '</div>';
}

function export_form_submissions() {
  date_default_timezone_set('America/Chicago');
  
  global $wpdb;

  $results = $wpdb->get_results("SELECT * FROM form_submissions ORDER BY date_submitted DESC", ARRAY_A );

  $headers = "First Name, Last Name, Company, Email, Phone, Address, Address 2, City, State, Zip, Country, Send Updates, What Form, Date";

  if (count($results) > 0) {
    $output = "";

    foreach($results as $result) {
      $output .= '"'.$result['firstname'].'",';
      $output .= '"'.$result['lastname'].'",';
      $output .= '"'.$result['company'].'",';
      $output .= '"'.$result['email'].'",';
      $output .= '"'.$result['phone'].'",';
      $output .= '"'.$result['address'].'",';
      $output .= '"'.$result['address2'].'",';
      $output .= '"'.$result['city'].'",';
      $output .= '"'.$result['state'].'",';
      $output .= '"'.$result['zip'].'",';
      $output .= '"'.$result['country'].'",';
      $output .= '"'.$result['sendupdates'].'",';
      $output .= '"'.$result['what_form'].'",';
      $output .= '"'.date("n/j/y g:ia", $result['date_submitted']).'"';
      $output .= "\n";
    }
  }

  header("Content-type: application/vnd.ms-excel");
  header("Content-disposition: filename=form_submissions_".date("Y-m-d_H-i",time()).".csv");
  print $headers."\n".$output;
  exit;
}
add_action('wp_ajax_fs_export','export_form_submissions');


/////////////////
// PARTNERS
/////////////////
add_action('init', 'partners');
function partners() {
  register_post_type('partners', array(
      'labels' => array(
        'name' => 'Partners',
        'singular_name' => 'Partner',
        'add_new_item' => 'Add New Partner',
        'edit_item' => 'Edit Partner',
        'search_items' => 'Search Partners',
        'not_found' => 'No Partners found'
      ),
      'show_ui' => true,
      'menu_position' => 55,
      'menu_icon' => 'dashicons-groups',
      'supports' => array('title', 'editor', 'thumbnail')
  ));
}

add_action('add_meta_boxes', 'partners_mb');
function partners_mb() {
  add_meta_box('partners_mb', 'Partner Link', 'partners_mb_content', 'partners', 'normal');
}

function partners_mb_content($post) {
  ?>
  <input type="text" name="partners_link" id="partners_link" placeholder="Link" value="<?php if ($post->partners_link != "") echo $post->partners_link; ?>">
  <?php
}

add_action('admin_head', 'partners_css');
function partners_css() {
  if (get_post_type() == 'partners') {
    echo '<style>
      #partners_mb INPUT[type="text"] { width: 100%; margin: 0.5em 0; padding: 0.32em 8px; box-sizing: border-box; }
      #set-post-thumbnail-desc ~ STRONG, #set-post-thumbnail-desc ~ STRONG + BR, INPUT[name="featured_image_caption"] { display: none; }
    </style>';
  }
}

add_action('save_post', 'partners_save');
function partners_save($post_id) {
  if (get_post_type() != 'partners') return;
  
  if (!empty($_POST['partners_link'])) {
    update_post_meta($post_id, 'partners_link', $_POST['partners_link']);
  } else {
    delete_post_meta($post_id, 'partners_link');
  }
}

add_filter('manage_partners_posts_columns', 'set_custom_edit_partners_columns');
function set_custom_edit_partners_columns($columns) {
  unset($columns['date']);

  $columns['post_excerpt'] = "Description";

  return $columns;
}

add_action('manage_partners_posts_custom_column', 'custom_partners_column', 10, 2);
function custom_partners_column($column, $post_id) {
  switch ($column) {
    case 'post_excerpt':
      the_excerpt();
      break;
  }
}

add_filter('manage_edit-partners_sortable_columns', 'custom_partners_sortable_columns' );
function custom_partners_sortable_columns($column) {
  unset($column['title']);
  return $column;
}
?>