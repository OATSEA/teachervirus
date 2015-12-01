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

function createhash($PreSharedKey, $Password) {
    $str = "PreSharedKey=" . $PreSharedKey;
    $str = $str . '&MerchantID=' . $_GET["MerchantID"];
    $str = $str . '&Password=' . $Password;
    $str = $str . '&CrossReference=' . $_GET["CrossReference"];
    $str = $str . '&OrderID=' . $_GET["OrderID"];
    return sha1($str);
}

function checkhash($PreSharedKey, $Password) {
    $str1 = $_GET["HashDigest"];
    $hashcode = createhash($PreSharedKey, $Password);
    if ($hashcode == $str1) {
        echo "Thank you for choosing Snaygill Boats. An email confirmation will be sent to you within the next 24hrs. If you have any questions in the meantime please don’t hesitate to contact us.";
    } else {
        echo "Failed!";
    }
}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- saved from url=(0070)https://securehost5.zen.co.uk/canal/secure/snaygill/online_booking.htm -->
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en" class="chrome chrome43"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                     <!--
                     Created by Artisteer v3.1.0.46558
                     Base template (without user's data) checked by http://validator.w3.org : "This page is valid XHTML 1.0 Transitional"
                     -->


                     <title>Canal Holiday Hire - The Best Canal Holiday Hire on UK Canals - Snaygill 
                            Boats </title>

                     <meta http-equiv="Content-Language" content="en-gb">



                            <meta name="keywords" content="canal holiday">

                                   <meta name="description" content="Canal holiday hire from Snaygill Boats, a family firm based on the beautiful Leeds &amp; Liverpool canal.">



                                          <link rel="stylesheet" href="./form_files/style.css" type="text/css" media="screen">
                                                 <!--[if IE 6]><link rel="stylesheet" href="style.ie6.css" type="text/css" media="screen" />
                                                 <![endif]-->
                                                 <!--[if IE 7]><link rel="stylesheet" href="style.ie7.css" type="text/css" media="screen" />
                                                 <![endif]-->

                                                 <script type="text/javascript" src="./form_files/jquery.js"></script><style type="text/css"></style>
                                                 <script type="text/javascript" src="./form_files/script.js"></script>

                                                 <style type="text/css">
                                                        .style1 {
                                                               border-color: #FFFFFF;
                                                               border-width: 0px;
                                                        }
                                                        .style2 {
                                                               border-color: #FFFFFF;
                                                               border-width: 0px;
                                                        }
                                                        .style3 {
                                                               border-style: none;
                                                               border-width: 0px;
                                                        }
                                                 </style>

                                                 </head>
                                                 <body>
                                                        <div id="art-main">
                                                               <div class="cleared reset-box"></div>
                                                               <div class="art-box art-sheet">
                                                                      <div class="art-box-body art-sheet-body">
                                                                             <div class="art-header">
                                                                                    <div class="art-logo">
                                                                                    </div>

                                                                             </div>
                                                                             <div class="cleared reset-box"></div>
                                                                             <div class="art-bar art-nav">
                                                                                    <div class="art-nav-outer">
                                                                                           <ul class="art-hmenu">
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/index.htm" class="active">
                                                                                                                Welcome</a></li>	
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/about-us.htm">About us</a>

                                                                                                         <ul>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/about-us.htm" class="">About 
                                                                                                                              Snaygill Boats</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/boatyard.htm" class="">Boatyard &amp; 
                                                                                                                              Moorings</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/boat_sales.htm">Boat 
                                                                                                                              Sales</a></li>
                                                                                                         </ul>	
                                                                                                  </li><li><a href="http://www.snaygillboats.co.uk/routes.htm">Routes</a>
                                                                                                         <ul>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/routes.htm">Our Routes</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/canal_holiday.htm">
                                                                                                                              Places to Visit</a></li>
                                                                                                         </ul>
                                                                                                  </li>
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/narrowboats.htm">Our Boats</a>
                                                                                                         <ul>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/narrowboats.htm">Our 
                                                                                                                              Boats</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/our-boats/sorrel.htm">
                                                                                                                              Sorrel</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/our-boats/juniper.htm">
                                                                                                                              Juniper</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/our-boats/caraway.htm">
                                                                                                                              Caraway</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/our-boats/tamarind.htm">
                                                                                                                              Tamarind</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/our-boats/sweet-basil.htm">
                                                                                                                              Sweet Basil</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/our-boats/nutmeg.htm">
                                                                                                                              Nutmeg</a></li>
                                                                                                         </ul>
                                                                                                  </li>	
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/short_break.htm">Short Break</a></li>	
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/day_boats.htm">Day Hire</a></li>	
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/prices.htm">Prices</a>	
                                                                                                         <ul>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/prices.htm">Weekly 
                                                                                                                              Prices</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/short_break.htm">Short 
                                                                                                                              Break Prices</a></li>
                                                                                                         </ul>
                                                                                                  </li>	
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/late_bookings.htm">Late 
                                                                                                                Offers</a></li>	
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/booking.htm">Booking</a>
                                                                                                         <ul>			
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/booking.htm">How to Book</a></li>
                                                                                                                <li><a href="./form_files/form.html">
                                                                                                                              Online Booking Form</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/pdf/booking-form.pdf">
                                                                                                                              Printout Booking Form</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/avail.htm">Availability 
                                                                                                                              Request Form</a></li>                
                                                                                                         </ul>			
                                                                                                  </li>	
                                                                                                  <li><a href="http://www.snaygillboats.co.uk/contact.htm">Contact</a>
                                                                                                         <ul>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/contact.htm">Contact us</a></li>
                                                                                                                <li><a href="http://www.snaygillboats.co.uk/links.htm">Useful Links</a></li>
                                                                                                         </ul>
                                                                                                  </li>	
                                                                                           </ul>

                                                                                    </div>
                                                                             </div>
                                                                             <div class="cleared reset-box"></div>
                                                                             <div class="art-layout-wrapper">
                                                                                    <div class="art-content-layout">
                                                                                           <div class="art-content-layout-row">

                                                                                                  <div class="art-layout-cell art-content">

                                                                                                         <div class="art-box art-post">
                                                                                                                <div class="art-box-body art-post-body">
                                                                                                                       <div class="art-post-inner art-article">
                                                                                                                              


                                                                                                                                     <div class="art-postcontent">
                                                                                                                                            <span lang="en-gb">
<strong><h1 class="big-message">
                                                                                                                                                   <?php
                                                                                                                                                   echo 'Order ' . $_GET["OrderID"] . '<br><br>';
                                                                                                                                                   checkhash($PreSharedKey, $Password);
                                                                                                                                                   ?>     
              </h1>
</strong>
                                                                                                                                            </span>
                                                                                                                                     </div>
                                                                                                                       </div>


                                                                                                                </div>
                                                                                                         </div>


                                                                                                  </div>
                                                                                           </div>
                                                                                    </div>
                                                                             </div>
                                                                             <div class="cleared"></div>
                                                                             <div class="art-footer">
                                                                                    <div class="art-footer-body">
                                                                                           <a href="https://securehost5.zen.co.uk/canal/secure/snaygill/online_booking.htm#" class="art-rss-tag-icon" title="RSS"></a>
                                                                                           <div class="art-footer-text">
                                                                                                  <p><a href="https://securehost5.zen.co.uk/canal/secure/snaygill/narrbowboats.htm">Narrowboat Hire 
                                                                                                                in Yorkshire</a> | <a href="https://securehost5.zen.co.uk/canal/secure/snaygill/short_break.htm">
                                                                                                                Short Break Narrowboat Hire</a> |&nbsp;<a href="https://securehost5.zen.co.uk/canal/secure/snaygill/routes.htm">Leeds 
                                                                                                                &amp; Liverpool Canal Routes</a></p>

                                                                                                  <p>Copyright ? Snaygill Boats 2011. All Rights Reserved.</p>
                                                                                           </div>
                                                                                           <div class="cleared"></div>
                                                                                    </div>
                                                                             </div>
                                                                             <div class="cleared"></div>
                                                                      </div>
                                                               </div>
                                                               <div class="cleared"></div>
                                                               <div class="cleared"></div>
                                                        </div>



                                                        <script id="hiddenlpsubmitdiv" style="display: none;"></script><script>try {
                                                                   for (var lastpass_iter = 0; lastpass_iter < document.forms.length; lastpass_iter++) {
                                                                          var lastpass_f = document.forms[lastpass_iter];
                                                                          if (typeof (lastpass_f.lpsubmitorig2) == "undefined") {
                                                                                 lastpass_f.lpsubmitorig2 = lastpass_f.submit;
                                                                                 if (typeof (lastpass_f.lpsubmitorig2) == 'object') {
                                                                                        continue;
                                                                                 }
                                                                                 lastpass_f.submit = function () {
                                                                                        var form = this;
                                                                                        var customEvent = document.createEvent("Event");
                                                                                        customEvent.initEvent("lpCustomEvent", true, true);
                                                                                        var d = document.getElementById("hiddenlpsubmitdiv");
                                                                                        if (d) {
                                                                                               for (var i = 0; i < document.forms.length; i++) {
                                                                                                      if (document.forms[i] == form) {
                                                                                                             if (typeof (d.innerText) != 'undefined') {
                                                                                                                    d.innerText = i;
                                                                                                             } else {
                                                                                                                    d.textContent = i;
                                                                                                             }
                                                                                                      }
                                                                                               }
                                                                                               d.dispatchEvent(customEvent);
                                                                                        }
                                                                                        form.lpsubmitorig2();
                                                                                 }
                                                                          }
                                                                   }
                                                            } catch (e) {
                                                            }</script></body></html>