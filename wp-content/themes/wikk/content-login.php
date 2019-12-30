<?php
function forceRedirect($url) { header('Location:'.$url); exit; }

if (isset($_POST['password'])) {
  if ($_POST['password'] == "Wikk2019") {
    setcookie("WIpa", md5($_POST['password']));
  }
  forceRedirect(home_url().'/pro/');
}

get_header();
?>

<div class="site-width proarea">
  <h1 class="news-title">Pro Area</h1>

  <div class="login">
    <div id="password">
      If you are a returning visitor to  Wikk's Pro Area, please enter your password below. <span class="redtext">If you are a new visitor, you may easily request a password by completing the Request Password form below.</span><br>
      <br>

      <form method="post">
        <div>
          <label>
            Enter Password
            <input type="password" name="password" placeholder="********">
          </label>
          <input type="submit" name="login" value="Log In">
        </div>
      </form>
    </div> <!-- #password -->
    
    <?php include_once "inc/fintoozler.php"; ?>

    <div id="request-password">
      <h2><span>Request Password</span></h2>

      <div id="content">
        <div class="content-two-col">
          <form action="<?php echo get_template_directory_uri(); ?>/form-request.php" method="POST" id="request" novalidate>
            <div>
              <label class="radio">
                I represent the following:<br>
                <input type="radio" name="rep" value="Architect/Spec." id="rep-architect" checked>
                <label for="rep-architect">Architect/Spec.</label>
                <input type="radio" name="rep" value="Consultant" id="rep-consultant">
                <label for="rep-consultant">Consultant</label>
                <input type="radio" name="rep" value="Distributor" id="rep-distributor">
                <label for="rep-distributor">Distributor</label>
                <input type="radio" name="rep" value="End User" id="rep-user">
                <label for="rep-user">End User</label>
                <input type="radio" name="rep" value="Installer" id="rep-installer">
                <label for="rep-installer">Installer</label>
                <input type="radio" name="rep" value="OEM" id="rep-oem">
                <label for="rep-oem">OEM</label>
              </label>

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

              <input type="checkbox" name="sendupdates" value="Send updates" id="send-updates" checked>
              <label for="send-updates">Send me periodic updates and innovations from Wikk</label>

              <input type="text" name="fintoozler" autocomplete="off" style="position: absolute; width: 0; height: 0; padding: 0; opacity: 0;">

              <input type="submit" name="submit" value="Submit">
            </div>
          </form>

          <div class="pro-sidebar">
            <h3>Wikk's Pro Area</h3>

            <span class="redtext">Wikk's Pro Area</span> is filled with <span class="redtext">useful, in-depth tools for industry professionals.</span> By requesting access to the Pro Area, <span class="redtext">you will gain access to Wikk's library of:</span>
            <ul>
              <li>Product Specs</li>
              <li>CAD Drawings</li>
              <li>Architect Resources</li>
              <li>Instructional Material</li>
              <li>Video Content</li>
              <li>&amp; More!</li>
            </ul>
          </div>
        </div> <!-- .content-two-col -->
      </div> <!-- #content -->
    </div> <!-- #request -->
  </div> <!-- .login -->
</div> <!-- .proarea -->

<div id="alert-modal" class="modal proarea"><div></div></div>

<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.css">
<script src="<?php echo get_template_directory_uri(); ?>/inc/jquery.modal.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    $('#request').submit(function(event) {
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

        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,6})+$/;
        if (!regex.test($(form).find('input[type="email"]').val())) {
          $(form).find('input[type="email"]').addClass('alert').attr("placeholder", "NOT A VALID EMAIL ADDRESS").val('');
          missing = 'yes';
        }

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

            $(form).find('input[type="text"], input[type="email"], input[type="tel"]').val('');
            $('#rep-builder, #send-updates').prop('checked', true);
          }
        });
      }
    });
  });
</script>

<?php
global $FooterTextClass;
$FooterTextClass = "prefooter-hide";

get_footer();
?>