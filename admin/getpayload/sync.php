<?php
session_start();
function listFolderFiles($dir,$sHiddenName,$sCheckId)
{
    $sNewDirPath = $_SERVER['DOCUMENT_ROOT'].'/'.$dir;
    $ffs = array();
    if(is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$dir))
    $ffs = scandir($_SERVER['DOCUMENT_ROOT'].'/'.$dir);
    $nHiddenCnt = 0;
    foreach($ffs as $ff)
    {
        if($dir == "payloads" || $dir == "admin")
        {
            if(is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$dir.'/'.$ff) && $ff != '.' && $ff != '..')
            {
    ?>
    
                <input type='checkbox' id='<?php echo $sCheckId.'_'.$nHiddenCnt ?>' onclick='setHiddenValue("<?php echo $sHiddenName.'_'.$nHiddenCnt ?>","<?php echo $sCheckId.'_'.$nHiddenCnt ?>","<?php echo $sNewDirPath.'/'.$ff ?>");'><?php echo $ff ?>
                <input type='hidden' id='<?php echo $sHiddenName.'_'.$nHiddenCnt ?>' name='<?php echo $sHiddenName.'_'.$sHiddenName.'_'.$nHiddenCnt ?>'><br/><br/>
    <?php
                $nHiddenCnt++;
            }
        }
        else
        {
            $extension = pathinfo($ff, PATHINFO_EXTENSION);
            if ($extension == 'zip') {
    ?>
                    <input type='checkbox' id='<?php echo $sCheckId.'_'.$nHiddenCnt ?>' onclick='setHiddenValue("<?php echo $sHiddenName.'_'.$nHiddenCnt ?>","<?php echo $sCheckId.'_'.$nHiddenCnt ?>","<?php echo $sNewDirPath.'/'.$ff ?>")'><?php echo $ff ?>
                    <input type='hidden' id='<?php echo $sHiddenName.'_'.$nHiddenCnt ?>' name='<?php echo $sHiddenName.'_'.$nHiddenCnt ?>'><br/><br/>
    <?php
                    //$_SESSION['nHiddenCnt'] = isset($_SESSION['nHiddenCnt']) ? $_SESSION['nHiddenCnt'] + 1 : $nHiddenCnt + 1;
                    $nHiddenCnt++;
            }
        }
    }
}
// RRMDIR: Recursively remove subdirectories function 
// SOURCE: taken http://php.net/manual/en/function.rmdir.php 
function rrmdir($dir) 
{
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
   else
   {
       (file_exists($dir)) ? unlink($dir) : '';
       if (preg_match('/admin/',$dir))
           rrmdir ($_SERVER['DOCUMENT_ROOT'].'infect/admin');
       
       if (preg_match('/payloads/',$dir))
               rrmdir ($_SERVER['DOCUMENT_ROOT'].'infect/payloads');
   }
} // END RRMDIR

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete']))
{
    foreach ($_POST as $aPost)
    {
        (empty($aPost)) ? '' :rrmdir($aPost);
    }
}

    $protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST'];
    
    $_SESSION['isValidation']['flag'] = TRUE;
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_SESSION['isValidation']) && isset($_POST['go_btn']))
    {
        $sUserName = $_POST['user_name'];
        $sRepository = $_POST['repository'];
        $sDeviceAddress = $_POST['device_address'];
        $nPort = $_POST['port_number'];
        $sInfectUserName = $_POST["infect_user_name"];
        $sInfectRepository = $_POST["infect_repository"];
        $sPayloadName = $_POST['payload_name'];
        $sPayloadUrl = $_POST["payload_url"];
        $sIsAdmin = empty($_POST['ckeck_admin']) ? '' : $_POST['ckeck_admin'];
        
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
        else
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
        
        if($_SESSION['isValidation']['flag'] == 1)
        {
            $payload = (isset($_POST['ckeck_admin']) && ($_POST['ckeck_admin'] == 1)) ? 'admin' : 'payloads';
            //$currentDate = date('d_m_Y', time());
            
            if(!empty($sUserName))
            {
                $sInfectDir = 'infect'.DIRECTORY_SEPARATOR;
                $download_filename = $sUserName."-".$sRepository.".zip";
                $payloaddir = $sInfectDir.$payload; // payload directory with trailing slash for URL use
            }
            else if(!empty($sDeviceAddress))
            {
                $sInfectDir = 'infect'.DIRECTORY_SEPARATOR;
                $download_filename = empty($sInfectRepository) ? $sInfectUserName.".zip" : $sInfectUserName."-".$sInfectRepository.".zip";
                $payloaddir = $sInfectDir.$payload; 
            }
            else if(!empty($sPayloadName))
            {
                $sInfectDir = 'infect'.DIRECTORY_SEPARATOR;
                
                $download_filename = $sPayloadName.".zip";
                $payloaddir = $sInfectDir.$payload; // payload directory with trailing slash for URL use
            }
            
            $zipfile = $payloaddir.DIRECTORY_SEPARATOR.$download_filename;
            $oldfilename = $payloaddir.DIRECTORY_SEPARATOR.'old_'.$download_filename;
            if(file_exists($_SERVER['DOCUMENT_ROOT'].$zipfile))
            {
                rename($_SERVER['DOCUMENT_ROOT'].$zipfile,$_SERVER['DOCUMENT_ROOT'].$oldfilename);
            }
            
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

            $debug=1;
            
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
            /*function rrmdir($dir) { 
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
            }*/ // END RRMDIR

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
                echo $geturl = empty($nPort) ? "http://$ip/$zipfile" : "http://$ip:$nPort/$zipfile";
            }
            if(!empty($sPayloadName))
            {
                $geturl = "http://$sPayloadUrl/$zipfile";
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
                    $zip = new ZipArchive;
                    echo "<h3>Unzip Successful!</h3>"; 
                    // Get array of all source files
                    $files = scandir(dirname(__FILE__).DIRECTORY_SEPARATOR.$payload);
                    // Identify directories
                    $source = dirname(__FILE__).DIRECTORY_SEPARATOR.$payload;
                    $sInfectFolderPath = $_SERVER['DOCUMENT_ROOT'].'infect';
                    if (!file_exists($sInfectFolderPath))
                        mkdir($sInfectFolderPath,0775,true);

                    $destination = $sInfectFolderPath.DIRECTORY_SEPARATOR.$payload;
                    if (!file_exists($destination))
                        mkdir($destination,0775,true);
                
                    if($ip == "no")
                    {
                        $copyflag = copy($geturl,$_SERVER['DOCUMENT_ROOT'].$zipfile);
                    }
                    else
                    {
                        if(file_exists($geturl))
                        {
                           $copyflag = copy($geturl,$_SERVER['DOCUMENT_ROOT'].$zipfile); 
                        }
                        else
                        {
                            $copyflag = FALSE;
                        }
                    }
                    
                    if ($debug) {echo "<h2>Attempting to Unzip</h2><p>Zipped file:  $zipfile </p>";}
                    
                    $zipFlag = $zip->open($destination.DIRECTORY_SEPARATOR.$download_filename);
                    if ($zipFlag === TRUE) {
                        
                        (file_exists($_SERVER['DOCUMENT_ROOT'].$oldfilename)) ? unlink($_SERVER['DOCUMENT_ROOT'].$oldfilename) : '';
                        
                        $sPayloadUrl = $_SERVER['DOCUMENT_ROOT'].'/'.$payload;
                        if(file_exists($sPayloadUrl))
                        {
                            $aExplodeZipFile = explode(".zip",$download_filename);
                            
                            if(is_dir($sPayloadUrl))
                            $ffs = scandir($sPayloadUrl);
                            
                            foreach($ffs as $ff)
                            {
                                if(is_dir($sPayloadUrl.'/'.$ff) && $ff != '.' && $ff != '..')
                                {
                                    if (preg_match("/$aExplodeZipFile[0]/",$ff))
                                    {
                                        (file_exists($sPayloadUrl.'/'.$ff)) ? rename($sPayloadUrl.'/'.$ff, $sPayloadUrl."/old_".$ff) : '';
                                    }
                                    else
                                    {
                                        (file_exists($sPayloadUrl."/old_".$ff)) ? rename($sPayloadUrl."/old_".$ff,$sPayloadUrl.'/'.$ff) : '';
                                    }
                                }
                            }
                            $zip->extractTo($sPayloadUrl);
                            rrmdir($_SERVER['DOCUMENT_ROOT']."/admin/getpayload/".$payload);
                            rrmdir($sPayloadUrl."/old_".$ff);
                        }
                        else
                        {
                            $aExplodeZipFile = explode(".zip",$download_filename);
                            
                            if(is_dir($sPayloadUrl))
                            $ffs = scandir($sPayloadUrl);
                            
                            foreach($ffs as $ff)
                            {
                                    if(is_dir($sPayloadUrl.'/'.$ff) && $ff != '.' && $ff != '..')
                                    {
                                        if (preg_match("/$aExplodeZipFile[0]/",$ff))
                                        {
                                            rename($sPayloadUrl.'/'.$ff, $sPayloadUrl."/old_".$ff);
                                        }
                                        else
                                        {
                                            rename($sPayloadUrl."/old_".$ff,$sPayloadUrl.'/'.$ff);
                                        }
                                    }
                            }
                            mkdir($sPayloadUrl,0775,true);
                            $zip->extractTo($sPayloadUrl.$download_filename);
                            rrmdir($_SERVER['DOCUMENT_ROOT']."/admin/getpayload/".$payload);
                            rrmdir($sPayloadUrl."/old_".$ff);
                        }
                    }
                    else
                    {
                        rename($_SERVER['DOCUMENT_ROOT'].$oldfilename,$_SERVER['DOCUMENT_ROOT'].$zipfile);
                    }

                    $destination  = $_SERVER["DOCUMENT_ROOT"]."infect/";
                
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

                        $fp = fopen($_SERVER['DOCUMENT_ROOT'].$zipfile, 'w+'); // or perhaps 'wb'?
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
            
                
                echo '<h2>Installation Complete!</h2><p>Check installation has worked: </p><p><a href="admin" target="_blank">Click Here for Admin Page</a></p><p>or</p><p><a href="play" target="_blank">Click Here for PLAY Page</a></p>';
                die();
            } // END try alternative move approach

        }
?>
<html>
    <head>
        <title>Payloads</title>
        <meta charset="utf-8">
        <link href="../../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <script src="../../js/jquery.js" type="text/javascript"></script>
        <style>
                body{
                    background-color: black;
                    min-height:800px;
                    padding: 0px;
                    margin: 0;
                    color: #fff;
                }
                form{
                    border: 1px solid #fff;
                    height: 88%;
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
                    text-align: right;
                    width: 370px;
                }
                .go-button{
                    float: right;
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
                .admin-payloads{
                    border-right: 1px solid #fff;
                    float: left;
                    min-height: 450px;
                    width: 50%;
                }
                .general-payloads{
                    float: right;
                    min-height: 450px;
                }
                .payloads{
                    height: 700px;
                    width: 100%;
                }
        </style>
        <script type="text/javascript">
            function setHiddenValue(hiddenFieldId, checkId, dirPath)
            {
                if($("#"+checkId).is(":checked"))
                {
                    $('#'+hiddenFieldId).val(dirPath);
                }
                else
                {
                    $('#'+hiddenFieldId).val('');
                }
            }
            function showData(divId)
            {
                if(divId == "update_payloads")
                {
                    $("#"+divId).show();
                }
                else if(divId == "github_payloads")
                {
                    $("#"+divId).show();
                    $("#update_payloads").show();
                    $("#infected_device").hide();
                    $("#website_url").hide();
                }
                else if(divId == "infected_device")
                {
                    $("#"+divId).show();
                    $("#update_payloads").show();
                    $("#github_payloads").hide();
                    $("#website_url").hide();
                }
                else if(divId == "website_url")
                {
                    $("#"+divId).show();
                    $("#update_payloads").show();
                    $("#github_payloads").hide();
                    $("#infected_device").hide();
                }
            }
            function changeValue()
            {
                if ($('#ckeck_admin').is(":checked"))
                {
                    $('#ckeck_admin').val(1);
                }
                else
                {
                    $('#ckeck_admin').val(0);
                }
            }
            function removePort()
            {
                $("#port_number").val('');
            }
            $(document).ready(function(){
                showData("<?php echo isset($_POST['payload_source']) ? $_POST['payload_source'] : ''; ?>");
            });
        </script>
    </head>
    <body class="main">
        <div id="container">
            <form method="post" name="form1" action="">
                <div class="payloads">
                    <div class="payload-details">
                        <h2>Payload Details</h2>
                    </div>
                    <div class="admin-payloads">
                        <div class="text-field">
                            <h2>Admin Payloads</h2><hr/>
                            <?php
                                listFolderFiles("infect/admin","infect_admin","infect_admin_check");
                                listFolderFiles("admin","admin","admin_check");
                            ?>
                        </div>
                    </div>

                    <div class="general-payloads">
                        <div class="text-field">
                            <h2>General Payloads</h2><hr/>
                            <?php
                                listFolderFiles("infect/payloads","infect_payloads","infect_payloads_check");
                                listFolderFiles("payloads","payloads","payloads_check");
                            ?>
                        </div>
                    </div>
                    <div class="go-button">
                        <input type="submit" name="delete" id="delete" value="Delete">
                        <input type="button" name="update_btn" id="update_btn" value="Update" onclick="showData('update_payloads');">
                    </div>
                    
                    <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
                </div>
                <br/>
            </form>
            <div id="update_payloads" style="display:none;">
                <form name="payload_details_update" id="payload_details_update" method="POST">
                    <div class="payload-details">
                        <h2>Enter Payload Details</h2>
                    </div>
                    <div class="text-field">Is this an Admin Payload? <font color="red">*</font> :</div>
                    <input type="checkbox" name="ckeck_admin" id="ckeck_admin" value="0" onclick="changeValue();"/><br/>
                    <div id="text_box_input" class="error-message">
                      <?php //echo isset($_SESSION['isValidation']['ckeck_admin']) ? $_SESSION['isValidation']['ckeck_admin'] : '';?>
                    </div>
                    <br/>
                    <div class="text-field">
                        <input type="radio" name="payload_source" id="ckeck_github" value="github_payloads" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "github_payloads") ? "checked='checked'" : "checked='checked'"; ?> onclick="showData('github_payloads');">GitHub
                        <br/><br/>
                        <input type="radio" name="payload_source" id="ckeck_infected" value="infected_device" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "infected_device" ) ? "checked='checked'" : ""; ?> onclick="showData('infected_device');">Infected Device
                        <br/><br/>
                        <input type="radio" name="payload_source" id="ckeck_website" value="website_url" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "website_url" ) ? "checked='checked'" : ""; ?> onclick="showData('website_url');">URL/Website<br/><br/>
                    </div>
                    <br/><br/><br><br><br><br/><br/><br/><br/>
                    <div id="github_payloads">
                        <div class="text-field">GitHub Username<font color="red">*</font> :</div>
                        <input type="text" name="user_name">
                        <div class="error-message">
                            <?php echo isset($_SESSION['isValidation']['user_name_required']) ? $_SESSION['isValidation']['user_name_required'] : '';?>
                        </div>
                        <br/><br/>
                        <div class="text-field">GitHub Repository<font color="red">*</font> :</div>
                        <input type="text" name="repository">
                        <div class="error-message">
                            <?php echo isset($_SESSION['isValidation']['repository_required']) ? $_SESSION['isValidation']['repository_required'] : '';?>
                        </div>
                    </div>
                    <div id="infected_device" style="display:none">
                        <div class="text-field">Device Address (IP or URL)<font color="red">*</font> :</div>
                        <input type="text" name="device_address">
                        <div class="error-message">
                            <?php echo isset($_SESSION['isValidation']['device_address']) ? $_SESSION['isValidation']['device_address'] : '';?>
                        </div>
                        <div class="example-text">Example: 192.168.143.1</div>
                        <br/><br/>
                        <div class="text-field">Port :</div>
                        <input type="text" name="port_number" id="port_number" value="8080">
                        &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removePort();"><i class="fa fa-eraser"></i></a>
                        <br/><br/>
                        <div class="text-field">GitHub Username<font color="red">*</font> :</div>
                        <input type="text" name="infect_user_name">
                        <div id="infect_user_input" class="error-message">
                            <?php echo isset($_SESSION['isValidation']['infect_user_name']) ? $_SESSION['isValidation']['infect_user_name'] : '';?>
                        </div>
                        <br/><br/>
                        <div class="text-field">GitHub Repository:</div>
                        <input type="text" name="infect_repository">
                    </div>
                    <div id="website_url" style="display:none">
                        <div class="text-field">Payload Name<font color="red">*</font> :</div>
                        <input type="text" name="payload_name">
                        <div class="error-message">
                            <?php echo isset($_SESSION['isValidation']['payload_name']) ? $_SESSION['isValidation']['payload_name'] : '';?>
                        </div>
                        <br/><br/>
                        <div class="text-field">URL<font color="red">*</font> :</div>
                        <input type="text" name="payload_url">
                        <div id="url_input" class="error-message">
                            <?php echo isset($_SESSION['isValidation']['payload_url']) ? $_SESSION['isValidation']['payload_url'] : '';?>
                        </div>
                    </div>
                    <div class="go-button">
                        <input type="submit" name="go_btn" id="go_btn" value="Go!" onclick="showData('update_payloads');">
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>