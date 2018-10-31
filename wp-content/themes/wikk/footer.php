  <div class="site-width prefooter<?php global $FooterTextClass; if (isset($FooterTextClass)) echo " ".$FooterTextClass; ?>">
    <?php global $FooterText; echo (isset($FooterText)) ? $FooterText : "Ready to Request a Proposal?"; ?>
    <a href="#" class="button">Contact Us</a>
  </div>
  
  <footer>
    <div class="site-width">
      <img src="<?php echo get_template_directory_uri(); ?>/images/footer-logo.svg" alt="" id="footer-logo">

      <ul>
        <li><a href="#">Pro Area</a></li>
        <li>
          <a href="#">Blog</a>
          <ul>
            <li><a href="#">Gallery</a></li>
            <li><a href="#">FAQ</a></li>
          </ul>
        </li>
        <li>
          <a href="#">Solutions</a>
          <ul>
            <li><a href="<?php echo home_url(); ?>/product-category/bollards/">Bollards</a></li>
            <li><a href="<?php echo home_url(); ?>/product-category/ingressr/">Ingress'r</a></li>
            <li><a href="<?php echo home_url(); ?>/product-category/switches/">Switches</a></li>
            <li><a href="#">Accessories</a></li>
          </ul>
        </li>
        <li>
          <a href="#">About</a>
          <ul>
            <li><a href="#">Innovations</a></li>
            <li><a href="#">Testimonials</a></li>
          </ul>
        </li>
        <li>
          <a href="#">Contact</a>
          <ul>
            <li><a href="#">Sales/Service</a></li>
            <li><a href="#">RFP</a></li>
            <li><a href="#">Careers</a></li>
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