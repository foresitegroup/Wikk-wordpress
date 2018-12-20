<?php
if (
    $_POST['firstname'] != "" && $_POST['lastname'] != "" &&
    $_POST['company'] != "" && $_POST['email'] != "" &&
    $_POST['phone'] != "" && $_POST['address'] != "" &&
    $_POST['city'] != "" && $_POST['state'] != "" &&
    $_POST['zip'] != "" && $_POST['country'] != ""
   )
{
  $Subject = "Standard RFP";
  $SendTo = "lippert@gmail.com";
  $Headers = "From: Standard RFP Form <donotreply@wikk.com>\r\n";
  $Headers .= "Reply-To: " . $_POST['email'] . "\r\n";
  // $Headers .= "Bcc: mark@foresitegrp.com\r\n";

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
  
  for ($i=1; $i <= 6; $i++) {
    if ($_POST['item'.$i.'_product'] != "") $Message .= "\nItem #".$i.": " . $_POST['item'.$i] . " - " . $_POST['item'.$i.'_product'];
    if ($_POST['item'.$i.'_quantity'] != "") $Message .= "\nItem #".$i." Quantity: " . $_POST['item'.$i.'_quantity'];
    if ($_POST['item'.$i.'_product'] != "" || $_POST['item'.$i.'_quantity'] != "") $Message .= "\n";
  }

  $Message = stripslashes($Message);

  // mail($SendTo, $Subject, $Message, $Headers);

  $feedback = "Thank you for your request. You will be contacted soon.";
  $feedback .= "<br>";
  $feedback .= "<pre>".$Message."</pre>";
} else {
  $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";
}

echo $feedback;
?>