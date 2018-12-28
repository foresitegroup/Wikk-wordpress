<?php
/* Template Name: RFP */

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

<?php
include_once "inc/fintoozler.php";

$CommonFields = <<<EOD
<h3>Contact Info</h3>

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

<label>
  Company *<br>
  <input type="text" name="company" placeholder="Your Company, Inc." required>
</label>

<div class="two-col">
  <label>
    Email *<br>
    <input type="email" name="email" placeholder="jsmith@company.com" required>
  </label>

  <label>
    Phone *<br>
    <input type="tel" name="phone" placeholder="414-555-1212" required>
  </label>
</div>

<div class="two-col">
  <label class="address">
    Street Address *<br>
    <input type="text" name="address" placeholder="1234 N. Main St." required>
  </label>

  <label class="suite">
    Suite #<br>
    <input type="text" name="suite" placeholder="123">
  </label>
</div>

<div class="two-col">
  <label class="city">
    City *<br>
    <input type="text" name="city" placeholder="Your City" required>
  </label>

  <label class="state">
    State *<br>
    <input type="text" name="state" placeholder="Your State" required>
  </label>

  <label class="zip">
    Zip Code *<br>
    <input type="text" name="zip" placeholder="12345" required>
  </label>
</div>

<label>
  Country *<br>
  <input type="text" name="country" placeholder="Your Country" required>
</label>

<br><br>

<h3>Project Info</h3>
<label>
  Request Date<br>
  <input type="text" name="requestdate" id="standard-date" placeholder="MM/DD/YYYY">
</label>

<label>
  Name of Project<br>
  <input type="text" name="projectname" placeholder="Your Company, Inc.">
</label>

<label class="radio">
  Wikk to Respond Via:<br>
  <input type="radio" name="respond" value="Email" id="respond-email" checked>
  <label for="respond-email">Email</label>
  <input type="radio" name="respond" value="Phone" id="respond-phone">
  <label for="respond-phone">Phone</label>
</label>

<label class="radio">
  Customer Type:<br>
  <input type="radio" name="custtype" value="Architect" id="custtype-architect" checked>
  <label for="custtype-architect">Architect</label>
  <input type="radio" name="custtype" value="Specifying Engineer" id="custtype-engineer">
  <label for="custtype-engineer">Specifying Engineer</label>
  <input type="radio" name="custtype" value="Distributor" id="custtype-distributor">
  <label for="custtype-distributor">Distributor</label>
  <input type="radio" name="custtype" value="End User" id="custtype-user">
  <label for="custtype-user">End User</label>
  <input type="radio" name="custtype" value="Other" id="custtype-other">
  <label for="custtype-other">Other</label>
</label>

<input type="checkbox" name="sendupdates" value="Send updates" id="send-updates" checked>
<label for="send-updates">Send me periodic updates and innovations from Wikk</label>

<br>
EOD;
?>

<div id="rfp-tabs">
  <div id="shadow"></div>

  <div class="site-width">
    <input id="tab-standard" type="radio" name="tabs" checked>
    <label for="tab-standard" class="rfp-tab">Standard RFP</label>
    <input id="tab-bollard" type="radio" name="tabs"<?php if ($_SERVER['QUERY_STRING'] == "bollard") echo ' checked'; ?>>
    <label for="tab-bollard" class="rfp-tab">Custom Bollard Request</label>

    <div id="content">
      <div id="content-standard">
        <h4>Thank you for choosing Wikk.</h4>
        Please submit your request for proposal below. If you have any questions, or should you wish to submit another way, do not hesitate to call us at <span class="redtext">877-421-9490</span>.

        <div class="content-two-col">
          <form action="<?php echo get_template_directory_uri(); ?>/form-standard.php" method="POST" id="standard" novalidate>
            <div>
              <?php echo $CommonFields; ?>

              <h3>Product Info</h3>
              <?php
              for ($i=1; $i <= 6; $i++) {
                if ($i >= 4) {
                ?>
                <input id="item<?php echo $i; ?>-toggle" type="checkbox">
                <label for="item<?php echo $i; ?>-toggle">Add Another Item</label>
                <div>
                <?php } ?>
                <label class="radio">
                  Item #<?php echo $i; ?><br>
                  <input type="radio" name="item<?php echo $i; ?>" value="Bollard" id="item<?php echo $i; ?>-bollards" checked>
                  <label for="item<?php echo $i; ?>-bollards">Bollard</label>
                  <input type="radio" name="item<?php echo $i; ?>" value="INGRESS'R" id="item<?php echo $i; ?>-ingressr">
                  <label for="item<?php echo $i; ?>-ingressr">INGRESS'R</label>
                  <input type="radio" name="item<?php echo $i; ?>" value="Switch" id="item<?php echo $i; ?>-switches">
                  <label for="item<?php echo $i; ?>-switches">Switch</label>
                  <input type="radio" name="item<?php echo $i; ?>" value="Transmitter/Receiver" id="item<?php echo $i; ?>-transmitters-receivers">
                  <label for="item<?php echo $i; ?>-transmitters-receivers">Transmitter/Receiver</label>
                </label>

                <label>
                  Select Product
                  <div class="select">
                    <select name="item<?php echo $i; ?>_product"></select>
                  </div>
                </label>

                <label>
                  Quantity<br>
                  <input type="number" name="item<?php echo $i; ?>_quantity" placeholder="0">
                </label>
              <?php
              if ($i >= 4) echo "</div>\n";
              }
              ?>

              <br>
              <input type="hidden" id="g-recaptcha-response-s" name="g-recaptcha-response-s">
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
      </div> <!-- #content-standard -->

      <div id="content-bollard">
        <h4>Thank you for choosing Wikk.</h4>
        Please submit your request for proposal below. If you have any questions, or should you wish to submit another way, do not hesitate to call us at <span class="redtext">877-421-9490</span>.

        <div class="content-two-col">
          <form action="<?php echo get_template_directory_uri(); ?>/form-bollard.php" method="POST" enctype="multipart/form-data" id="bollard" novalidate>
            <div>
              <?php echo $CommonFields; ?>

              <h3>Bollard Requests</h3>
              <strong>For each custom bollard request, please submit a quantity, description, and drawing.</strong><br>
              <small>(Accepted File Types: .doc, .xls, .pdf, .jpg, .png, .gif, .dwf, .dwg [5MB limit per])</small><br>
              <br>

              <?php
              for ($i=1; $i <= 6; $i++) {
                if ($i >= 4) {
                ?>
                <input id="bollard<?php echo $i; ?>-toggle" type="checkbox">
                <label for="bollard<?php echo $i; ?>-toggle">Add Another Item</label>
                <div>
                <?php } ?>
                <h5>Item #<?php echo $i; ?>:</h5>
                <label>
                  Quantity<br>
                  <input type="number" name="bollard<?php echo $i; ?>_quantity" placeholder="0">
                </label>

                <label>
                  Description<br>
                  <textarea name="bollard<?php echo $i; ?>_description" placeholder="Describe your desired product"></textarea>
                </label>

                <label>
                  Special Instructions<br>
                  <textarea name="bollard<?php echo $i; ?>_instructions" placeholder="List any special instructions"></textarea>
                </label>

                <label class="upload">
                  Upload File<br>
                  <div>
                    <button>Select File <i class="fas fa-upload"></i></button>
                    <input type="file" name="bollard<?php echo $i; ?>_upload">
                  </div>
                </label><br>
              <?php
              if ($i >= 4) echo "</div>\n";
              }

              $upload_dir = wp_get_upload_dir();
              ?>
              <input type="hidden" name="upload_dir" value="<?php echo $upload_dir['basedir']; ?>/rfp/">
              <input type="hidden" name="upload_url" value="<?php echo $upload_dir['baseurl']; ?>/rfp/">

              <br>
              <input type="hidden" id="g-recaptcha-response-b" name="g-recaptcha-response-b">
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
      </div> <!-- #content-bollard -->
    </div> <!-- #content -->
  </div> <!-- .site-width -->
</div> <!-- #rfp-tabs -->

<div id="alert-modal" class="modal"><div></div></div>

<script src="https://www.google.com/recaptcha/api.js?render=<?php echo RECAPTCHA_SITE_KEY; ?>"></script>
<script>
  grecaptcha.ready(function() {
    grecaptcha.execute('<?php echo RECAPTCHA_SITE_KEY; ?>', {action: 'rfp_forms'}).then(function(token) {
      document.getElementById('g-recaptcha-response-s').value=token;
      document.getElementById('g-recaptcha-response-b').value=token;
    });
  });
</script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery-ui.min.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery-ui.min.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    function RFPResize() { $('#shadow').css({ "top": $('.rfp-tab').innerHeight() }); }

    RFPResize();

    $(window).resize(function(){ setTimeout(function() { RFPResize(); },100); });

    $("#standard-date, #bollard-date").datepicker().attr("autocomplete", "off");

    var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';

    function LoadProducts(prodname) {
      var prodid = $(prodname).attr('name');

      var proddata = {
        action: 'get_products_by_ajax',
        prodcat: $(prodname).attr('id').slice(6)
      }

      $.post(ajaxurl, proddata, function(response) {
        $('select[name="'+prodid+'_product"]').html(response);
      });
    }

    $(document).on('change', 'input[type="radio"][name^="item"]', function() {
      LoadProducts($(this));
    });

    $('input[name^="item"]:checked').each(function(){
      LoadProducts('input[name="'+$(this).attr('name')+'"]');
    });

    $('input[name$="_upload"]').change(function() {
      var output = $(this).val().split('\\').pop();
      $(this).parent().after('<span>'+output+'</span>');
    });

    $('#standard, #bollard').submit(function(event) {
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
            $('[id$="-bollards"]').prop('checked', true);
            $('[id$="-toggle"]').prop('checked', false);
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