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
		
// The developer should amend this code in order to update the merchants website order system.
// *PLEASE LOOK FOR "You should put your code that does any post transaction tasks".

// The merchants system should store the status of the payment.
// When the customer returns to the merchants website via the callback URL the status can then be sort so the correct response to the customer is displayed.
// This page should echo a repsonse form the gateway to inform the gateway the message was delivered correctly.
// Anything other than a "0" echoed in the response code for this page with envoke the gateway to send an email to the merchant with the error. The customer will then not return to the merchants website.
// "0" simply means that the message was delivered correctly and is NOT an echo of the payment "StatusCode".

include("Config.php");

//magic quotes fix
if (get_magic_quotes_gpc()) {
	$_POST = array_map('stripslashes', $_POST);
}

// String together other strings using a "," as a seperator.
function addStringToStringList($szExistingStringList, $szStringToAdd)
{
	$szReturnString = "";
	$szCommaString = "";

	if (strlen($szStringToAdd) == 0)
	{
		$szReturnString = $szExistingStringList;
	}
	else
	{
		if (strlen($szExistingStringList) != 0)
		{
			$szCommaString = ", ";
		}
		$szReturnString = $szExistingStringList.$szCommaString.$szStringToAdd;
	}

	return ($szReturnString);
}

$szHashDigest = "";
$szOutputMessage = "";
$boErrorOccurred = false;
$nStatusCode = 30;
$szMessage = "";
$nPreviousStatusCode = 0;
$szPreviousMessage = "";
$szCrossReference = "";
$szCardType = "";
$szCardClass = "";
$szCardIssuer = "";
$szCardIssuerCountryCode = "";
$szAddressNumericCheckResult = "";
$szPostCodeCheckResult = "";
$szCV2CheckResult = "";
$szThreeDSecureAuthenticationCheckResult = "";
$nAmount = 0;
$nCurrencyCode = 0;
$szOrderID = "";
$szTransactionType= "";
$szTransactionDateTime = "";
$szOrderDescription = "";
$szCustomerName = "";
$szAddress1 = "";
$szAddress2 = "";
$szAddress3 = "";
$szAddress4 = "";
$szCity = "";
$szState = "";
$szPostCode = "";
$nCountryCode = "";
$szEmailAddress = "";
$szPhoneNumber = "";

try
	{
		// hash digest
		if (isset($_POST["HashDigest"]))
		{
			$szHashDigest = $_POST["HashDigest"];
		}

		// transaction status code
		if (!isset($_POST["StatusCode"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [StatusCode] not received");
			$boErrorOccurred = true;
		}
		else
		{
			if ($_POST["StatusCode"] == "")
			{
				$nStatusCode = null;
			}
			else
			{
				$nStatusCode = intval($_POST["StatusCode"]);
			}
		}
		// transaction message
		if (!isset($_POST["Message"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Message] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szMessage = $_POST["Message"];
		}
		// status code of original transaction if this transaction was deemed a duplicate
		if (!isset($_POST["PreviousStatusCode"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PreviousStatusCode] not received");
			$boErrorOccurred = true;
		}
		else
		{
			if ($_POST["PreviousStatusCode"] == "")
			{
				$nPreviousStatusCode = null;
			}
			else
			{
				$nPreviousStatusCode = intval($_POST["PreviousStatusCode"]);
			}
		}
		// status code of original transaction if this transaction was deemed a duplicate
		if (!isset($_POST["PreviousMessage"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PreviousMessage] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szPreviousMessage = $_POST["PreviousMessage"];
		}
		// cross reference of transaction
		if (!isset($_POST["CrossReference"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CrossReference] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCrossReference = $_POST["CrossReference"];
		}
		// card type
		if (!isset($_POST["CardType"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CardType] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCardType = $_POST["CardType"];
		}
		// card class
		if (!isset($_POST["CardClass"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CardClass] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCardClass = $_POST["CardClass"];
		}
		// card issuer
		if (!isset($_POST["CardIssuer"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CardIssuer] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCardIssuer = $_POST["CardIssuer"];
		}
		// card issuer
		if (!isset($_POST["CardIssuerCountryCode"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CardIssuerCountryCode] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCardIssuerCountryCode = $_POST["CardIssuerCountryCode"];
		}
		// address numeric check
		if (!isset($_POST["AddressNumericCheckResult"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [AddressNumericCheckResult] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szAddressNumericCheckResult = $_POST["AddressNumericCheckResult"];
		}
		// post code check
		if (!isset($_POST["PostCodeCheckResult"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PostCodeCheckResult] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szPostCodeCheckResult = $_POST["PostCodeCheckResult"];
		}
		// CV2 check
		if (!isset($_POST["CV2CheckResult"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CV2CheckResult] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCV2CheckResult = $_POST["CV2CheckResult"];
		}
		// 3DS check
		if (!isset($_POST["ThreeDSecureAuthenticationCheckResult"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [ThreeDSecureAuthenticationCheckResult] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szThreeDSecureAuthenticationCheckResult = $_POST["ThreeDSecureAuthenticationCheckResult"];
		}
		// amount (same as value passed into payment form - echoed back out by payment form)
		if (!isset($_POST["Amount"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Amount] not received");
			$boErrorOccurred = true;
		}
		else
		{
			if ($_POST["Amount"] == null)
			{
				$nAmount = null;
			}
			else
			{
				$nAmount = intval($_POST["Amount"]);
			}
		}
		// currency code (same as value passed into payment form - echoed back out by payment form)
		if (!isset($_POST["CurrencyCode"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CurrencyCode] not received");
			$boErrorOccurred = true;
		}
		else
		{
			if ($_POST["CurrencyCode"] == null)
			{
				$nCurrencyCode = null;
			}
			else
			{
				$nCurrencyCode = intval($_POST["CurrencyCode"]);
			}
		}
		// order ID (same as value passed into payment form - echoed back out by payment form)
		if (!isset($_POST["OrderID"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [OrderID] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szOrderID = $_POST["OrderID"];
		}
		// transaction type (same as value passed into payment form - echoed back out by payment form)
		if (!isset($_POST["TransactionType"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [TransactionType] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szTransactionType = $_POST["TransactionType"];
		}
		// transaction date/time (same as value passed into payment form - echoed back out by payment form)
		if (!isset($_POST["TransactionDateTime"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [TransactionDateTime] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szTransactionDateTime = $_POST["TransactionDateTime"];
		}
		// order description (same as value passed into payment form - echoed back out by payment form)
		if (!isset($_POST["OrderDescription"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [OrderDescription] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szOrderDescription = $_POST["OrderDescription"];
		}
		// customer name (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["CustomerName"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CustomerName] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCustomerName = $_POST["CustomerName"];
		}
		// address1 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["Address1"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address1] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szAddress1 = $_POST["Address1"];
		}
		// address2 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["Address2"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address2] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szAddress2 = $_POST["Address2"];
		}
		// address3 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["Address3"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address3] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szAddress3 = $_POST["Address3"];
		}
		// address4 (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["Address4"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [Address4] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szAddress4 = $_POST["Address4"];
		}
		// city (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["City"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [City] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szCity = $_POST["City"];
		}
		// state (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["State"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [State] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szState = $_POST["State"];
		}
		// post code (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["PostCode"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PostCode] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szPostCode = $_POST["PostCode"];
		}
		// country code (not necessarily the same as value passed into payment form - as the customer can change it on the form)
		if (!isset($_POST["CountryCode"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [CountryCode] not received");
			$boErrorOccurred = true;
		}
		else
		{
			if ($_POST["CountryCode"] == "")
			{
				$nCountryCode = null;
			}
			else
			{
				$nCountryCode = intval($_POST["CountryCode"]);
			}
		}
		// email address
		if (!isset($_POST["EmailAddress"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [EmailAddress] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szEmailAddress = $_POST["EmailAddress"];
		}
		// phone number
		if (!isset($_POST["PhoneNumber"]))
		{
			$szOutputMessage = addStringToStringList($szOutputMessage, "Expected variable [PhoneNumber] not received");
			$boErrorOccurred = true;
		}
		else
		{
			$szPhoneNumber = $_POST["PhoneNumber"];
		}
	}
catch (Exception $e)
{
	$boErrorOccurred = true;
	$szOutputMessage = "Error";
	if (isset($_POST["Message"]))
	{
		$szOutputMessage = $_POST["Message"];
	}
}
	
// The nOutputProcessedOK should return 0 except if there has been an error talking to the gateway or updating the website order system.
// Any other process status shown to the gateway will prompt the gateway to send an email to the merchant stating the error.
// The customer will also be shown a message on the hosted payment form detailing the error and will not return to the merchants website.
$nOutputProcessedOK = 0;

if (is_null($nStatusCode))
{
	$nOutputProcessedOK = 30;		
}

if ($boErrorOccurred == true)
{
	$nOutputProcessedOK = 30;
}

// Check the passed HashDigest against our own to check the values passed are legitimate.
$hashcode="PreSharedKey=" . $PreSharedKey;
$hashcode=$hashcode . '&MerchantID=' . $_POST["MerchantID"];
$hashcode=$hashcode . '&Password=' . $Password;
$hashcode=$hashcode . '&StatusCode=' . $_POST["StatusCode"];
$hashcode=$hashcode . '&Message=' . $_POST["Message"];
$hashcode=$hashcode . '&PreviousStatusCode=' . $_POST["PreviousStatusCode"];
$hashcode=$hashcode . '&PreviousMessage=' . $_POST["PreviousMessage"];
$hashcode=$hashcode . '&CrossReference=' . $_POST["CrossReference"];
$hashcode=$hashcode . '&AddressNumericCheckResult=' . $_POST["AddressNumericCheckResult"];
$hashcode=$hashcode . '&PostCodeCheckResult=' . $_POST["PostCodeCheckResult"];
$hashcode=$hashcode . '&CV2CheckResult=' . $_POST["CV2CheckResult"];
$hashcode=$hashcode . '&ThreeDSecureAuthenticationCheckResult=' . $_POST["ThreeDSecureAuthenticationCheckResult"];
$hashcode=$hashcode . '&CardType=' . $_POST["CardType"];
$hashcode=$hashcode . '&CardClass=' . $_POST["CardClass"];
$hashcode=$hashcode . '&CardIssuer=' . $_POST["CardIssuer"];
$hashcode=$hashcode . '&CardIssuerCountryCode=' . $_POST["CardIssuerCountryCode"];
$hashcode=$hashcode . '&Amount=' . $_POST["Amount"];
$hashcode=$hashcode . '&CurrencyCode=' . $_POST["CurrencyCode"];
$hashcode=$hashcode . '&OrderID=' . $_POST["OrderID"];
$hashcode=$hashcode . '&TransactionType=' . $_POST["TransactionType"];
$hashcode=$hashcode . '&TransactionDateTime=' . $_POST["TransactionDateTime"];
$hashcode=$hashcode . '&OrderDescription=' . $_POST["OrderDescription"];
$hashcode=$hashcode . '&CustomerName=' . $_POST["CustomerName"];
$hashcode=$hashcode . '&Address1=' . $_POST["Address1"];
$hashcode=$hashcode . '&Address2=' . $_POST["Address2"];
$hashcode=$hashcode . '&Address3=' . $_POST["Address3"];
$hashcode=$hashcode . '&Address4=' . $_POST["Address4"];
$hashcode=$hashcode . '&City=' . $_POST["City"];
$hashcode=$hashcode . '&State=' . $_POST["State"];
$hashcode=$hashcode . '&PostCode=' . $_POST["PostCode"];
$hashcode=$hashcode . '&CountryCode=' . $_POST["CountryCode"];
$hashcode=$hashcode . '&EmailAddress=' . $_POST["EmailAddress"];
$hashcode=$hashcode . '&PhoneNumber=' . $_POST["PhoneNumber"];	
$hashcode = sha1($hashcode);

$str1 = $_POST["HashDigest"];
if ($hashcode != $str1) {
	$nOutputProcessedOK = 30; 
	$szOutputMessage = "Hashes did not match";
} 

// *********************************************************************************************************
// You should put your code that does any post transaction tasks
// (e.g. updates the order object, sends the customer an email etc) in this section
// *********************************************************************************************************
if ($nOutputProcessedOK != 30)
	{	
		$nOutputProcessedOK = 0;
		$szOutputMessage = $szMessage;
		try
		{
			switch ($nStatusCode)
			{
				// transaction authorised
				case 0:
					$transauthorised = true;
					break;
				// card referred (treat as decline)
				case 4:
					$transauthorised = false;
					break;
				// transaction declined
				case 5:
					$transauthorised = false;
					break;
				// duplicate transaction
				case 20:
					// need to look at the previous status code to see if the
					// transaction was successful
					if ($nPreviousStatusCode == 0)
					{
						// transaction authorised
						$transauthorised = true;
					}
					else
					{
						// transaction not authorised
						$transauthorised = false;
					}
					break;
				// error occurred
				case 30:
					$transauthorised = false;
					break;
				default:
					$transauthorised = false;
					break;
			}
		
			if ($transauthorised == true) {
				// put code here to update/store the order with the a successful transaction result
			} else {
				// put code here to update/store the order with the a failed transaction result
			}
		}
		catch (Exception $e)
		{
			$nOutputProcessedOK = 30;
			$szOutputMessage = "Error updating website system, please ask the developer to check code";
		}
	}

if ($nOutputProcessedOK != 0 && $szOutputMessage == "")
{
	$szOutputMessage = "Unknown error";
}	

if ($EmailResult) {

	$to = $ToAddress;
	$from = $FromAddress;
	$subject = $WebAddress. " Cardsave Postback Result";

	$messagecont = "<p><b>Date Sent:</b> ". date('jS F Y - g:ia') ."</p>";
				
	foreach($_POST as $key => $value) {
		$messagecont .= "<p><b>". $key.":</b><br />". $value . "</p>";
	}	
	
	$messagecont .= "<p><b>Calculated Hash</b><br />". $hashcode . "</p>";
	
	$messagecont .= "<p><b>Echoed Repsonse:</b><br />StatusCode=".$nOutputProcessedOK."&Message=".$szOutputMessage."</p>";
			
	$headers  = "From: ".$from."\r\n"; 
	$headers .= "Content-type: text/html\r\n"; 
	
	$success = mail($to, $subject, $messagecont, $headers);
}

// output the status code and message letting the payment form
// know whether the transaction result was processed successfully
echo("StatusCode=".$nOutputProcessedOK."&Message=".$szOutputMessage);	
?>