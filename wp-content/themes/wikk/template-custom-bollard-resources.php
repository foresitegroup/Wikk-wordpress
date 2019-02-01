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

  Wikk&reg; Industries stands as an industry pioneer in providing custom bollard solutions to our clients. With almost every aspect of our bollards being customizable, we aim to provide the most personal and effective solution to each of our clients. To get started with a custom bollard order, utilize the resources below, then contact us via our <a href="<?php home_url(); ?>/request-for-quote/?bollard">Custom Bollard Request</a> form, or hop on the phone with one of our customer representatives at <a href="tel:877-421-9490">877-421-9490</a>.<br>
  <br>

  <h2 class="cbr-h2">PDF Resources</h2>

  <?php
  $square = array('name' => 'Square Bollards', 'slug' => 'square',
    'files' => array(
      'Square Bollard Checklist' =>
      content_url().'/uploads/2019/01/Square_Bollard_Checklist.pdf',
      'Square Bollard Examples' =>
      content_url().'/uploads/2019/01/Square_Bollard_Examples.pdf',
      'High Low Switch Examples' =>
      content_url().'/uploads/2019/01/High_Low_Switch_Examples.pdf'
    )
  );

  $round = array('name' => 'Round Bollards', 'slug' => 'round',
    'files' => array(
      'Round Bollard Checklist' =>
      content_url().'/uploads/2019/01/Round_Bollard_Checklist.pdf',
      'Round Bollard Examples' =>
      content_url().'/uploads/2019/01/Round_Bollard_Examples.pdf',
      'High Low Switch Examples' =>
      content_url().'/uploads/2019/01/High_Low_Switch_Examples.pdf'
    )
  );

  $rectangular = array('name' => 'Rectangular Bollards', 'slug' => 'rectangular',
    'files' => array(
      'Rectangular Bollard Checklist' =>
      content_url().'/uploads/2019/01/Rectangular_Bollard_Checklist.pdf',
      'Rectangular Bollard Examples' =>
      content_url().'/uploads/2019/01/Rectangular_Bollard_Examples.pdf',
      'High Low Switch Examples' =>
      content_url().'/uploads/2019/01/High_Low_Switch_Examples.pdf'
    )
  );

  $triangular = array('name' => 'Triangular Bollards', 'slug' => 'triangular',
    'files' => array(
      'Triangular Bollard Checklist' =>
      content_url().'/uploads/2019/01/Triangular_Bollard_Checklist.pdf'
    )
  );

  $colors = array('name' => 'Special Colors & Finishes', 'slug' => 'colors',
    'files' => array(
      'Powdercoating for Exterior and Interior' =>
      content_url().'/uploads/2019/01/Powdercoating_for_Exterior_and_Interior.pdf',
      'Super Durable Powdercoating Colors' =>
      content_url().'/uploads/2019/01/Super_Durable_Powdercoating_Colors.pdf',
      'Anodized Finish' =>
      content_url().'/uploads/2019/01/Anodized_Finish.pdf'
    )
  );

  $arrays = array($square, $round, $rectangular, $triangular, $colors);

  foreach ($arrays as $array) {
    $_SESSION[$array['slug']] = $array['files'];
    $_SESSION[$array['slug'].'_name'] = preg_replace("/[\s]/", "-", $array['name']);

    $i = 1;

    echo '<table class="cbr-table">';

    foreach ($array['files'] as $key => $value) {
      echo '<tr><td class="cbr-col1">';
      if ($i == 1) echo $array['name'];
      echo '</td><td class="cbr-col2">';
      echo '<a href="'.$value.'"><i class="far fa-file-pdf"></i> '.$key.'</a>';
      echo '</td><td class="cbr-col3">';
      echo '<a href="'.get_template_directory_uri().'/download.php?f='.$value.'"><i class="fas fa-download"></i> Download</a>';
      echo "</td></tr>";

      $i++;
    }
    
    if ($i > 2) echo '<tr><td colspan="3" class="cbr-da"><a href="'.get_template_directory_uri().'/download-zip.php?f='.$array['slug'].'"><i class="fas fa-download"></i> Download All</a></td></tr>';

    echo "</table>";
  }
  ?>
</div>

<?php
$FooterText = 'Have other questions? <span style="color: #F0532D;">Call 877-421-9490</span> or';
$ButtonURL = "/contact/";
$ButtonText = "Contact Us";
get_footer();
?>