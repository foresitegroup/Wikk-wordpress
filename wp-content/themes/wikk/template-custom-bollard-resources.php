<?php
/* Template Name: Custom Bollard Resources */

session_start();
get_header();
?>

<div class="site-width page-content">
  <?php
  if (have_posts()) :
  	while (have_posts()) : the_post();
      the_title('<h1 class="news-title">', '</h1>');
  	endwhile;
  endif;
  ?>

  Wikk Industries stands as an industry pioneer in providing custom bollard solutions to our clients. With almost every aspect of our bollards being customizable, we aim to provide the most personal and effective solution to each of our clients. To get started with a custom bollard order, utilize the resources below, then contact us via our <a href="<?php home_url(); ?>/request-for-quote/?bollard">Custom Bollard Request</a> form, or hop on the phone with one of our customer representatives at <a href="tel:877-421-9490">877-421-9490</a>.<br>
  <br>

  <h2 class="cbr-h2">PDF Resources</h2>

  <?php
  $resources = new WP_Query(array('post_type' => 'cbr', 'showposts' => -1));

  while($resources->have_posts()) : $resources->the_post();
    $cbr = get_post_meta($post->ID, 'cbr', true);

    if (isset($cbr['pdf_title'])) {
      $_SESSION['cbr'.$post->ID] = $cbr;
      $_SESSION['cbr'.$post->ID.'_name'] = preg_replace("/[\s]/", "-", get_the_title());

      echo '<table class="cbr-table">';

      for($i = 0; $i < count($cbr['pdf_title']); $i++) {
        echo '<tr><td class="cbr-col1">';
        if ($i == 0) echo get_the_title();
        echo '</td><td class="cbr-col2">';
        echo '<a href="'.$cbr['pdf_file'][$i].'"><i class="far fa-file-pdf"></i> '.$cbr['pdf_title'][$i].'</a>';
        echo '</td><td class="cbr-col3">';
        echo '<a href="'.$cbr['pdf_file'][$i].'" download="'.basename($cbr['pdf_file'][$i]).'"><i class="fas fa-download"></i> Download</a>';
        echo "</td></tr>";
      }

      // if ($i > 1 && class_exists('ZipArchive')) echo '<tr><td colspan="3" class="cbr-da"><a href="'.get_template_directory_uri().'/dlzip.php?f=cbr'.$post->ID.'"><i class="fas fa-download"></i> Download All</a></td></tr>';

      echo "</table>";
    }
  endwhile;
  ?>
</div>

<?php
$FooterText = 'Have other questions? <span style="color: #F0532D;">Call 877-421-9490</span> or';
$ButtonURL = "/contact/";
$ButtonText = "Contact Us";
get_footer();
?>