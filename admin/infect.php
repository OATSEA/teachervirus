<?php
// explain how to be infectious

// $myIP = $_SERVER['SERVER_ADDR'];

// Alternative from http://stackoverflow.com/questions/3219178/php-how-to-get-local-ip-of-system
$myIP = getHostByName(getHostName());

echo "<!DOCTYPE html><html><title>Be Infectious</title></head><body>
  <h1>Be Infectious!</h1>
  <p>To infect another device provide the owner/administrator with the IP Address:</p>
  <p><b> $myIP </b></p>
  <hr>
  </body></html>
  ";
?>
