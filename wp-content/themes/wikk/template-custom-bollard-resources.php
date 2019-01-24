<?php
/* Template Name: Custom Bollard Resources */

session_start();
get_header();
?>

<div class="site-width page-content">
  <?php
  if ( have_posts() ) :
  	while ( have_posts() ) : the_post();
      the_title('<h1 class="page-title">', '</h1>');
  		the_content();
  	endwhile;
  endif;

  $square = array('name' => 'Square Bollards', 'slug' => 'square',
    'files' => array(
      'http://localhost:8888/Wikk-wordpress/wp-content/uploads/2019/01/Available_Logos.pdf',
      'http://localhost:8888/Wikk-wordpress/wp-content/uploads/2018/10/Bollard_RD4_Spec_Sheet.pdf'
    )
  );
  $square_name = "Square Bollards";
  
  $_SESSION['square'] = $square;
  $_SESSION['square_name'] = "Square-Bollards";

  $round = array('name' => 'Round Bollards', 'slug' => 'round',
    'files' => array(
      'http://localhost:8888/Wikk-wordpress/wp-content/uploads/2019/01/Available_Logos.pdf',
      'http://localhost:8888/Wikk-wordpress/wp-content/uploads/2019/01/2014-Catalog.pdf'
    )
  );
  $round_name = "Round Bollards";
  
  $_SESSION['round'] = $round;
  $_SESSION['round_name'] = "Round-Bollards";

  $arrays = array($square, $round);
  foreach ($arrays as $array) {
    echo count($array['files'])."<br>";
    echo $array['name']."<br>";
    foreach ($array['files'] as $file) {
      echo $file."<br>";
    }
  }
  ?>
  <a href="http://localhost:8888/Wikk-wordpress/wp-content/themes/wikk/download-zip.php?f=square">DOWNLOAD</a>
</div>

<?php
$FooterText = 'Have other questions? <span style="color: #F0532D;">Call 877-421-9490</span> or';
$ButtonURL = "/contact/";
$ButtonText = "Contact Us";
get_footer();
?>