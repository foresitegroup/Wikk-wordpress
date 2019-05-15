<?php
/* Template Name: Contact */

get_header();
?>

<div class="site-width">
  <?php
  if ( have_posts() ) :
  	while ( have_posts() ) : the_post();
      the_title('<h1 class="news-title">', '</h1>');
  	endwhile;
  endif;
  ?>
</div>

<?php include_once "inc/fintoozler.php"; ?>

<div class="site-width">
  <div id="content">
    Have a general question about Wikk&reg; and it's various accessibility solutions? Complete the form below. For sales inquiries, consult our list of Sales Reps to find the Wikk&reg; representative who services your area.

    <div class="content-two-col">
      <form action="<?php echo get_template_directory_uri(); ?>/form-contact.php" method="POST" id="contact" novalidate>
        <div>
          <h3>General Inquiries</h3>

          <div class="two-col">
            <label>
              First Name *<br>
              <input type="text" name="firstname" placeholder="John" required>
            </label>

            <label>
              Last Name *<br>
              <input type="text" name="lastname" placeholder="Smith" required>
            </label>
          </div>

          <div class="two-col">
            <label>
              Email *<br>
              <input type="email" name="email" placeholder="jsmith@company.com" required>
            </label>

            <label>
              Phone<br>
              <input type="tel" name="phone" placeholder="414-555-1212">
            </label>
          </div>

          <label>
            Subject *<br>
            <input type="text" name="subject" placeholder="e.g. Switches, Bollards, etc...." required>
          </label>

          <label>
            Message *<br>
            <textarea name="message" placeholder="Hello...." required></textarea>
          </label>

          <label class="radio">
            Best way to contact me:<br>
            <input type="radio" name="respond" value="Email" id="respond-email" checked>
            <label for="respond-email">Email</label>
            <input type="radio" name="respond" value="Phone" id="respond-phone">
            <label for="respond-phone">Phone</label>
          </label>

          <input type="checkbox" name="sendupdates" value="Send updates" id="send-updates" checked>
          <label for="send-updates">Send me periodic updates and innovations from Wikk&reg;</label>
          
          <input type="text" name="fintoozler" autocomplete="off" style="position: absolute; width: 0; height: 0; padding: 0; opacity: 0;">
          
          <br>
          <input type="submit" name="submit" value="Submit">
        </div>
      </form>

      <div class="rfp-sidebar">
        <h3>Customer Service</h3>
        <h5>877-421-9490</h5>
        <h6><a href="mailto:customerservice@wikk.com">customerservice@wikk.com</a></h6>
        <br>
        <br>

        <h3>Sales Reps</h3>

        <h4>USA + Canada</h4>
        <h5>Kyle Holloway</h5>
        Director of Sales
        <h5>562-217-7811</h5>
        <h6><a href="mailto:kyle@wikk.com">kyle@wikk.com</a></h6><br>

        <h5>Brian Hawthorne</h5>
        President
        <h5>877-421-9490</h5>
        <h6><a href="mailto:brain@wikk.com">brain@wikk.com</a></h6><br>

        <h4>INTERNATIONAL - United Kingdom</h4>
        <h5>Controls for Doors, LLC.</h5>
        Surrey, United Kingdom<br>
        <h6><a href="mailto:sales@cfdltd.com">sales@cfdltd.com</a></h6>
        <a href="http://www.cfdltd.com" class="link">www.cfdltd.com</a>
      </div>
    </div>
  </div> <!-- #content -->
</div> <!-- .site-width -->

<div id="alert-modal" class="modal"><div></div></div>

<script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script>
<script>
  grecaptcha.ready(function() {
    grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'contact_form'}).then(function(token) {
      document.getElementById('g-recaptcha-response-c').value=token;
    });
  });
</script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#contact').submit(function(event) {
      event.preventDefault();

      var form = '#'+$(this).attr('id');
      var formData = new FormData(this);

      function formValidation() {
        var missing = 'no';

        $(form+' [required]').each(function(){
          if ($(this).val() === "") {
            $(this).addClass('alert').attr("placeholder", "REQUIRED");
            missing = 'yes';
          }
        });

        return (missing == 'no') ? true : false;
      }

      if (formValidation()) {
        $.ajax({
          type: 'POST',
          url: $(form).attr('action'),
          data: formData,
          processData: false,
          contentType: false,
          success: function(data){
            $('#alert-modal > DIV').html(data);
            if (data) $('#alert-modal').modal();

            $(form).find('input[type="text"], input[type="email"], input[type="tel"], input[type="number"], input[type="file"], select, textarea').val('');
          }
        });
      }
    });
  });
</script>

<?php
echo do_shortcode('[map]');

echo do_shortcode('[testimonials]');

$FooterTextClass = "prefooter-hide";

get_footer();
?>