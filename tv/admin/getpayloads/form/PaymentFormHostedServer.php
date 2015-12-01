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

function gatewaydatetime()
{
  $str=date('Y-m-d H:i:s O');
  return $str;
}     

function guid(){
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
        return $uuid;
    }
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
</head>
<body>
	<form name="contactFormA" id="contactFormA" method="post" action="PaymentFormHostedProcessServer.php" target="_self">
		MerchantID - <input name="MerchantID" value="<?php echo $MerchantID; ?>" /><br />
		Amount - <input name="Amount" value="751" /><br />
		CurrencyCode - <input name="CurrencyCode" value="826" /><br />
		EchoAVSCheckResult - <input name="EchoAVSCheckResult" value="true" /><br />
		EchoCV2CheckResult - <input name="EchoCV2CheckResult" value="true" /><br />
		EchoThreeDSecureAuthenticationCheckResult - <input name="EchoThreeDSecureAuthenticationCheckResult" value="true" /><br />
		EchoCardType - <input name="EchoCardType" value="true" /><br />
		OrderID - <input name="OrderID" value="<? echo guid(); ?>" /><br />
		TransactionType - <input name="TransactionType" value="SALE" /><br />
		TransactionDateTime - <input name="TransactionDateTime" value="<? echo gatewaydatetime(); ?>" /><br />
		CallbackURL - <input name="CallbackURL" value="<?php echo $WebAddress; ?>/PaymentFormHostedCallbackDisplay.php" /><br />
		OrderDescription - <input name="OrderDescription" value="Conference Booking" /><br />
		CustomerName - <input name="CustomerName" value="John Watson" /><br />			
		Address1 - <input name="Address1" value="32 Edward Street" /><br />
		Address2 - <input name="Address2" value="" /><br />
		Address3 - <input name="Address3" value="" /><br />
		Address4 - <input name="Address4" value="" /><br />
		City - <input name="City" value="Camborne" /><br /> 
		State - <input name="State" value="Cornwall" /><br />
		PostCode - <input name="PostCode" value="TR14 8PA" /><br /> 
		CountryCode - <input name="CountryCode" value="826" /><br />
		<br />
		EmailAddress - <input name="EmailAddress" value="yourcustomer@abc123.com" /><br />
		PhoneNumber - <input name="PhoneNumber" value="01234789456" /><br />
		EmailAddressEditable - <input name="EmailAddressEditable" value="false" /><br />
		PhoneNumberEditable - <input name="PhoneNumberEditable" value="false" /><br />
		<br />
		CV2Mandatory - <input name="CV2Mandatory" value="true" /><br />
		Address1Mandatory - <input name="Address1Mandatory" value="true" /><br />
		CityMandatory - <input name="CityMandatory" value="true" /><br />
		PostCodeMandatory - <input name="PostCodeMandatory" value="true" /><br />
		StateMandatory - <input name="StateMandatory" value="true" /><br />
		CountryMandatory - <input name="CountryMandatory" value="true" /><br />
		ServerResultURL - <input name="ServerResultURL" value="<?php echo $WebAddress; ?>/PaymentFormHostedResult.php" /><br />
		<br /><input type="submit" value="TEST NOW" />
	</form>
</body>
</html>
