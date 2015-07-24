<html>
    <head>
        <title>Payloads</title>
        <meta charset="utf-8">
        <link href="../buttons.css" rel="stylesheet">
        <link href="../../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <script src="../../js/jquery.js" type="text/javascript"></script>
        <style>
            body{
                    background-color: black;
                    min-height:800px;
                    padding: 0px;
                    margin: 0;
                    color: #fff;
                    text-align: left;
                }
            form{
                border: 1px solid #fff;
                margin-left: 25%;
                padding: 15px;
                width: 50%;
            }
            .error-message{
                color: red;
                float: right;
                margin-bottom: 10px;
                width: 250px;
            }
            .text-field{
                float: left;
                padding-right: 10px;
                width: 200px;
            }
            .example-text{
                text-align: center;
                width: 100%;
            }
            .go-button{
                float: right;
            }
            .go-button > input{
                color: #000;
            }
            .admin_img {
                color: #fff;
                float: right;
                padding-bottom: 10px;
                padding-right: 20px;
                padding-top: 10px;
            }
            .color-white{
                color: #fff;
                line-height: 15px;
            }
            input[type="text"] {
                color: #000;
                float: left;
                width: 30%;
                display: block;
                margin-bottom: 10px;
                background-color: wheat;
            }
            .payload-details{
                border-bottom: 1px solid #fff;
                margin-bottom: 20px;
                text-align: center;
                width: 100%;
            }
            .mandatory{
                font-weight: bold;
                font-size: 18px;
            }
        </style>
    </head>
    <body class="main">
<?php
//session_start();
    $debug = isset($_POST['show_debug']) ? $_POST['show_debug'] : 0;
    $protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST'];
    
    $_SESSION['isValidation']['flag'] = TRUE;
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_SESSION['isValidation']))
    {
        $sUserName = $_POST['user_name'];
        $sRepository = $_POST['repository'];
        $sDeviceAddress = $_POST['device_address'];
        $nPort = $_POST['port_number'];
        $sInfectUserName = $_POST["infect_user_name"];
        $sInfectRepository = $_POST["infect_repository"];
        $sPayloadName = $_POST['payload_name'];
        $sPayloadUrl = $_POST["payload_url"];
        $sGooglePayloadName = $_POST['google_payload_name'];
        $sGoogleDriveLink = $_POST['google_drive_link'];
        $sIsAdmin = empty($_POST['check_admin']) ? '' : $_POST['check_admin'];
        
        if($_POST['payload_source'] == 'github_payloads')
        {
            if(empty($sUserName))
            {
                $_SESSION['isValidation']['user_name_required'] = 'Please enter username!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            if(empty($sRepository))
            {
                $_SESSION['isValidation']['repository_required'] = 'Please enter repository!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
        }
        else if($_POST['payload_source'] == 'infected_device')
        {
            if(empty($sDeviceAddress))
            {
                $_SESSION['isValidation']['device_address'] = 'Please enter device address!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            if(empty($sInfectUserName))
            {
                $_SESSION['isValidation']['infect_user_name'] = 'Please enter username!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
        }
        else if($_POST['payload_source'] == 'website_url')
        {
            if(empty($sPayloadName))
            {
                $_SESSION['isValidation']['payload_name'] = 'Please enter payload name!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            if(empty($sPayloadUrl))
            {
                $_SESSION['isValidation']['payload_url'] = 'Please enter payload url!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
        }
        else
        {
            if(empty($sGooglePayloadName))
            {
                $_SESSION['isValidation']['google_payload_name'] = 'Please enter payload name!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            if(empty($sGoogleDriveLink))
            {
                $_SESSION['isValidation']['google_drive_link'] = 'Please enter google drive payload id!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
        }
        
        if($_SESSION['isValidation']['flag'] == 1)
        {
            $payload = (isset($_POST['check_admin']) && ($_POST['check_admin'] == 1)) ? 'admin' : 'payloads';
            $isAdmin = ($payload == 'admin') ? 'A' : 'G';
            if(!empty($sUserName))
            {
                $download_filename = $sUserName."-".$sRepository.".zip";
                $download_unzip_filename = $sUserName."-".$sRepository;
                $sListContent = "github_payloads;$isAdmin;$sUserName;$sRepository";
            }
            else if(!empty($sDeviceAddress))
            {
                $download_filename = empty($sInfectRepository) ? $sInfectUserName.".zip" : $sInfectUserName."-".$sInfectRepository.".zip";
                $download_unzip_filename = empty($sInfectRepository) ? $sInfectUserName.".zip" : $sInfectUserName."-".$sInfectRepository;
                $payloadName = $sInfectUserName."-".$sInfectRepository;
                $sPort = empty($nPort) ? 'none' : $nPort;
                $sFinalInfectRepository = empty($sInfectRepository) ? 'none' : $sInfectRepository;
                $sListContent = "infected_device;$isAdmin;$sDeviceAddress;$sPort;$sInfectUserName;$sFinalInfectRepository";
            }
            else if(!empty($sPayloadName))
            {
                $download_filename = $sPayloadName.".zip";
                $download_unzip_filename = $sPayloadName;
                $sListContent = "website_url;$isAdmin;$download_unzip_filename;$sPayloadUrl";
            }
            else if(!empty($sGooglePayloadName))
            {
                $download_filename = $sGooglePayloadName.".zip";
                $download_unzip_filename = $sGooglePayloadName;
                $sListContent = "google_drive;$isAdmin;$download_unzip_filename;$sGoogleDriveLink";
            }
            $zipfile = $payload.DIRECTORY_SEPARATOR.$download_filename;
            
            // getpayload is the initial payload PHP Installation script that is used to install the core Payload files.
            // Created: May 2015
            // Contributors: Harry Longworth
            // License: Apache 2.0
            // TO DO:
            // - multi lingual version?

            // file needs permission 755
            // Issues with CURL:
            // - doesn't work out of the box with standard RPI
            // - file permissions not set
            // so try copy first and then CURL

            if ($debug) {
                ini_set('display_errors',1);
                ini_set('display_startup_errors',1);
                error_reporting(-1);
            } 

            // ERROR HANDLING try below maybe?
            // SOURCE: http://stackoverflow.com/questions/1475297/phps-white-screen-of-death

            // ------------------------
            // Declare Helper Functions
            // -------------------------

            // RRMDIR: Recursively remove subdirectories function 
            // SOURCE: taken http://php.net/manual/en/function.rmdir.php 
            function rrmdir($dir) { 
               if (is_dir($dir)) { 
                 $objects = scandir($dir); 
                 foreach ($objects as $object) { 
                   if ($object != "." && $object != "..") { 
                     if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
                   } 
                 } 
                 reset($objects);
                 rmdir($dir); 
               } 
            } // END RRMDIR

            //-------
            // prompt for IP address as alternative payloads

            function promptForIP() {
                // Prompt for IP of alternative device and reload page

                $thisurl = $_SERVER["SCRIPT_NAME"];
                // reload page script:
                echo "<script>
                function buttonClick() {
                    var address = document.getElementById('address').value;     
                    window.location ='$thisurl?ip='+address;
                } 
                </script>";

                echo "<h1>Try Alternate Source?</h1>
                <p>Enter IP address or DNS of payload device</p>
                <p><b>Tip:</b> You can find the IP address of an payload device in the admin page of Payload.</p>
                <p>Address of Payload Device:</p>
                <p><input id='address' type='text' name='address' required></p>
                <p><button type='button' onclick='buttonClick();'>Go!</button></p>
                ";

                exit("<hr>");

            } // END promptForIP

            //----------
            //Make a new directory with optional error messages
            function makeDIR($directory,$debugtxt=0) {
                // Create payload directory if it doesn't exist:
                if (file_exists($directory)) {
                    //if ($debugtxt) { echo "<p>Directory <b>$directory</b> already exists </p>"; }
                    $result = true; // Return true as success is when the directory has either been created or already exists
                } else {
                    // Make the new temp sub_folder for unzipped files
                    if (!mkdir($directory, 0755, true)) {
                        if ($debugtxt) { echo "<p>Error: Could not create folder <b>$directory</b> - check file permissions";}
                        $result= false;
                    } else { 
                        //if ($debugtxt) { echo "Folder <b>$directory</b> Created <br>";}  
                        $result = true;
                    } // END mkdir
                } // END if file exists
                return $result;
            } // END makeDIR 


            //---------
            // Move Directory

            function moveDIR($dir,$dest="") {
                $debug = 1;
                $result=true;

                if($debug) { echo "<h2>Moving directory</h2><p> From:<br> $dir <br>To: $dest</p>";}

                $path = dirname(__FILE__);
                $files = scandir($dir);

                foreach($files as $file) {
                    if (substr( $file ,0,1) != ".") {
                        $pathFile = $dir.'/'.$file;
                        if (is_dir($pathFile)) {
                            if($debug) { echo "<p><b>Directory:</b> $pathFile</p>"; }

                            $newDir = $dest."/".$file;

                            if (!moveDIR($pathFile,$newDir)) {
                                $result = false;
                            }

                        } else {
                            echo "<p>$pathFile is a file</p>";

                            // $currentFile = realpath($file); // current location
                            $currentFile = $pathFile;

                            $newFile = $dest."/".$file;

                            if (!file_exists($dest)) {
                                makeDIR($dest);
                            }
                            // if file already exists remove it
                            if (file_exists($newFile)) {
                                if($debug) { echo "<p>File $newFile already exists - Deleting</p>"; }
                                unlink($newFile);
                            } else {
                                if($debug) { echo "<p>File $newFile doesn't exist yet</p>"; }
                            }

                            // Move via rename
                            // rename(oldname, newname)
                            if (rename($currentFile , $newFile)) {
                                if($debug) { echo "<p>Moved $currentFile to $newFile</p>"; }
                            } else {
                                if($debug) { echo "<p>Failed to move $currentFile to $newFile</p>"; }
                                $result = false;
                            } // END rename 

                        } // END if dir or file
                    } // end if no dot
                } // END foreach
                return $result;
            } // END moveDIR

            // -------------
            // REDIRECT PAGE

            //

            function displayRedirect() {
                echo "
                    <!DOCTYPE HTML>
                    <html lang='en-US'>
                    <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='refresh' content='1;url=play'>
                    <script type='text/javascript'>
                        window.location.href = 'play';
                    </script>
                    <title>Loading Payload</title>
                    </head>
                    <body>
                        <!-- Note: don't tell people to `click` the link, just tell them that it is a link. -->
                        <p>If you are not redirected automatically, follow the <a href='play'>link</a><p>
                    </body>
                    </html>
                    ";
            } // END displayRedirect
            
            //-----------
            // CHECK for Play Dir
            // -----------

            // Check play dir exists or not
            if (file_exists('play')) {
                // if play folder exists then Payload is already installed and we don't want to allow script to run again so
                displayRedirect();

            } else {
                if ($debug) { echo "<h1>Start <b>Payload</b> Installation!</h1>";}
                // play folder doesn't exist
                // Check if ip param is set to either an IP address or a url (i.e. without http:// infront)    
                //$ip="10.1.1.38" or "test.teachervirus.org"

                if(isset($sDeviceAddress)&&(!empty($sDeviceAddress))) {
                    $ip= $sDeviceAddress;
                    echo "<p>Address has been provided as: $ip</p>";
                } else {
                    $ip="no";
                } // end IP is set check

            } //  END play check

            //----------------------------------    
            // Download OATSEA-teachervirus.zip 
            // ------------------------------------
            if ($debug) { echo "<h2>Attempting to Download Payload</h2>"; }
            
            // default destination for downloaded zipped files

            // Create payload directory if it doesn't exist:
            if (!makeDIR($payload,true)) { 
                    // failed to make directory so exit
                    exit("<h3>Installation Failed!</h3>");
            }

            // Check for IP param and set $ip if param provided
            // ** TO DO **

            // Download file if OATSEA-teachervirus.zip doesn't already exist
            if (file_exists($zipfile)) 
            {
                if ($debug) { 
                    echo "<p>The Payloads files have already been downloaded to: $zipfile</p>
                    <p>This installation will use the existing file rather than downloading a new version of $sInfectRepository.</p>
                    <p><b>Hint:</b> If you want to download a new version of Payload you will need to:</br>
                    * delete the file: <b>$zipfile</b>.</br>
                    * remove the <b>play</b> folder if it exists</br>
                    * refresh/re-open <b>getpayload</b></p>"; 
                } // END Debug
            }
            else if ($ip == "no")
            {
                // Download from github zipball/master as no IP address set
                $geturl = "https://github.com/$sUserName/$sRepository/zipball/master/";
            }
            else 
            {
                // as IP address has been set attempt download from IP address
                $geturl = empty($nPort) ? "http://$ip/$zipfile" : "http://$ip:$nPort/$zipfile";
            }
            if(!empty($sPayloadName))
            {
                $geturl = "http://$sPayloadUrl/$zipfile";
            }
            if(!empty($sGooglePayloadName))
            {
                $aExplodeLinkID = explode("id=", $sGoogleDriveLink);
                $geturl = "https://docs.google.com/uc?id=$aExplodeLinkID[1]&export=download";
            }
            // TRY DOWNLOAD via copy
            if ($debug) { echo "<h2>Download Files</h2>
               <p>Will attempt to download via copy from <b>$geturl</b></p> ";}

                // ** TO DO ** catch warnings
                // get following error on MAC: 
                // Warning: copy(): SSL operation failed with code 1.
               //if(file_exists($geturl))
               //{
                    umask(0);
                    echo "<h3>Unzip Successful!</h3>";
                    $zip = new ZipArchive;
                    // Get array of all source files
                    $files = scandir(dirname(__FILE__).DIRECTORY_SEPARATOR.$payload);
                    // Identify directories
                    $source = dirname(__FILE__).DIRECTORY_SEPARATOR.$payload;
                    $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
                    
                    $destination = $sFolderPath.DIRECTORY_SEPARATOR.$payload;
                    if (!file_exists($destination))
                        mkdir($destination,0775,true);
                    
                    $copyflag = FALSE;
                    
                    if($ip == "no")
                    {
                        $copyflag = copy($geturl,$_SERVER['DOCUMENT_ROOT'].'/'.$zipfile);
                    }
                    else if(file_exists($geturl))
                    {
                        
                        $copyflag = copy($geturl,$_SERVER['DOCUMENT_ROOT'].'/'.$zipfile); 
                    }
                    
                    if ($debug) {echo "<h2>Attempting to Unzip</h2><p>Zipped file:  $zipfile </p>";}
                    
                    $zipFlag = $zip->open($destination.DIRECTORY_SEPARATOR.$download_filename);
                    
                    if ($zipFlag === TRUE) {
                        $sPayloadUrl = $_SERVER['DOCUMENT_ROOT'].'/'.$payload;
                        if(file_exists($sPayloadUrl))
                        {
                            $zip->extractTo($sPayloadUrl);
                            $files = scandir($sPayloadUrl,1);
                            foreach ($files as $key => $value)
                            {
                               if (!in_array($value,array(".","..")))
                               {
                                  if (is_dir($sPayloadUrl . DIRECTORY_SEPARATOR . $value))
                                  {
                                    if(preg_match("/$download_unzip_filename/",$value))
                                    {
                                        if(is_dir($sPayloadUrl.'/'.$download_unzip_filename))
                                        {
                                            rrmdir($sPayloadUrl.'/'.$download_unzip_filename);
                                        }
                                        rename($sPayloadUrl.'/'.$value,$sPayloadUrl.'/'.$download_unzip_filename);
                                        $myfile = fopen("$sPayloadUrl/$download_unzip_filename/list.txt", "w") or die("Unable to open file!");
                                        $txt = $sListContent;
                                        fwrite($myfile, $txt);
                                        fclose($myfile);
                                        
                                        $myfile = fopen("$destination/list.txt", "w") or die("Unable to open file!");
                                        $txt = $sListContent;
                                        fwrite($myfile, $txt);
                                        fclose($myfile);
                                        $relativePath = substr($destination.DIRECTORY_SEPARATOR.$download_filename.$sPayloadUrl.'/'.$value."/list.txt", strlen($destination.DIRECTORY_SEPARATOR.$download_filename));
                                        // Add current file to archive
                                        $zip->addFile($destination."/list.txt", $relativePath);
                                    }
                                  }
                               }
                            }
                            rrmdir($_SERVER['DOCUMENT_ROOT']."/admin/getpayload/".$payload);
                        }
                        else
                        {
                            mkdir($sPayloadUrl,0775,true);
                            $zip->extractTo($sPayloadUrl.$download_filename);
                            $files = scandir($sPayloadUrl,1);
                            foreach ($files as $key => $value)
                            {
                               if (!in_array($value,array(".","..")))
                               {
                                  if (is_dir($sPayloadUrl . DIRECTORY_SEPARATOR . $value))
                                  {
                                     if(preg_match("/$download_unzip_filename/",$value))
                                     {
                                        if(is_dir($sPayloadUrl.'/'.$download_unzip_filename))
                                        {
                                            rrmdir($sPayloadUrl.'/'.$download_unzip_filename);
                                        }
                                        rename($sPayloadUrl.'/'.$value,$sPayloadUrl.'/'.$download_unzip_filename);
                                        $myfile = fopen("$sPayloadUrl/$download_unzip_filename/list.txt", "w") or die("Unable to open file!");
                                        $txt = $sListContent;
                                        fwrite($myfile, $txt);
                                        fclose($myfile);
                                        
                                        $myfile = fopen("$destination/list.txt", "w") or die("Unable to open file!");
                                        $txt = $sListContent;
                                        fwrite($myfile, $txt);
                                        fclose($myfile);
                                        $relativePath = substr($destination.DIRECTORY_SEPARATOR.$download_filename.$sPayloadUrl.'/'.$value."/list.txt", strlen($destination.DIRECTORY_SEPARATOR.$download_filename));
                                        // Add current file to archive
                                        $zip->addFile($destination."/list.txt", $relativePath);
                                     }
                                  }
                               }
                            } 
                            rrmdir($_SERVER['DOCUMENT_ROOT']."/admin/getpayload/".$payload);
                        }
                    }
                    $zip->close();
                    unlink($destination."/list.txt");
                    
                    if ($copyflag === TRUE) {
                        echo "<h3>Download Succeeded</h3><p>Files downloaded using <b>Copy</b> instead</p>";
                    } else { 
                        // try CURL    

                        if ($debug) { echo "<p>Will attempt to download via CURL from <b>$geturl</b></p> ";}

                        // USE CURL to Download ZIP
                        // Code Attribution:  
                        // http://stackoverflow.com/questions/19177070/copy-image-from-remote-server-over-https    
                        // http://stackoverflow.com/questions/18974646/download-zip-php
                        // http://stackoverflow.com/questions/11321761/using-curl-to-download-a-zip-file-isnt-working-with-follow-php-code

                        set_time_limit(0); //prevent timeout
                        $fp = fopen($_SERVER['DOCUMENT_ROOT'].'/'.$zipfile, 'w+'); // or perhaps 'wb'?
                        if (!$fp) { 
                            exit("<h3><b>ERROR! Payload download failed</h3> 
                            <p>Unable to open temporary file: <b>$zipfile</b>!</p>
                            <p>File permission issue maybe?
                            "); 
                        }

                        // ** TO DO ** add catch exception for curl not installed (e.g. RPI)
                        $ch = curl_init();

                        // CURL settings from Reference: http://php.net/manual/en/function.curl-setopt.php

                        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Don't use!
                        curl_setopt($ch, CURLOPT_URL, $geturl);
                        curl_setopt($ch, CURLOPT_FILE, $fp);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_TIMEOUT, 50); // or 5040? - ** TO DO: Further testing required to optimise setting
                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // was 2 try 0
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
                        // curl_setopt($ch, CURLOPT_SSLVERSION, 4); 
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_FAILONERROR, true);

                        curl_exec($ch);
                        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);  // Check connection status
                        $curl_error_result = curl_error($ch);

                        // Check if there were curl errors
                        if ($curl_error_result) {
                            $curlFlag=0; // Any contents means "true" - i.e. There's an error message so there were errors
                        } else {
                            $curlFlag=1; // false means all good - there were no errors 
                        }

                        $downloadResult=0;
                        if (($http_status==200)&&(file_exists($zipfile))&&($curlFlag)) {
                            if ($debug) {
                                echo "<p> HTTP Status of: $http_status (200 is good)</p>";          
                                echo "<p> Zip file successfully downloaded to $zipfile</p>";
                            }  
                            $downloadResult=1;    
                        } else {
                            if ($debug) {
                                // There was a problem downloading
                                echo "<h3>Curl Download Failed!</h3>
                                    <p>Error Downloading Payload via CURL</p>";
                                echo "<p> HTTP Status of: $http_status (200 is good)</p>";
                                echo "<p> CURL error: ".curl_error($ch)." ...</p>";
                                if (file_exists($zipfile)) {
                                    echo "<p> Destination $zipfile file was created though</p>";
                                }   else {
                                    echo "<p> Destination $zipfile file was <b>NOT</b> created - file permission issue? </p>";
                                }

                            } // END debug

                        } // END http_status and file exists check
                        
                        curl_close($ch);
                        fclose($fp);

                        if (!$downloadResult) {
                            // As download failed delete empty zip file!
                            if ($debug) { echo "<h2>Download with CURL failed</h2>";}
                            echo "<h3>Installation Failed!</h3><p>Couldn't download with either copy or curl</p>";
                            (file_exists($zipfile)) ? unlink($zipfile) : '';
                            //promptForIP();
                        } // If Download failed using CURL 
                    }// END else CURL
                 
            // ---------------------
            // UNZIP downloaded file
            // ---------------------

            // Code Attribution: 
            // http://stackoverflow.com/questions/8889025/unzip-a-file-with-php
            
                
                echo '<h2>Installation Complete!</h2><p>Check installation has worked: </p>'
                    . '<div class="admin_img"><a href="'.$protocol.'/admin" class="color-white"><i class="mainNav fa fa-cog fa-3x"></i></a></div>'
                    . '<div class="play_img"><a href="'.$protocol.'/play/" class="color-white"><i class="mainNav fa fa-play-circle-o fa-3x"></i></a></div>';
                die();
            } // END try alternative move approach
    }
    if($_SESSION['isValidation']['flag'] == 1) 
        unset($_SESSION['isValidation']['user_name_required'],$_SESSION['isValidation']['repository_required']);

    if($_SESSION['isValidation']['flag'] == 1 || count($_SESSION['isValidation']) > 1)
    {
?>
        <script type="text/javascript">
            function showData(divId)
            {
                if(divId == "github_payloads")
                {
                    $("#infected_device").hide();
                    $("#website_url").hide();
                    $("#google_drive").hide();
                }
                else if(divId == "infected_device")
                {
                    $("#github_payloads").hide();
                    $("#website_url").hide();
                    $("#google_drive").hide();
                }
                else if(divId == "website_url")
                {
                    $("#github_payloads").hide();
                    $("#infected_device").hide();
                    $("#google_drive").hide();
                }
                else if(divId == "google_drive")
                {
                    $("#github_payloads").hide();
                    $("#infected_device").hide();
                    $("#website_url").hide();
                }
                $("#"+divId).show();
            }
            function changeValue(eValue = '')
            {
                var isAdmin = document.getElementById('check_admin');
                if(eValue == '')
                {
                    if (isAdmin.checked)
                    {
                        isAdmin.value = 1;
                    }
                    else
                    {
                        isAdmin.value = 0;
                    }
                }
                else if(eValue == 1)
                {
                    document.getElementById("check_admin").checked = true;
                    isAdmin.value = eValue;
                }
                else
                {
                    document.getElementById("check_admin").checked = false;
                    isAdmin.value = eValue;
                }
            }
            function removePort()
            {
                $("#port_number").val('');
            }
            $(document).ready(function(){
                showData("<?php echo isset($_POST['payload_source']) ? $_POST['payload_source'] : 'github_payloads'; ?>");
                changeValue(<?php echo isset($sIsAdmin) ? $sIsAdmin : '' ?>);
            });
        </script>
        <div class="color-white">
            <a class="play_img" href="<?php echo $protocol; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
        </div><br/><br/>
        <form method="post" action="">
            <div id="container">
                <div class="payload-details">
                    <h2>Enter Payloads Details</h2>
                </div>
                <div class="text-field">Is this an Admin Payload? :</div>
                <input type="checkbox" name="check_admin" id="check_admin" value="0" onclick="changeValue('');"/>
                <br/><br/>
                <div class="text-field">Show debug text</div>
                <input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($_POST['show_debug']) ? $_POST['show_debug'] : '0'; ?>" <?php echo isset($_POST['show_debug']) ? "checked='checked'" : ""; ?> onclick="changeValue('show_debug');">
                <br/><br/>
                <div class="text-field">
                    <input type="radio" name="payload_source" id="ckeck_github" value="github_payloads" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "github_payloads") ? "checked='checked'" : "checked='checked'"; ?> onclick="showData('github_payloads');">GitHub
                    <br/><br/>
                    <input type="radio" name="payload_source" id="ckeck_infected" value="infected_device" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "infected_device" ) ? "checked='checked'" : ""; ?> onclick="showData('infected_device');">Infected Device
                    <br/><br/>
                    <input type="radio" name="payload_source" id="ckeck_website" value="website_url" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "website_url" ) ? "checked='checked'" : ""; ?> onclick="showData('website_url');">URL/Website
                    <br/><br/>
                    <input type="radio" name="payload_source" id="ckeck_google" value="google_drive" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "google_drive" ) ? "checked='checked'" : ""; ?> onclick="showData('google_drive');">Google Drive
                    <br/><br/>
                </div><br/><br/><br><br><br><br/><br/><br/><br/>
                <div id="github_payloads">
                    <div class="text-field">GitHub Username<font style="color:red">*</font> :</div>
                    <input type="text" name="user_name">
                    <div class="error-message">
                        <?php echo isset($_SESSION['isValidation']['user_name_required']) ? $_SESSION['isValidation']['user_name_required'] : '';?>
                    </div>
                    <br/><br/>
                    <div class="text-field">GitHub Repository<font style="color:red">*</font> :</div>
                    <input type="text" name="repository">
                    <div class="error-message">
                        <?php echo isset($_SESSION['isValidation']['repository_required']) ? $_SESSION['isValidation']['repository_required'] : '';?>
                    </div>
                </div>
                <div id="infected_device" style="display:none">
                    <div class="text-field">Device Address (IP or URL)<font style="color:red">*</font> :</div>
                    <input type="text" name="device_address">
                    <div class="error-message">
                        <?php echo isset($_SESSION['isValidation']['device_address']) ? $_SESSION['isValidation']['device_address'] : '';?>
                    </div><br/><br/>
                    <div class="example-text">Example: 192.168.143.1</div>
                    <br/><br/>
                    <div class="text-field">Port :</div>
                    <input type="text" name="port_number" id="port_number" value="8080">
                    <a href="javascript:void(0);" onclick="removePort();"><i class="fa fa-times"></i></a>
                    <br/><br/>
                    <div class="text-field">GitHub Username<font style="color:red">*</font> :</div>
                    <input type="text" name="infect_user_name">
                    <div id="infect_user_input" class="error-message">
                        <?php echo isset($_SESSION['isValidation']['infect_user_name']) ? $_SESSION['isValidation']['infect_user_name'] : '';?>
                    </div>
                    <br/><br/>
                    <div class="text-field">GitHub Repository:</div>
                    <input type="text" name="infect_repository">
                </div>
                <div id="website_url" style="display:none">
                    <div class="text-field">Payload Name<font style="color:red">*</font> :</div>
                    <input type="text" name="payload_name">
                    <div class="error-message">
                        <?php echo isset($_SESSION['isValidation']['payload_name']) ? $_SESSION['isValidation']['payload_name'] : '';?>
                    </div>
                    <br/><br/>
                    <div class="text-field">URL<font style="color:red">*</font> :</div>
                    <input type="text" name="payload_url">
                    <div id="url_input" class="error-message">
                        <?php echo isset($_SESSION['isValidation']['payload_url']) ? $_SESSION['isValidation']['payload_url'] : '';?>
                    </div>
                </div>
                <div id="google_drive" style="display:none">
                    <div class="text-field">Payload Name<font style="color:red">*</font> :</div>
                    <input type="text" name="google_payload_name">
                    <div class="error-message">
                        <?php echo isset($_SESSION['isValidation']['google_payload_name']) ? $_SESSION['isValidation']['google_payload_name'] : '';?>
                    </div>
                    <br/><br/>
                    <div class="text-field">Google Drive Link<font style="color:red">*</font> :</div>
                    <input type="text" name="google_drive_link">
                    <div id="url_input" class="error-message">
                        <?php echo isset($_SESSION['isValidation']['google_drive_link']) ? $_SESSION['isValidation']['google_drive_link'] : '';?>
                    </div>
                    <br/><br/>
                    <div class="example-text">Note: Provide the Google Drive Link obtained from "get link" option in Drive.</div><br/>
                </div>
                <br/><div class="go-button">
                    <input type="submit" name="button" id="button" value="GO!" align="center">  
                </div><br/>
                <div><font style="color:red">*</font> indicates mandatory field</div>
            </div>
        </form>
<?php
}
?>
    </body>
</html>
