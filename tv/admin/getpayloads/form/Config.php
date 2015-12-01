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

//You will need to edit this file and set the various variable values BEFORE you upload the files to your server.

//WEBSITE ADDRESS
//EXAMPLE: https://www.mysite.com
//INCLUDE: the folder which the files are situated on the server
//DO NOT INCLUDE: a trailing / at the end
$WebAddress = "http://www.snaygillboats.co.uk/form";

//PRE-SHARED KEY
//EXAMPLE: 3423+1CVCrI0Lf2Z7Uhuji879mdHKKB7Du27uHySDSD=P1
//NOTE: This Preshared key is unique to your account.
//		It can be found by logging into your the CardSave Merchant Management System
//		and looking under the "Merchant Details" menu option.
$PreSharedKey = "ITn3KnplLPBZEApYH2BTiHJB4Z6ltKiRyF8rQVhXCY/JlimO";

//ECOM MERCHANT ID
//EXAMPLE: Cardsa-1234567
//NOTE: Your ECOM Merchant ID was supplied to you via email when your account went live.
//		If you need to check your test or live Merchant IDs, login to the CardSave Merchant Mangement System
//		and select "Gateway Account Admin". You can also change the gateway password from this page.
//		Your Merchant ID will NOT begin with the word "Merchant".
$MerchantID = "Snaygi-2524579";

//ECOM MERCHANT PASSWORD
//EXAMPLE: Mypassword1234
//NOTE: Your ECOM Merchant Password was set when you first logged into the CardSave Merchant Management System.
//		If you need to check your test or live Merchant IDs, login to the CardSave Merchant Mangement System
//		and select "Gateway Account Admin". You can also change the gateway password from this page.
//		Your Merchant Password will NOT contain any symbols, only letters and numbers.
$Password = "Snay2015gill";

//EMAIL POSTBACK RESULT
//EXAMPLE: TRUE
//OPTIONS: TRUE or FALSE
//NOTE: It may be useful to enable this for troubleshooting updating the PaymentFormHostedResult.php.
//It will email the posted variables, and the result displayed to the gateway.
//We recommend you set this to FALSE when your site is live.
$EmailResult = TRUE;

//EMAIL POSTBACK RESULT TO ADDRESS
//EXAMPLE: me@myemail.com
$ToAddress = "info@snaygillboats.co.uk";
///$ToAddress = "amindiary@gmail.com";

//EMAIL POSTBACK RESULT TO ADDRESS
//EXAMPLE: website@mysite.com
$FromAddress = "no-reply@snaygillboats.co.uk";
?>