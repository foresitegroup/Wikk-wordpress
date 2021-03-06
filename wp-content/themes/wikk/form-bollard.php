<?php
include_once "inc/fintoozler.php";

$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET_KEY2."&response=".$_POST['g-recaptcha-response']);
$responsekeys = json_decode($response);

if ($responsekeys->success) {
  if (
      $_POST['firstname'] != "" && $_POST['lastname'] != "" &&
      $_POST['company'] != "" && $_POST['email'] != "" &&
      $_POST['phone'] != "" && $_POST['address'] != "" &&
      $_POST['city'] != "" && $_POST['state'] != "" &&
      $_POST['zip'] != "" && $_POST['country'] != ""
     )
  {
    $Subject = "Custom Bollard RFP";
    $SendTo = "webmaster@wikk.com, customerservice@wikk.com";
    // $SendTo = "lippert@gmail.com";
    $Headers = "From: Custom Bollard RFP Form <donotreply@wikk.com>\r\n";
    $Headers .= "Reply-To: " . $_POST['email'] . "\r\n";
    $Headers .= "Bcc: foresitegroupllc@gmail.com\r\n";

    $Message = $_POST['firstname'] . " " . $_POST['lastname'] . "\n";
    $Message .= $_POST['company'] . "\n";
    $Message .= $_POST['email'] . "\n";
    $Message .= $_POST['phone'] . "\n";
    $Message .= $_POST['address'] . "\n";
    if ($_POST['suite'] != "") $Message .= $_POST['suite'] . "\n";
    $Message .= $_POST['city'] . ", " . $_POST['state'] . " " . $_POST['zip'] . "\n";
    $Message .= $_POST['country'] . "\n";

    if ($_POST['requestdate'] != "") $Message .= "\nRequest Date: " . $_POST['requestdate'];
    if ($_POST['projectname'] != "") $Message .= "\nName of Project: " . $_POST['projectname'];
    $Message .= "\nWikk to Respond Via: " . $_POST['respond'];
    $Message .= "\nCustomer Type: " . $_POST['custtype'];
    $Message .= "\nQuote Request Type: " . $_POST['requesttype'];
    $Message .= "\n";
    
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
        'what_form' => 'RFP Bollard', 'date_submitted' => time()
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

    $allowed = array("doc", "xls", "pdf", "jpg", "png", "gif", "dwf", "dwg");
    $InvalidFile = "";
    $TooBig = "";

    for ($i=1; $i <= 6; $i++) {
      if (isset($_POST['bollard'.$i.'_quantity']) && $_POST['bollard'.$i.'_quantity'] != "")
        $Message .= "\nItem #".$i." Quantity: " . $_POST['bollard'.$i.'_quantity'];
      if (isset($_POST['bollard'.$i.'_description']) && $_POST['bollard'.$i.'_description'] != "")
        $Message .= "\nItem #".$i." Description: " . $_POST['bollard'.$i.'_description'];
      if (isset($_POST['bollard'.$i.'_instructions']) && $_POST['bollard'.$i.'_instructions'] != "")
        $Message .= "\nItem #".$i." Special Instructions: " . $_POST['bollard'.$i.'_instructions'];

      if (isset($_FILES['bollard'.$i.'_upload']['tmp_name']) && $_FILES['bollard'.$i.'_upload']['tmp_name'] != "") {
        $Message .= "\nItem #".$i." File Name: " . str_replace(" ", "_", $_FILES['bollard'.$i.'_upload']['name']);

        if (in_array(strtolower(pathinfo($_FILES['bollard'.$i.'_upload']['name'], PATHINFO_EXTENSION)), $allowed)) {
          if ($_FILES['bollard'.$i.'_upload']['size'] <= 5242880) {
            move_uploaded_file($_FILES['bollard'.$i.'_upload']['tmp_name'], $_POST['upload_dir'].str_replace(" ", "_", $_FILES['bollard'.$i.'_upload']['name']));
            $Message .= "\nItem #".$i." File Link: " . $_POST['upload_url'].str_replace(" ", "_", $_FILES['bollard'.$i.'_upload']['name']);
          } else {
            $TooBig .= "<br>" . $_FILES['bollard'.$i.'_upload']['name'] . " exceeded the file size limit and was not attached.";
            $Message .= "\nThis file exceeded the file size limit and was not attached.";
          }
        } else {
          $InvalidFile .= "<br>" . $_FILES['bollard'.$i.'_upload']['name'] . " is not a valid file type and was not attached.";
          $Message .= "\nThis file is not a valid file type and was not attached.";
        }
      }
      if ($_POST['bollard'.$i.'_quantity'] != "" || $_POST['bollard'.$i.'_description'] != "" || $_POST['bollard'.$i.'_instructions'] != "" || $_FILES['bollard'.$i.'_upload']['name'] != "") $Message .= "\n";
    }

    $Message = stripslashes($Message);

    mail($SendTo, $Subject, $Message, $Headers);

    $feedback = "Thank you for your request. You will be contacted soon.";

    if ($InvalidFile != "") $feedback .= "<br>" . $InvalidFile;
    if ($TooBig != "") $feedback .= "<br>" . $TooBig;
    if ($InvalidFile != "") $feedback .= "<br><br>To submit your files another way, please call us at 877-421-9490.";
  } else {
    $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
  }

  echo $feedback;
}
?>