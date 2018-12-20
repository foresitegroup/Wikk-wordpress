<?php
if (
    $_POST['firstname'] != "" && $_POST['lastname'] != "" &&
    $_POST['company'] != "" && $_POST['email'] != "" &&
    $_POST['phone'] != "" && $_POST['address'] != "" &&
    $_POST['city'] != "" && $_POST['state'] != "" &&
    $_POST['zip'] != "" && $_POST['country'] != ""
   )
{
  require_once "inc/swiftmailer/swift_required.php";

  $sm = Swift_Message::newInstance();
  $sm->setTo(array("lippert@gmail.com"));
  // $sm->setBcc(array("mark@foresitegrp.com"));
  $sm->setFrom(array("donotreply@wikk.com" => "Custom Bollard RFP Form"));
  $sm->setReplyTo($_POST['email']);
  $sm->setSubject("Custom Bollard RFP");

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
  $Message .= "\n";

  if ($_POST['sendupdates'] != "") {
    // MailChimp stuff here
  }

  $allowed = array("pdf","dwg","dfx","doc","docx","xls","xlsx","txt","png");
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
      $Message .= "\nItem #".$i." File Name: " . $_FILES['bollard'.$i.'_upload']['name'];

      if (in_array(strtolower(pathinfo($_FILES['bollard'.$i.'_upload']['name'], PATHINFO_EXTENSION)), $allowed)) {
        if ($_FILES['bollard'.$i.'_upload']['size'] <= 5242880) {
          $sm->attach(Swift_Attachment::fromPath($_FILES['bollard'.$i.'_upload']['tmp_name'])->setFilename($_FILES['bollard'.$i.'_upload']['name']));
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

  $sm->setBody($Message);

  // Create the Transport and Mailer
  $transport = Swift_MailTransport::newInstance();
  $mailer = Swift_Mailer::newInstance($transport);
  
  // Send it!
  // $result = $mailer->send($sm);

  $feedback = "Thank you for your request. You will be contacted soon.";
  $feedback .= "<br>";
  $feedback .= "<pre>".$Message."</pre>";

  if ($InvalidFile != "") $feedback .= "<br>" . $InvalidFile;
  if ($TooBig != "") $feedback .= "<br>" . $TooBig;
  if ($InvalidFile != "") $feedback .= "<br><br>To submit your files another way, please call us at 877-421-9490.";
} else {
  $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
}

echo $feedback;
?>