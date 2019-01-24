  <div class="site-width prefooter<?php global $FooterTextClass; if (isset($FooterTextClass)) echo " ".$FooterTextClass; ?>">
    <?php
    global $FooterText, $ButtonURL, $ButtonText;
    echo (isset($FooterText)) ? $FooterText : "Ready to Request a Quote?";
    $ButtonURL = (isset($ButtonURL)) ? $ButtonURL : "/request-for-quote/";
    $ButtonText = (isset($ButtonText)) ? $ButtonText : "Request a Quote Here";
    ?>
    <a href="<?php echo home_url() . $ButtonURL; ?>" class="button"><?php echo $ButtonText; ?></a>
  </div>
  
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