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

  if ($_POST['item1_product'] != "") $Message .= "\nItem #1: " . $_POST['item1'] . " - " . $_POST['item1_product'];
  if ($_POST['item1_quantity'] != "") $Message .= "\nItem #1 Quantity: " . $_POST['item1_quantity'];
  $Message .= "\n";

  if ($_POST['item2_product'] != "") $Message .= "\nItem #2: " . $_POST['item2'] . " - " . $_POST['item2_product'];
  if ($_POST['item2_quantity'] != "") $Message .= "\nItem #2 Quantity: " . $_POST['item2_quantity'];
  $Message .= "\n";

  if ($_POST['item3_product'] != "") $Message .= "\nItem #3: " . $_POST['item3'] . " - " . $_POST['item3_product'];
  if ($_POST['item3_quantity'] != "") $Message .= "\nItem #3 Quantity: " . $_POST['item3_quantity'];
  $Message .= "\n";

  if ($_POST['item4_product'] != "") $Message .= "\nItem #4: " . $_POST['item4'] . " - " . $_POST['item4_product'];
  if ($_POST['item4_quantity'] != "") $Message .= "\nItem #4 Quantity: " . $_POST['item4_quantity'];
  $Message .= "\n";

  if ($_POST['item5_product'] != "") $Message .= "\nItem #5: " . $_POST['item5'] . " - " . $_POST['item5_product'];
  if ($_POST['item5_quantity'] != "") $Message .= "\nItem #5 Quantity: " . $_POST['item5_quantity'];
  $Message .= "\n";

  if ($_POST['item6_product'] != "") $Message .= "\nItem #6: " . $_POST['item6'] . " - " . $_POST['item6_product'];
  if ($_POST['item6_quantity'] != "") $Message .= "\nItem #6 Quantity: " . $_POST['item6_quantity'];
  $Message .= "\n";

  $Message = stripslashes($Message);

  // mail($SendTo, $Subject, $Message, $Headers);

  $feedback = "Thank you for your request. You will be contacted soon.";
  $feedback .= "<pre>".$Message."</pre>";

  if (!empty($_REQUEST['src'])) {
    header("HTTP/1.0 200 OK");
    echo $feedback;
  }
} else {
  $feedback = "Some required information is missing! Please go back and make sure all required fields are filled.";

  if (!empty($_REQUEST['src'])) {
    header("HTTP/1.0 500 Internal Server Error");
    echo $feedback;
  }
}
?>