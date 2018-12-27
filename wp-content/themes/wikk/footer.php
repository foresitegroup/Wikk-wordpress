  <div class="site-width prefooter<?php global $FooterTextClass; if (isset($FooterTextClass)) echo " ".$FooterTextClass; ?>">
    <?php global $FooterText; echo (isset($FooterText)) ? $FooterText : "Ready to Request a Proposal?"; ?>
    <a href="#" class="button">Contact Us</a>
  </div>
  
  <footer>
    <div class="site-width">
      <img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.svg" alt="" id="footer-logo">

      <ul>
        <li>
          <a href="<?php echo home_url(); ?>/news/innovations/">Innovations</a>
          <ul>
            <li><a href="<?php echo home_url(); ?>/gallery/">Gallery</a></li>
            <li><a href="<?php echo home_url(); ?>/faq/">FAQ</a></li>
          </ul>
        </li>
        <li>
          <a href="<?php echo home_url(); ?>/product-category/bollards/">Bollards</a>
          <ul>
            <li><a href="<?php echo home_url(); ?>/product-category/ingressr/">INGRESS'R</a></li>
            <li><a href="<?php echo home_url(); ?>/product-category/switches/">Switches</a></li>
            <li><a href="<?php echo home_url(); ?>/product-category/transmitters-receivers/">Transmitters<br>&amp; Receivers</a></li>
          </ul>
        </li>
        <li><a href="#">About</a></li>
        <li>
          <a href="<?php echo home_url(); ?>/contact/">Contact</a>
          <ul>
            <li><a href="#">Sales/Service</a></li>
            <li><a href="<?php echo home_url(); ?>/request-for-proposal/">RFP</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </footer>

  <div id="copyright">
    &copy <?php echo date("Y"); ?> Wikk Industries
  </div>

  <?php wp_footer(); ?>

</body>
</html>