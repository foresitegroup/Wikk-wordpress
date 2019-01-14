<?php
include_once "inc/fintoozler.php";

class Captcha{
  public function getCaptcha($SecretKey){
    $Resposta=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET_KEY."&response={$SecretKey}");
    $Retorno=json_decode($Resposta);
    return $Retorno;
  }
}

$ObjCaptcha = new Captcha();
$Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response-p']);
if($Retorno->success){
  if (
      $_POST['firstname'] != "" && $_POST['lastname'] != "" &&
      $_POST['company'] != "" && $_POST['email'] != "" &&
      $_POST['phone'] != "" && $_POST['address'] != "" &&
      $_POST['city'] != "" && $_POST['state'] != "" &&
      $_POST['zip'] != "" && $_POST['country'] != ""
     )
  {
    $Subject = "Pro Area";
    // $SendTo = "engineering@wikk.com, customerservice@wikk.com";
    $SendTo = "lippert@gmail.com";
    $Headers = "From: Pro Area Form <donotreply@wikk.com>\r\n";
    $Headers .= "Reply-To: " . $_POST['email'] . "\r\n";
    // $Headers .= "Bcc: mark@foresitegrp.com\r\n";
    
    $Message = "I represent the following: " . $_POST['rep'];
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
    require_once('../../../wp-load.php');
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

    // mail($SendTo, $Subject, $Message, $Headers);

    $feedback = "<h4>Thank You!</h4> Your request has been approved.<br><br>Your password is: <span class=\"redtext\">Wikk2019</span>";
    // $feedback .= "<br>";
    // $feedback .= "<pre>".$Message."</pre>";
  } else {
    $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
  }

  echo $feedback;
}
?>