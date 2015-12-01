<?php
//CardSave Hosted Payment Page Solution - Server Redirect
//Copyright (C) 2010 Modacs Limited trading as CardSave.
//Support: support@cardsave.net
//Created:		13/04/2010
//Created By:	David McCann, CardSave Online
//Modified:		01/10/2012
//Modified By: 	Alistair Richardson, CardSave Online
//Version:		5.0
//Terms of Use:
//This file and its enclosed scripts may be modified without limitation for the benefit of CardSave customers, CardSave Approved Partners and CardSave Approved Developers only.
//This file and its enclosed scripts must not be modified in any way to allow it to work with any other gateway/payment system other than that which is provided by CardSave.
//Disclaimer: This code is provided on an "as is" basis. It is the responsibility of the merchant/merchants web developer to test its implementation and function.

include("Config.php");

function stripGWInvalidChars($strToCheck) {
    $toReplace = array("#", "\\", ">", "<", "\"", "[", "]");
    $cleanString = str_replace($toReplace, "", $strToCheck);
    return $cleanString;
}
$data=$_POST["_08_duration"];
list($boat,$duration, $amount) = explode("-", $data);

$amount = str_replace("£", "",$amount);
$customInfo = "Rent Boat";


$CustomerName = stripGWInvalidChars($_POST["CustomerName"]);
$Address1 = stripGWInvalidChars($_POST["Address1"]);
$Address2 = stripGWInvalidChars($_POST["Address2"]);
$Address3 = stripGWInvalidChars($_POST["Address3"]);
$Address4 = stripGWInvalidChars($_POST["Address4"]);
$City = stripGWInvalidChars($_POST["City"]);
$State = stripGWInvalidChars($_POST["State"]);
$PostCode = stripGWInvalidChars($_POST["PostCode"]);
$EmailAddress = stripGWInvalidChars($_POST["EmailAddress"]);
$PhoneNumber = stripGWInvalidChars($_POST["PhoneNumber"]);


//var_dump($boat,$duration,$amount);
$ContactDesc = "Order " . $_POST["OrderID"] . '<br>'
 ."Customer Name:" .$CustomerName. '<br><br>'
  ."Address:" .$Address1. '<br><br>'
   ."Phone:" .$PhoneNumber. '<br><br>'
   ."Email: " .$EmailAddress. '<br><br>'
   ."---------------------------------". '<br><br>'
  . "I wish to hire a day boat* on " . $_POST["_09_start_date"] . ' - Month: ' . $_POST["_10_start_month"] . ' - Year: ' . $_POST["_11_start_year"] . '<br>'
  . "For the period:" . $duration . '<br><br>'

  . "Number in party:" . $_POST["_07_party_size"] . '<br>';

$breaks = array("<br />", "<br>", "<br/>");
$ContactDesc = str_ireplace($breaks, "\r\n", $ContactDesc);

$ContactDesc = stripGWInvalidChars($ContactDesc);






$HashString = "PreSharedKey=" . $PreSharedKey;
$HashString = $HashString . '&MerchantID=' . $_POST["MerchantID"];
$HashString = $HashString . '&Password=' . $Password;
$HashString = $HashString . '&Amount=' . $amount * 100;
$HashString = $HashString . '&CurrencyCode=' . $_POST["CurrencyCode"];
$HashString = $HashString . '&EchoAVSCheckResult=' . $_POST["EchoAVSCheckResult"];
$HashString = $HashString . '&EchoCV2CheckResult=' . $_POST["EchoCV2CheckResult"];
$HashString = $HashString . '&EchoThreeDSecureAuthenticationCheckResult=' . $_POST["EchoThreeDSecureAuthenticationCheckResult"];
$HashString = $HashString . '&EchoCardType=' . $_POST["EchoCardType"];
$HashString = $HashString . '&OrderID=' . $_POST["OrderID"];
$HashString = $HashString . '&TransactionType=' . $_POST["TransactionType"];
$HashString = $HashString . '&TransactionDateTime=' . $_POST["TransactionDateTime"];
$HashString = $HashString . '&CallbackURL=' . $_POST["CallbackURL"];
$HashString = $HashString . '&OrderDescription=' . $customInfo;
$HashString = $HashString . '&CustomerName=' . $CustomerName;
$HashString = $HashString . '&Address1=' . $Address1;
$HashString = $HashString . '&Address2=' . $Address2;
$HashString = $HashString . '&Address3=' . $Address3;
$HashString = $HashString . '&Address4=' . $Address4;
$HashString = $HashString . '&City=' . $City;
$HashString = $HashString . '&State=' . $State;
$HashString = $HashString . '&PostCode=' . $PostCode;
$HashString = $HashString . '&CountryCode=' . $_POST["CountryCode"];
$HashString = $HashString . '&EmailAddress=' . $EmailAddress;
$HashString = $HashString . '&PhoneNumber=' . $PhoneNumber;
$HashString = $HashString . '&EmailAddressEditable=' . $_POST["EmailAddressEditable"];
$HashString = $HashString . '&PhoneNumberEditable=' . $_POST["PhoneNumberEditable"];
$HashString = $HashString . "&CV2Mandatory=" . $_POST["CV2Mandatory"];
$HashString = $HashString . "&Address1Mandatory=" . $_POST["Address1Mandatory"];
$HashString = $HashString . "&CityMandatory=" . $_POST["CityMandatory"];
$HashString = $HashString . "&PostCodeMandatory=" . $_POST["PostCodeMandatory"];
$HashString = $HashString . "&StateMandatory=" . $_POST["StateMandatory"];
$HashString = $HashString . "&CountryMandatory=" . $_POST["CountryMandatory"];
$HashString = $HashString . "&ResultDeliveryMethod=" . 'SERVER';
$HashString = $HashString . "&ServerResultURL=" . $_POST["ServerResultURL"];
$HashString = $HashString . "&PaymentFormDisplaysResult=" . 'false';
$HashString = $HashString . "&ServerResultURLCookieVariables=" . '';
$HashString = $HashString . "&ServerResultURLFormVariables=" . '';
$HashString = $HashString . "&ServerResultURLQueryStringVariables=" . '';
$HashDigest = sha1($HashString);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
       <head>
              <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
              <title>Processing...</title>
       </head>
       <body>
    <form   name="contactForm" id="contactForm" method="post" action="https://mms.cardsaveonlinepayments.com/Pages/PublicPages/PaymentForm.aspx" target="_self">
                     <input type="hidden" name="HashDigest" value="<?php echo $HashDigest; ?>" />
                     <input type="hidden" name="MerchantID" value="<?php echo $_POST["MerchantID"]; ?>" />
                     <input type="hidden" name="Amount" value="<?php echo $amount * 100; ?>" />                                       
                     <input type="hidden" name="CurrencyCode" value="<?php echo $_POST["CurrencyCode"]; ?>" />
                     <input type="hidden" name="EchoAVSCheckResult" value="<?php echo $_POST["EchoAVSCheckResult"]; ?>" />
                     <input type="hidden" name="EchoCV2CheckResult" value="<?php echo $_POST["EchoCV2CheckResult"]; ?>" />
                     <input type="hidden" name="EchoThreeDSecureAuthenticationCheckResult" value="<?php echo $_POST["EchoThreeDSecureAuthenticationCheckResult"]; ?>" />
                     <input type="hidden" name="EchoCardType" value="<?php echo $_POST["EchoCardType"]; ?>" />
                     <input type="hidden" name="OrderID" value="<?php echo $_POST["OrderID"]; ?>" />
                     <input type="hidden" name="TransactionType" value="<?php echo $_POST["TransactionType"]; ?>" />
                     <input type="hidden" name="TransactionDateTime" value="<?php echo $_POST["TransactionDateTime"]; ?>" />
                     <input type="hidden" name="CallbackURL" value="<?php echo $_POST["CallbackURL"]; ?>" />
                     <input type="hidden" name="OrderDescription" value="<?php echo $customInfo; ?>" />
                     <input type="hidden" name="CustomerName" value="<?php echo $CustomerName; ?>" />
                     <input type="hidden" name="Address1" value="<?php echo $Address1; ?>" />
                     <input type="hidden" name="Address2" value="<?php echo $Address2; ?>" />
                     <input type="hidden" name="Address3" value="<?php echo $Address3; ?>" />
                     <input type="hidden" name="Address4" value="<?php echo $Address4; ?>" />
                     <input type="hidden" name="City" value="<?php echo $City; ?>" /> 
                     <input type="hidden" name="State" value="<?php echo $State; ?>" />
                     <input type="hidden" name="PostCode" value="<?php echo $PostCode; ?>" />
                     <input type="hidden" name="CountryCode" value="<?php echo $_POST["CountryCode"]; ?>" />
                     <input type="hidden" name="EmailAddress" value="<?php echo $EmailAddress; ?>" />
                     <input type="hidden" name="PhoneNumber" value="<?php echo $PhoneNumber; ?>" />
                     <input type="hidden" name="EmailAddressEditable" value="<?php echo $_POST["EmailAddressEditable"]; ?>" />
                     <input type="hidden" name="PhoneNumberEditable" value="<?php echo $_POST["PhoneNumberEditable"]; ?>" />
                     <input type="hidden" name="CV2Mandatory" value="<?php echo $_POST["CV2Mandatory"]; ?>" />
                     <input type="hidden" name="Address1Mandatory" value="<?php echo $_POST["Address1Mandatory"]; ?>" />
                     <input type="hidden" name="CityMandatory" value="<?php echo $_POST["CityMandatory"]; ?>" />
                     <input type="hidden" name="PostCodeMandatory" value="<?php echo $_POST["PostCodeMandatory"]; ?>" />
                     <input type="hidden" name="StateMandatory" value="<?php echo $_POST["StateMandatory"]; ?>" />
                     <input type="hidden" name="CountryMandatory" value="<?php echo $_POST["CountryMandatory"]; ?>" />
                     <input type="hidden" name="ResultDeliveryMethod" value="SERVER" />
                     <input type="hidden" name="ServerResultURL" value="<?php echo $_POST["ServerResultURL"]; ?>" />
                     <input type="hidden" name="PaymentFormDisplaysResult" value="false" />
                     <input type="hidden" name="ServerResultURLCookieVariables" value="" />
                     <input type="hidden" name="ServerResultURLFormVariables" value="" />
                     <input type="hidden" name="ServerResultURLQueryStringVariables" value="" />
                     <input type="hidden" name="ThreeDSecureCompatMode" value="false" />
                     <input type="hidden" name="ServerResultCompatMode" value="false" />
                     <br />

              </form>
<?php 

              
require('phpmailer/class.phpmailer.php');
require('phpmailer/class.smtp.php');


/* config start */

$emailAddress =  "hire@snaygillboats.co.uk";
$fromName=$CustomerName;
$subject="Order Request";
$fromEmail="mail@snaygillboats.co.uk";
$smtp=true;

/* NOTE: IF YOU RECIEVED THIS MESSAGE "Error Occured:Could not instantiate mail function." YOU SHOULD SET SMTP CONFIG
 * AND SET $SMTP VALUE TO TRUE */


/* config end */


                
                        
$mail = new PHPMailer(); // create a object to that class.


if($smtp){

$mail->IsSMTP();
$mail->Host = "mail.snaygillboats.co.uk";

$mail->SMTPSecure = "ssl";//this option is for gmail
$mail->Port       = 465;//this port number is for gmail
// optional
// used only when SMTP requires authentication  

$mail->SMTPAuth = true;
$mail->Username = 'mail@snaygillboats.co.uk';
$mail->Password = '2R.bU6NwV';
}




$mail->Timeout  = 360;

$mail->Subject = $subject;
$from = $fromName;
$mail->From = $fromEmail;
$mail->FromName = $fromName;
$mail->AddReplyTo($emailAddress, $from);
$to = $emailAddress;
$mail->AddAddress($to, '');


//$mail->MsgHTML($ContactDesc);

$mail->Body = $ContactDesc;


  
  
  
if($mail->Send()) {
    
   ?>
                <script type="text/javascript">
               
              
           
           document.getElementById('contactForm').submit(); // SUBMIT FORM
           
             
              
              </script>
              <?php
               echo "<div class='alert alert-success' >Your Message Sent!</div>";
  
} else {
  echo "<div class='alert alert-error' >Error Occured:".$mail->ErrorInfo."</div>";
}

  


?>
          


          

            
       </body>
</html>