<html>
    <head>
        <title></title>
<?php
    require_once("../../data/constants.php");
    require(ROOT_DIR.'/admin/checkLogin.php');
    $sSiteUrl = SITE_URL;
    if(isset($_SERVER["SERVER_ADDR"])){
      $myIP = $_SERVER['SERVER_ADDR'];
    } else {
      $myIP = "SERVER_ADDR not SET";
    } // END isset
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $sSiteUrl = trim($protocol);
        $myIP = $sSiteUrl;
    }
?>
        <link href="<?php echo $sSiteUrl; ?>/admin/buttons.css" rel="stylesheet">
        <link href="<?php echo $sSiteUrl; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo $sSiteUrl; ?>/admin/changePassword/_style/changePassword.css"/>
        <script src="<?php echo $sSiteUrl; ?>/admin/changePassword/js/jquery-1.11.1.js"></script>
        <script src='<?php echo $sSiteUrl; ?>/js/jquery.imagefit.js'></script>
        <script src="<?php echo $sSiteUrl; ?>/admin/buttons.js"></script>
        <script src="<?php echo $sSiteUrl; ?>/admin/changePassword/_script/changePassword.js"></script>
    </head>
    <body style="text-align: left;padding-left: 20px;">
        <div class="color-white">
            <a class="play_img" href="<?php echo $sSiteUrl.'/admin'; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
        </div>
                    
<?php
    // Explain how to be infectious
    // Provide IP address of device on local network
    //
    // ISSUE!
    // because we're normally accessing from "localhost" it may just return localhost or 127.0.0.1 which are of no use
    // alternative solution from:
    // http://stackoverflow.com/questions/1814611/how-do-i-find-my-servers-ip-address-in-phpcli
    // doesn't work though

    // May have to do this functionality via native Android?
    
    
    $debug = 1;

    /*
    if(stristr(PHP_OS, 'WIN')) {
      //  Rather hacky way to handle windows servers
      // ISSUE: MAC is detected as windows??
      if ($debug) { echo "<p>Windows OS</p>";}
      exec('ipconfig /all', $catch);
      foreach($catch as $line) {
        if(eregi('IP Address', $line)) {
          // Have seen exec return "multi-line" content, so another hack.
          if(count($lineCount = split(':', $line)) == 1) {
            list($t, $ip) = split(':', $line);
            $ip = trim($ip);
          } else {
            $parts = explode('IP Address', $line);
            $parts = explode('Subnet Mask', $parts[1]);
            $parts = explode(': ', $parts[0]);
            $ip = trim($parts[1]);
          } // END if count
          if(ip2long($ip > 0)) {
            // echo 'IP is '.$ip."\n";
            $myIP2 = $ip;
          } else {
                // ; // TODO: Handle this failure condition.
          } // END ip2long
        } // END eregi  
      } // END foreach
    } else {
    */
      // ASSUME Linux only
//      if ($debug) { echo "<p>Linux OS</p>";}
//      $ifconfig = shell_exec('/sbin/ifconfig eth0');

//      if ($ifconfig) {
//        if ($debug) { echo "<p>IFCONFIG: $ifconfig</p>";}
//        preg_match('/addr:([\d\.]+)/', $ifconfig, $match);
//        $myIP2 = $match[1];
//      } else {
//        $myIP2 = "ifconfig failed";
//      } // END check ifconfig worked
    // } // END win or linux check

    // Alternative from http://stackoverflow.com/questions/3219178/php-how-to-get-local-ip-of-system
    $myIP3 = getHostByName(getHostName());

    echo "<!DOCTYPE html><html><title>Be Infectious</title></head><body>
      <h1>Be Infectious!</h1>
      <p>To infect another device provide the owner/administrator with the IP Address:</p>
      <p style='font-size:25px;'><b> $myIP</b></p>
      <p>or</p>
      <p style='font-size:25px;'><b> $myIP3 </b></p>
      <hr>
      </body></html>
      ";
?>
</body>
</html>