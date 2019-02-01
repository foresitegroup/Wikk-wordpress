  <div class="site-width prefooter<?php global $FooterTextClass; if (isset($FooterTextClass)) echo " ".$FooterTextClass; ?>">
    <?php
    global $FooterText, $ButtonURL, $ButtonText;
    echo (isset($FooterText)) ? $FooterText : "Ready to Request a Quote?";
    $ButtonURL = (isset($ButtonURL)) ? $ButtonURL : "/request-for-quote/";
    $ButtonText = (isset($ButtonText)) ? $ButtonText : "Request a Quote Here";
    ?>
    <a href="<?php echo home_url() . $ButtonURL; ?>" class="button"><?php echo $ButtonText; ?></a>
  </div>
  
  <?php global $ShowCBR; if (isset($ShowCBR)) { ?>
  <div id="cbr-banner">
    <div class="site-width">
      <div class="image">
        <img src="<?php echo get_template_directory_uri(); ?>/images/cbr.png" alt="">
      </div>

      <div class="text">
        <h2>Custom Bollard Resources</h2>

        Wikk&reg; Industries stands as an industry pioneer in providing custom bollard solutions to our clients. With almost every aspect of our bollards being customizable, we aim to provide the most personal and effective solution to each of our clients.<br>

        <a href="<?php home_url(); ?>/custom-bollard-resources/" class="button">View Resources</a>
      </div>
    </div>
  </div>
  <?php } ?>
  
  <footer>
    <div class="site-width">
      <img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.svg" alt="" id="footer-logo">

      <?php wp_nav_menu(array('theme_location'=>'footer-menu','container'=>'')); ?>
    </div>
  </footer>

  <div id="copyright">
    &copy <?php echo date("Y"); ?> Wikk Industries
  </div>

  <?php wp_footer(); ?>

</body>
</html>