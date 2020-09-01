<?php
function forceRedirect($url) { header('Location:'.$url); exit; }

if (isset($_POST['password'])) {
  if ($_POST['password'] == "Wikk-2020") {
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
          <?php
          if (isset($_POST['submit'])) {
            if ($_POST['fintoozler'] == "") {
              if (
                  $_POST['firstname'] != "" && $_POST['lastname'] != "" &&
                  $_POST['company'] != "" && $_POST['email'] != "" &&
                  $_POST['phone'] != "" && $_POST['address'] != "" &&
                  $_POST['city'] != "" && $_POST['state'] != "" &&
                  $_POST['zip'] != "" && $_POST['country'] != ""
                 )
              {
                $Subject = "Pro Area";
                $SendTo = "webmaster@wikk.com, kyle@wikk.com";
                $Headers = "From: Pro Area Form <donotreply@wikk.com>\r\n";
                $Headers .= "Reply-To: " . $_POST['email'] . "\r\n";
                $Headers .= "Bcc: foresitegroupllc@gmail.com\r\n";

                $Message = "I represent the following: " . $_POST['rep'] . "\n";
                $Message .= $_POST['firstname'] . " " . $_POST['lastname'] . "\n";
                $Message .= $_POST['company'] . "\n";
                $Message .= $_POST['email'] . "\n";
                $Message .= $_POST['phone'] . "\n";
                $Message .= $_POST['address'] . "\n";
                if ($_POST['suite'] != "") $Message .= $_POST['suite'] . "\n";
                $Message .= $_POST['city'] . ", " . $_POST['state'] . " " . $_POST['zip'] . "\n";
                $Message .= $_POST['country'] . "\n";

                // Add info to local database
                $sendupdates = (isset($_POST['sendupdates'])) ? $_POST['sendupdates'] : "";
                // require_once('../../../wp-load.php');
                global $wpdb;
                $wpdb->insert('form_submissions',
                  array(
                    'firstname' => $_POST['firstname'], 'lastname' => $_POST['lastname'],
                    'company' => $_POST['company'], 'email' => $_POST['email'], 'phone' => $_POST['phone'],
                    'address' => $_POST['address'], 'address2' => $_POST['suite'],
                    'city' => $_POST['city'], 'state' => $_POST['state'], 'zip' => $_POST['zip'],
                    'country' => $_POST['country'], 'sendupdates' => $sendupdates,
                    'what_form' => 'Pro Area', 'date_submitted' => time()
                  )
                );

                // Add info to MailChimp
                if (isset($_POST['sendupdates'])) {
                  $suite = ($_POST['suite'] != "") ? $_POST['suite'] : "";
                  $mcdata = array(
                    'email'  => $_POST['email'],
                    'status' => 'subscribed',
                    'firstname' => $_POST['firstname'],
                    'lastname' => $_POST['lastname'],
                    'company' => $_POST['company'],
                    'address' => $_POST['address'],
                    'address2' => $suite,
                    'city' => $_POST['city'],
                    'state' => $_POST['state'],
                    'zip' => $_POST['zip'],
                    'country' => $_POST['country'],
                    'phone' => $_POST['phone']
                  );

                  function syncMailchimp($mcdata) {
                   $memberId = md5(strtolower($mcdata['email']));
                    $dataCenter = substr(MAILCHIMP_API,strpos(MAILCHIMP_API,'-')+1);
                    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . MAILCHIMP_LIST_ID . '/members/' . $memberId;

                    $json = json_encode(array(
                      'email_address' => $mcdata['email'],
                      'status'        => $mcdata['status'],
                      'merge_fields'  => [
                        'FNAME' => $mcdata['firstname'],
                        'LNAME' => $mcdata['lastname'],
                        'COMPANY' => $mcdata['company'],
                        'ADDRESS' => array(
                          'addr1' => $mcdata['address'],
                          'addr2' => $mcdata['address2'],
                          'city' => $mcdata['city'],
                          'state' => $mcdata['state'],
                          'zip' => $mcdata['zip'],
                          'country' => $mcdata['country']
                        ),
                        'PHONE' => $mcdata['phone']
                      ]
                    ));

                    $ch = curl_init($url);

                    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . MAILCHIMP_API);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

                    $result = curl_exec($ch);
                    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    return $httpCode;
                  }

                  syncMailchimp($mcdata);
                }

                $Message = stripslashes($Message);

                mail($SendTo, $Subject, $Message, $Headers);

                $feedback = "<h4>Thank You!</h4> Thanks for requesting access to Wikk's Pro Area, a reservoir for useful, in-depth tools for industry professionals. Wikk's Pro Area password is: <strong class='redtext'>Wikk-2020</strong>.";
              } else {
                $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
              }

              echo "<div>".$feedback."</div>";
            }
          } else {
          ?>
          <script type="text/javascript">
            function formValidation(form) {
              var formid = '#'+$(form).attr('id');
              var missing = 'no';

              $(formid+' [required]').each(function(){
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

            function checkform(form) {
              if (document.getElementById('firstname').value == "") { alert('firstname required.'); document.getElementById('firstname').focus(); return false ; }
              return true ;
            }
          </script>

          <form action="<?php echo home_url(); ?>/pro/" method="POST" id="request" novalidate onsubmit="return formValidation(this)">
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
          <?php } ?>

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

<?php
global $FooterTextClass;
$FooterTextClass = "prefooter-hide";

get_footer();
?>