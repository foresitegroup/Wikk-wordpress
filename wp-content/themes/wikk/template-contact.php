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
    Have a general question about Wikk and it's various accessibility solutions? Complete the form below. For sales inquiries, consult our list of Sales Reps to find the Wikk representative who services your area.

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
          <label for="send-updates">Send me periodic updates and innovations from Wikk</label>

          <br>
          <input type="hidden" id="g-recaptcha-response-c" name="g-recaptcha-response-c">
          <input type="submit" name="submit" value="Submit">
        </div>
      </form>

      <div class="rfp-sidebar">
        <h3>Sales Reps</h3>

        <h4>USA - West of the Mississippi + Canada</h4>
        <h5>Kyle Holloway</h5>
        Director of Sales
        <h5>562-217-7811</h5><br>

        <h4>USA - East of the Mississippi</h4>
        <h5>Katie Gainey</h5>
        Regional Sales Manager
        <h5>317-441-8552</h5><br>

        <h5>Brian Hawthorne</h5>
        President
        <h5>877-421-9490</h5><br>

        <h4>United Kingdom</h4>
        <h5>Controls for Doors, LLC.</h5>
        Hurst Place, Woldingham Rd.<br>
        Woldingham, Surrey<br>
        United Kingdom. CR3 7AF<br>
        <h6>Phone: 562-217-7811</h6>
        <h6>Fax: 562-217-7811</h6>
        <h6>Email: <a href="mailto:sales@cfdltd.com">sales@cfdltd.com</a></h6>
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

<div id="home-testimonials">
  <div class="site-width">
    <div class="sidetitle"><h1>Testimonials</h1></div>

    <div id="slides">
      <img src="<?php echo get_template_directory_uri(); ?>/images/paren-left.svg" alt="" id="pl">
      <img src="<?php echo get_template_directory_uri(); ?>/images/paren-right.svg" alt="" id="pr">

      <div>
        "Wikk has provided us with a wide bredth of accessibility solutions that has not only helped us become a more inclusive environment, but has provided us with peace of mind as well. They are always there to help."<br>
        <br>
        <span>- Jane Jones,</span> Business Manager
      </div>

      <div>
        "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut convallis tortor quis fringilla placerat. Suspendisse eget eros metus. In in dictum nisi. Praesent venenatis, tortor nec sollicitudin cursus, lectus aliquam mauris, id malesuada enim urna at leo."<br>
        <br>
        <span>- John Smith,</span> Doctor
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    var ParenTime = 1500;
    var FadeTime = 1000;
    var DelayTime = 5000;
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
$FooterTextClass = "prefooter-hide";

get_footer();
?>