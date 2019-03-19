<?php
session_start();
get_header();
?>

<div class="site-width proarea">
  <h1 class="news-title">Pro Area</h1>
  
  <div class="proheader-text">
    <strong>Wikk's Pro Area</strong> is a digital hub for <strong>useful, in-depth tools for industry professionals.</strong> From product specs, architect resources, instructional material, to CAD drawings and video tutorials, Wikk strives to provide a wealth of industry knowledge. New content is always being added, so check back soon!
  </div>

  <div class="pro">
    <div class="pro-sidebar">
      <h3>Wikk 2019 Pricing Catalog</h3>

      <div class="catalog-image-wrap">
        <div class="catalog-image" style="background-image: url(http://wikk.com/wp-content/uploads/2019/01/pricing-catalog.png);"></div>
      </div>

      <a href="http://wikk.com/wp-content/uploads/2019/01/Wikk_Industries_2019_Pricing_Catalog.pdf" class="button">View PDF <i class="far fa-file-pdf"></i></a>
    </div>

    <div class="pro-content">
      <?php
      function ListPDFs($array) {
        $_SESSION[$array['slug']] = $array['files'];
        $_SESSION[$array['slug'].'_name'] = preg_replace("/[\s]/", "-", $array['name']);

        $i = 0;

        foreach ($array['files'] as $key => $value) {
          echo '<tr><td class="ps-col1">';
          echo '<a href="'.$value.'"><i class="far fa-file-pdf"></i> '.$key.'</a>';
          echo '</td><td class="ps-col2">';
          echo '<a href="'.$value.'" download="'.basename($value).'"><i class="fas fa-download"></i> Download</a>';
          echo '</td></tr>';

          $i++;
        }

        if ($i > 1 && class_exists('ZipArchive')) echo '<tr><td colspan="2" class="ps-da"><a href="'.get_template_directory_uri().'/download-zip.php?f='.$array['slug'].'"><i class="fas fa-download"></i> Download All</a></td></tr>';
      }
      ?>

      <h2>Customer Resources</h2>
      
      <div class="pro-subcat-wrap">
        <input type="checkbox" id="toggle-sc-instruction-sheets" role="button">
        <label for="toggle-sc-instruction-sheets">Resources</label>
        <table class="pro-subcat">
          <thead>
            <tr><td class="pro-subcat-name" colspan="2">Instruction Sheets</td></tr>
          </thead>
          <tbody>
            <?php
            $instructionsheets = array('name' => 'Instruction Sheets', 'slug' => 'instruction-sheets',
              'files' => array(
                "9\" INGRESS'R" =>
                content_url()."/uploads/2019/03/9_Inch_INGRESSR_Mounting_Instructions.pdf",
                "24\" INGRESS'R" =>
                content_url()."/uploads/2019/03/24_Inch_INGRESSR_Mounting_Instructions.pdf",
                "36\" INGRESS'R" =>
                content_url()."/uploads/2019/03/36_Inch_INGRESSR_Mounting_Instructions.pdf",
                "36\" Narrow INGRESS'R" =>
                content_url()."/uploads/2019/03/36_Inch_Narrow_INGRESSR_Mounting_Instructions.pdf",
                "42\" INGRESS'R" =>
                content_url()."/uploads/2019/03/42_Inch_INGRESSR_Mounting_Instructions.pdf",
                "N4RF / N6RF" =>
                content_url()."/uploads/2019/03/N4RF_N6RF_Installation_Instructions.pdf",
                "N4RS-F / N6RS-F" =>
                content_url()."/uploads/2019/03/N4RS_F_N6RS_F_Installation_Instructions.pdf",
                "N4X4SDG" =>
                content_url()."/uploads/2019/03/N4X4SDG_Installation_Instructions.pdf",
                "SURF 6R" =>
                content_url()."/uploads/2019/03/SURF_6R_Installation_Instructions.pdf",
                "SURF SQ 4 & 6 BLK" =>
                content_url()."/uploads/2019/03/SURF_SQ_4__6_BLK_Installation_Instructions.pdf",
                "Wikk Touchless Switch" =>
                content_url()."/uploads/2019/03/Wikk_Touchless_Switch_Installation_Instructions.pdf",
              )
            );

            ListPDFs($instructionsheets);
            ?>
          </tbody>
        </table>
      </div>
      
      <div class="pro-subcat-wrap">
        <input type="checkbox" id="toggle-sc-short-form-bollard-specs" role="button">
        <label for="toggle-sc-short-form-bollard-specs">Resources</label>
        <table class="pro-subcat">
          <thead>
            <tr><td class="pro-subcat-name" colspan="2">Short Form Bollard Specs</td></tr>
          </thead>
          <tbody>
            <?php
            $shortformbollardspecs = array('name' => 'Short Form Bollard Specs', 'slug' => 'short-form-bollard-specs',
              'files' => array(
                'Round Aluminum' =>
                content_url().'/uploads/2019/03/Bollard_Round_Aluminum_Short_Spec_Sheet.pdf',
                'Round Stainless Steel' =>
                content_url().'/uploads/2019/03/Bollard_Round_Stainless_Steel_Short_Spec_Sheet.pdf',
                'Square Aluminum' =>
                content_url().'/uploads/2019/03/Bollard_Square_Aluminum_Short_Spec_Sheet.pdf',
                'Square Stainless Steel' =>
                content_url().'/uploads/2019/03/Bollard_Square_Stainless_Steel_Short_Spec_Sheet.pdf'
              )
            );

            ListPDFs($shortformbollardspecs);
            ?>
          </tbody>
        </table>
      </div>
    </div> <!-- .procontent -->
  </div> <!-- .pro -->
</div> <!-- .proarea -->

<?php
global $FooterTextClass;
$FooterTextClass = "prefooter-hide";

get_footer();
?>