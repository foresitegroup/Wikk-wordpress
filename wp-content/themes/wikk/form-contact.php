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
$Retorno = $ObjCaptcha->getCaptcha($_POST['g-recaptcha-response-c']);
if($Retorno->success){
  if (
      $_POST['firstname'] != "" && $_POST['lastname'] != "" &&
      $_POST['email'] != "" && $_POST['subject'] != "" && $_POST['message'] != ""
     )
  {
    $Subject = $_POST['subject'];
    // $SendTo = "sales@wikk.com";
    $SendTo = "lippert@gmail.com";
    $Headers = "From: Contact Form <donotreply@wikk.com>\r\n";
    $Headers .= "Reply-To: " . $_POST['email'] . "\r\n";
    // $Headers .= "Bcc: mark@foresitegrp.com\r\n";

    $Message = $_POST['firstname'] . " " . $_POST['lastname'] . "\n";
    $Message .= $_POST['email'] . "\n";
    if ($_POST['phone'] != "") $Message .= $_POST['phone'] . "\n";
    $Message .= "\n" . $_POST['subject'] . "\n";
    $Message .= $_POST['message'] . "\n";

    $Message .= "\nWikk to Respond Via: " . $_POST['respond'];
    $Message .= "\n";
    
    // Add info to local database
    $sendupdates = (isset($_POST['sendupdates'])) ? $_POST['sendupdates'] : "";
    require_once('../../../wp-load.php');
    global $wpdb;
    $wpdb->insert('form_submissions',
      array(
        'firstname' => $_POST['firstname'], 'lastname' => $_POST['lastname'],
        'email' => $_POST['email'], 'phone' => $_POST['phone'], 'sendupdates' => $sendupdates,
        'what_form' => 'Contact', 'date_submitted' => time()
      )
    );
    
    // Add info to MailChimp
    if (isset($_POST['sendupdates'])) {
      $phone = ($_POST['phone'] != "") ? $_POST['phone'] : "";
      $mcdata = array(
        'email'  => $_POST['email'],
        'status' => 'subscribed',
        'firstname' => $_POST['firstname'],
        'lastname' => $_POST['lastname'],
        'phone' => $phone
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

    $feedback = "Thank you for your inquiry. You will be contacted soon.";
    $feedback .= "<br>";
    $feedback .= "<pre>".$Message."</pre>";
  } else {
    $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
  }

  echo $feedback;
}
?>