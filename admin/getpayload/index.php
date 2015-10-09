<?php
    require_once("../../data/constants.php");
    require(ROOT_DIR.'/admin/checkLogin.php');
    PAYLOAD_INSTALL == 1;
    error_reporting(0);
    $sSiteUrl = SITE_URL;
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $sSiteUrl = trim($protocol);
    }
   ?>
<html>
    <head>
        <title>Payloads</title>
        <meta charset="utf-8">
        <link href="<?php echo $sSiteUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $sSiteUrl; ?>/admin/buttons.css" rel="stylesheet">
        <link href="<?php echo $sSiteUrl; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <script src="<?php echo $sSiteUrl; ?>/js/jquery.js" type="text/javascript"></script>
        <script type="text/javascript">
            function checkLoaded(loaded){
                if(loaded == true)
                {
                    $("#loading").show();
                    $("#getpayload_form").submit();
                }
                else
                {
                    $("#loading").hide();
                }
            }
        </script>
        <style>
            #loading
            {
                margin-top: 20px;
            }
            #loading-image {
                position: absolute;
                top: 100px;
                left: 500px;
                z-index: 100;
             }
        </style>
    </head>
    <body class="main" onLoad="checkLoaded(false);">
        <div id="loading"><img src="<?php echo $sSiteUrl; ?>/images/loading_spinner.gif"><br/>Installing...</div>
    <div id="loading-image" style="display:none;"></div>
    <script>
        checkLoaded(false);
    </script>
<?php
    $debug = DEBUG_TEXT;
    $nMode =  0755;
    
    $_SESSION['isValidation']['flag'] = TRUE;
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_SESSION['isValidation']))
    {
        $sUserName = isset($_POST['user_name']) ? trim($_POST['user_name']) : '';
        $sRepository = isset($_POST['repository']) ? trim($_POST['repository']) : '';
        $sPayloadGithub = isset($_POST['payload_github']) ? trim($_POST['payload_github']) : '';
        $sFilePayload = isset($_POST['file_payload']) ? trim($_POST['file_payload']) : '';
        $sDeviceAddress = isset($_POST['device_address']) ? trim($_POST['device_address']) : '';
        $sDevicePayload = isset($_POST['device_payload']) ? trim($_POST['device_payload']) : '';
        $sFileName = isset($_FILES['upload_file']['name']) ? $_FILES['upload_file']['name']:'';
        $sTempFileName = isset($_FILES['upload_file']['tmp_name'])? $_FILES['upload_file']['tmp_name'] : '';
        $nPort = isset($_POST['port_number']) ? trim($_POST['port_number']) : '';
        $sInfectUserName = isset($_POST['infect_user_name']) ? trim($_POST["infect_user_name"]) : '';
        $sPayloadName = isset($_POST['payload_name']) ? trim($_POST['payload_name']) : '';
        $sPayloadUrl = isset($_POST['payload_url']) ? trim($_POST["payload_url"]) : '';
        $sGooglePayloadName = isset($_POST['google_payload_name']) ? trim($_POST['google_payload_name']) : '';
        $sGoogleDriveLink = isset($_PST['google_drive_link']) ? trim($_POST['google_drive_link']) : '';
        $sIsAdmin = empty($_POST['check_admin']) ? '' : $_POST['check_admin'];
        $sPayloadSource = isset($_POST['payload_source'])? $_POST['payload_source'] : '';
        $sFolderSource = isset($_POST['folder_source'])? $_POST['folder_source'] : '';
        $sNewFolderName = isset($_POST['new_folder'])? $_POST['new_folder'] : '';
        $nPayloadInstall = (PAYLOAD_INSTALL == 1 && $_POST['branch_install']) ? $_POST['branch_install'] : 'master';
        if($sFolderSource == "Select Payload Type")
        {
            $_SESSION['isValidation']['folder_source'] = 'Please select payload type!!';
            $_SESSION['isValidation']['flag'] = FALSE;
        }
        else
        {
            unset($_SESSION['isValidation']['folder_source']);
        }
        if($sPayloadSource == "Select Payload Source")
        {
            $_SESSION['isValidation']['payload_source'] = 'Please select payload source!!';
            $_SESSION['isValidation']['flag'] = FALSE;
        }
        else
        {
            unset($_SESSION['isValidation']['payload_source']);
        }
        if($sPayloadSource == 'github_payloads')
        {
            if(empty($sUserName))
            {
                $_SESSION['isValidation']['user_name_required'] = 'Please enter username!!';
            }
            else
            {
                unset($_SESSION['isValidation']['user_name_required']);
            }
            if(empty($sRepository))
            {
                $_SESSION['isValidation']['repository_required'] = 'Please enter repository!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['repository_required']);
            }
            if(empty($nPayloadInstall))
            {
                $_SESSION['isValidation']['branch_required'] = 'Please enter branch!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['branch_required']);
            }
        }
        if($sPayloadSource == 'infected_device')
        {
            if(empty($sDeviceAddress))
            {
                $_SESSION['isValidation']['device_address'] = 'Please enter device address!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['device_address']);
            }
            if(empty($sInfectUserName))
            {
                $_SESSION['isValidation']['infect_user_name'] = 'Please enter name!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['infect_user_name']);
            }
        }
        if($sPayloadSource == 'website_url')
        {
            if(empty($sPayloadName))
            {
                $_SESSION['isValidation']['payload_name'] = 'Please enter payload name!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['payload_name']);
            }
            if(empty($sPayloadUrl))
            {
                $_SESSION['isValidation']['payload_url'] = 'Please enter payload url!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['payload_url']);
            }
        }
        if($sPayloadSource == 'file_browse')
        {   
            if(empty($sFileName))
            {
                $_SESSION['isValidation']['upload_file'] = 'Please Choose File!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['upload_file']);
            }
        }
        if($sPayloadSource == 'google_drive')
        {
            if(empty($sGooglePayloadName))
            {
                $_SESSION['isValidation']['google_payload_name'] = 'Please enter payload name!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['google_payload_name']);
            }
            if(empty($sGoogleDriveLink))
            {
                $_SESSION['isValidation']['google_drive_link'] = 'Please enter google drive link!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            else
            {
                unset($_SESSION['isValidation']['google_drive_link']);
            }
        }

        if($_SESSION['isValidation']['flag'] == 1)
        {
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
            
            function makeDIR($directory,$debugtxt=0,$nMode) {
                // Create payload directory if it doesn't exist:
                if (file_exists($directory)) {
                    //if ($debugtxt) { echo "<p>Directory <b>$directory</b> already exists </p>"; }
                    $result = true; // Return true as success is when the directory has either been created or already exists
                } else {
                    // Make the new temp sub_folder for unzipped files
                    if (!mkdir($directory, $nMode, true)) {
                        if ($debugtxt) { 
                            echo "<p>Error: Could not create folder <b>$directory</b> - check file permissions";
                            echo '<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>';
                        }
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
            function moveDIR($dir,$dest="",$debug,$nMode=0755) {
                //$debug = 1;
                $result=true;

                //if($debug) { echo "<h2>Moving directory</h2><p> From:<br> $dir <br>To: $dest</p>";}

                $path = dirname(__FILE__);
                $files = scandir($dir);

                foreach($files as $file) {
                    if (substr( $file ,0,1) != ".") {
                        $pathFile = $dir.'/'.$file;
                        if (is_dir($pathFile)) {
                            //if($debug) { echo "<p><b>Directory:</b> $pathFile</p>"; }

                            $newDir = $dest."/".$file;

                            if (!moveDIR($pathFile,$newDir,$debug)) {
                                $result = false;
                            }

                        } else {
                            //echo ($debug) ? "<p>$pathFile is a file</p>" : "";

                            // $currentFile = realpath($file); // current location
                            $currentFile = $pathFile;

                            $newFile = $dest."/".$file;

                            if (!file_exists($dest)) {
                                makeDIR($dest,0,$nMode);
                            }
                            // if file already exists remove it
                            if (file_exists($newFile)) {
                                //if($debug) { echo "<p>File $newFile already exists - Deleting</p>"; }
                                unlink($newFile);
                            } else {
                                //if($debug) { echo "<p>File $newFile doesn't exist yet</p>"; }
                            }

                            // Move via rename
                            // rename(oldname, newname)
                            if (rename($currentFile , $newFile)) {
                                (CHMOD == 1) ? chmod($newFile, 0755) : '';
                                //if($debug) { echo "<p>Moved $currentFile to $newFile</p>"; }
                            } else {
                                //if($debug) { echo "<p>Failed to move $currentFile to $newFile</p>"; }
                                $result = false;
                            } // END rename 

                        } // END if dir or file
                    } // end if no dot
                } // END foreach
                return $result;
            } // END moveDIR

            // -------------
            // REDIRECT PAGE

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
            
            $payload = $sFolderSource;
            if(($sFolderSource == 'data' || $sFolderSource == 'content') && !empty($sNewFolderName))
            {
                $payload = $sFolderSource.'/'.$sNewFolderName;
            }
            $isAdmin = strtoupper(substr($payload,0,1));
            
            $payload = ROOT_DIR.DIRECTORY_SEPARATOR.$payload;
            
            if(EXTERNAL_TEXT == 1 && ($sFolderSource == "payloads" || $sFolderSource == "content" || $sFolderSource == "data"))
            {
                if(!is_dir(EXTERNAL_PATH))
                {
                    mkdir(EXTERNAL_PATH, $nMode, true);
                    mkdir(EXTERNAL_PATH.'/payloads', $nMode, true);
                    mkdir(EXTERNAL_PATH.'/content', $nMode, true);
                    mkdir(EXTERNAL_PATH.'/data', $nMode, true);
                }
                if($sFolderSource == 'content' && isset($_POST['install_source']) && $_POST['install_source'] != "new_folder")
                {
                    if(!is_dir(EXTERNAL_PATH.'/content/'.$_POST['install_source']))
                    {
                        mkdir(EXTERNAL_PATH.'/content/'.$_POST['install_source'], $nMode, true);
                    }
                    $payload= EXTERNAL_PATH.'/content/'.$_POST['install_source'];
                }
                else if($sFolderSource == 'content' && isset($_POST['install_source']) && $_POST['install_source'] == "new_folder" && !empty($sNewFolderName))
                {
                    if(!is_dir(EXTERNAL_PATH.'/content/'.$sNewFolderName))
                    {
                        mkdir(EXTERNAL_PATH.'/content/'.$sNewFolderName, $nMode, true);
                    }  
                    $payload = EXTERNAL_PATH.'/content/'.$sNewFolderName;
                }
                else if($sFolderSource == 'data' && isset($_POST['install_source']) && $_POST['install_source'] != "new_folder")
                {
                    if(!is_dir(EXTERNAL_PATH.'/data/'.$_POST['install_source']))
                    {
                        mkdir(EXTERNAL_PATH.'/data/'.$_POST['install_source'], $nMode, true);
                    }
                    $payload= EXTERNAL_PATH.'/data/'.$_POST['install_source'];
                }
                else if($sFolderSource == 'data' && isset($_POST['install_source']) && $_POST['install_source'] == "new_folder" && !empty($sNewFolderName))
                {
                    if(!is_dir(EXTERNAL_PATH.'/data/'.$sNewFolderName))
                    {
                        mkdir(EXTERNAL_PATH.'/data/'.$sNewFolderName, $nMode, true);
                    }  
                    $payload = EXTERNAL_PATH.'/data/'.$sNewFolderName;
                }
                else if($sFolderSource == "payloads")
                {
                    $payload = EXTERNAL_PATH.'/payloads';
                }
            }
            if(!empty($sPayloadGithub))
            {
                $sDownloadFileName = $sPayloadGithub.".zip";
                $download_unzip_filename = $sPayloadGithub;
                $sListContent = "github_payloads;$isAdmin;$sPayloadGithub";
            }
            else if(!empty($sUserName))
            {
                $sDownloadFileName = $sUserName."-".$sRepository.".zip";
                $download_unzip_filename = $sUserName."-".$sRepository;
                $sListContent = "github_payloads;$isAdmin;$sUserName;$sRepository";
            }
            else if(!empty($sDevicePayload))
            {
                $sDownloadFileName = $sDevicePayload.".zip";
                $download_unzip_filename = $sDevicePayload;
                $sPort = empty($nPort) ? 'none' : $nPort;
                $sListContent = "infected_device;$isAdmin;$sDeviceAddress;$sPort;$download_unzip_filename";
                $sDeviceDownloadFileName = $sInfectUserName.".zip";
            }
            else if(!empty($sDeviceAddress))
            {   
                $sDownloadFileName = $sInfectUserName.".zip";
                $sDeviceDownloadFileName = $sInfectUserName.".zip";
                $download_unzip_filename = $sInfectUserName;
                $sPort = empty($nPort) ? 'none' : $nPort;
                $sListContent = "infected_device;$isAdmin;$sDeviceAddress;$sPort;$download_unzip_filename";
            }
            else if(!empty($sPayloadName))
            {
                $sDownloadFileName = $sPayloadName.".zip";
                $download_unzip_filename = $sPayloadName;
                $sListContent = "website_url;$isAdmin;$download_unzip_filename;$sPayloadUrl";
            }
            else if(!empty($sGooglePayloadName))
            {
                $sDownloadFileName = $sGooglePayloadName.".zip";
                $download_unzip_filename = $sGooglePayloadName;
                $sListContent = "google_drive;$isAdmin;$download_unzip_filename;$sGoogleDriveLink";
            }
            else if(!empty($sFilePayload))
            {
                makeDIR($payload, 1, $nMode);
                $sDownloadFileName = $sFilePayload.".zip";
                $aExplodeFileName = explode(".zip", $sDownloadFileName);
                if((isset($aExplodeFileName[1]) && $aExplodeFileName[1] != "") || !isset($aExplodeFileName[1]))
                {
                    $sDownloadFileName = $sFilePayload.'.zip';
                    $download_unzip_filename = $sFilePayload;
                    $sListContent = "file_browse;$isAdmin;$download_unzip_filename;$sDownloadFileName";
                    move_uploaded_file($sTempFileName, $payload.DIRECTORY_SEPARATOR.$sDownloadFileName);
                    (CHMOD == 1) ? chmod($payload.DIRECTORY_SEPARATOR.$sDownloadFileName, 0755) : '';
                    
                    $zip = new ZipArchive;
                    if ($zip->open($payload.DIRECTORY_SEPARATOR.$sDownloadFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
                    {
                        $zip->addFile($payload.DIRECTORY_SEPARATOR.$sDownloadFileName, $sFilePayload);
                        $zip->close();
                    }
                    else
                    {
                        exit('<h3>Payload $sDownloadFileName</h3><h4> Installed via $payload.DIRECTORY_SEPARATOR.$sDownloadFileName FAILED!!</h4><div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                    }
                }
                else
                {
                    $download_unzip_filename = $aExplodeFileName[0];
                    $sListContent = "file_browse;$isAdmin;$download_unzip_filename";
                    move_uploaded_file($sTempFileName, $payload.DIRECTORY_SEPARATOR.$sDownloadFileName);
                    (CHMOD == 1) ? chmod($payload.DIRECTORY_SEPARATOR.$sDownloadFileName, 0755) : '';
                }
            }
            else if(!empty($sFileName))
            {
                makeDIR($payload, 1, $nMode);
                $sDownloadFileName = $sFileName;
                $aExplodeFileName = explode(".zip", $sFileName);
                if((isset($aExplodeFileName[1]) && $aExplodeFileName[1] != "") || !isset($aExplodeFileName[1]))
                {
                    $sDownloadFileName = $sFileName.'.zip';
                    $download_unzip_filename = $aExplodeFileName[0];
                    $sListContent = "file_browse;$isAdmin;$download_unzip_filename;$sDownloadFileName";
                    move_uploaded_file($sTempFileName, $payload.DIRECTORY_SEPARATOR.$sDownloadFileName);
                    (CHMOD == 1) ? chmod($payload.DIRECTORY_SEPARATOR.$sDownloadFileName, 0755) : '';
                    
                    $zip = new ZipArchive;
                    if ($zip->open($payload.DIRECTORY_SEPARATOR.$sDownloadFileName, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE)
                    {
                        $zip->addFile($payload.DIRECTORY_SEPARATOR.$sDownloadFileName, $sFileName);
                        $zip->close();
                    }
                    else
                    {
                        exit('<h3>Payload $sDownloadFileName</h3><h4> Installed via $payload.DIRECTORY_SEPARATOR.$sDownloadFileName FAILED!!</h4><div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                    }
                }
                else
                {
                    $download_unzip_filename = $aExplodeFileName[0];
                    $sListContent = "file_browse;$isAdmin;$download_unzip_filename;$sFileName";
                    move_uploaded_file($sTempFileName, $payload.DIRECTORY_SEPARATOR.$sFileName);
                    (CHMOD == 1) ? chmod($payload.DIRECTORY_SEPARATOR.$sFileName, 0755) : '';
                }
            }
            $zipfile = $payload.DIRECTORY_SEPARATOR.$sDownloadFileName;

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
            if (!makeDIR($payload,true,$nMode)) {
                    // failed to make directory so exit
                    exit('<h3>Payload $download_unzip_filename</h3><h4> Installed via $geturl FAILED!!</h4><div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
            }
           
             // Check for IP param and set $ip if param provided
            // ** TO DO **

            // Download file if OATSEA-teachervirus.zip doesn't already exist
            if (file_exists($zipfile) && empty($sFileName))
            {
                unlink($zipfile);
                rrmdir($payload.'/'.$download_unzip_filename);
                if ($debug)
                { 
                    echo "<p>The Payloads files have already been downloaded to: $zipfile</p>
                    <p>This installation will use the existing file rather than downloading a new version of $sInfectUserName.</p>
                    <p><b>Hint:</b> If you want to download a new version of Payload you will need to:</br>
                    * delete the file: <b>$zipfile</b>.</br>
                    * remove the <b>play</b> folder if it exists</br>
                    * refresh/re-open <b>getpayload</b></p>"; 
                } // END Debug
            }
            if ($ip == "no")
            {
                // Download from github zipball/master as no IP address set
                $geturl = "https://github.com/$sUserName/$sRepository/zipball/$nPayloadInstall/";
            }
            else 
            {
                // as IP address has been set attempt download from IP address
                $geturl = empty($nPort) ? "http://$ip/payloads/$sDeviceDownloadFileName" : "http://$ip:$nPort/payloads/$sDeviceDownloadFileName";
            }
            if(!empty($sPayloadName))
            {
                $geturl = $sPayloadUrl;
            }
            if(!empty($sGooglePayloadName))
            {
                $aExplodeLinkID = explode("id=", $sGoogleDriveLink);
                $geturl = "https://docs.google.com/uc?id=$aExplodeLinkID[1]&export=download";
            }
            else if(!empty($sTempFileName))
            {
                $geturl = $sTempFileName;
            }
            // TRY DOWNLOAD via copy
            if ($debug)
            { 
                echo "<h2>Download Files</h2>
                <p>Will attempt to download via copy from <b>$geturl</b></p> ";
            }
            // ** TO DO ** catch warnings
            // get following error on MAC: 
            umask(0);
            $zip = new ZipArchive;
            
            // Get array of all source files
            $files = scandir($payload);
            // Identify directories
            $source = $payload;
            $sFolderPath = ROOT_DIR;

            $destination = $payload;
            if (!file_exists($destination))
                mkdir($destination, $nMode, true);
            
            $copyflag = FALSE;
            if(($ip == "no" || $sPayloadSource == 'infected_device') && $sPayloadSource != 'file_browse')
            {
                $copyflag = copy($geturl,$zipfile);
            }
            else if($sPayloadSource == 'file_browse')
            {
                $copyflag = TRUE;
            }
            else if(file_exists($geturl))
            {
                $copyflag = copy($geturl,$zipfile);
            }
            (CHMOD == 1) ? chmod($zipfile, 0755) : '';
            if ($debug) {echo "<h2>Attempting to Unzip</h2><p>Zipped file:  $zipfile </p>";}
            $zipFlag = $zip->open($destination.DIRECTORY_SEPARATOR.$sDownloadFileName,true);
            if ($zipFlag === TRUE && $copyflag == TRUE) 
            {

                $sPayloadUrl = $payload;
                // Create full temp sub_folder path
                $temp_unzip_path = $sPayloadUrl.DIRECTORY_SEPARATOR.uniqid('unzip_temp_', true).DIRECTORY_SEPARATOR;

                //if($debug) { echo "Temp Unzip Path is: ".$temp_unzip_path."<br>"; }

                // Make the new temp sub_folder for unzipped files
                if (!mkdir($temp_unzip_path, $nMode, true)) {
                    exit("<h3>Payload $download_unzip_filename</h3><h4> Installed via $geturl FAILED!!</h4><p>Failed because : File security or permissions issue?".'<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                } else {
                    if($debug) { echo "<p>Temp unzip Folder Created! <br>"; }
                }

                if(is_dir($sPayloadUrl))
                {   
                    $zip->extractTo($temp_unzip_path);
                    if(is_dir($sPayloadUrl.'/'.$download_unzip_filename))
                    {
                        rrmdir($sPayloadUrl.'/'.$download_unzip_filename);
                        if (!mkdir($sPayloadUrl.'/'.$download_unzip_filename, $nMode, true)) {
                            exit("<h3>Payload $download_unzip_filename</h3><h4> Installed via $geturl FAILED!!</h4><p>Failed because : Already installed?".'<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                        } else {
                            if($debug) { echo "<p>Folder Created! <br>"; }
                        }
                    }
                    else
                    {
                        if (!mkdir($sPayloadUrl.'/'.$download_unzip_filename, $nMode, true)) {
                            exit("<h3>Payload $download_unzip_filename</h3><h4> Installed via $geturl FAILED!!</h4><p>Failed because : File security or permissions issue?".'<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                        } else {
                            if($debug) { echo "<p>Folder Created! <br>"; }
                        }        
                    }

                    $files = scandir($temp_unzip_path,1);
                    
                    foreach ($files as $key => $value)
                    {
                       if (!in_array($value,array(".","..")))
                       {
                            if (is_dir($temp_unzip_path . $value))
                            {
                                moveDIR($temp_unzip_path . $value,$sPayloadUrl.'/'.$download_unzip_filename,$debug);
                                $myfile = fopen("$sPayloadUrl/$download_unzip_filename/list.txt", "w") or die('Unable to open file! <div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                                fwrite($myfile, $sListContent);
                                fclose($myfile);

                                $myfile = fopen("$destination/list.txt", "w") or die('Unable to open file! <div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                                fwrite($myfile, $sListContent);
                                fclose($myfile);
                                $relativePath = substr($destination.DIRECTORY_SEPARATOR.$sDownloadFileName.$value."/list.txt", strlen($destination.DIRECTORY_SEPARATOR.$sDownloadFileName));
                                // Add current file to archive
                                $zip->addFile($destination."/list.txt", $relativePath);
                            }
                            else if($sPayloadSource == 'file_browse')
                            {
                                moveDIR($temp_unzip_path,$sPayloadUrl.'/'.$download_unzip_filename,$debug);
                                $myfile = fopen("$sPayloadUrl/$download_unzip_filename/list.txt", "w") or die('Unable to open file! <div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                                fwrite($myfile, $sListContent);
                                fclose($myfile);

                                $myfile = fopen("$destination/list.txt", "w") or die('Unable to open file! <div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                                fwrite($myfile, $sListContent);
                                fclose($myfile);
                                $relativePath = substr($destination.DIRECTORY_SEPARATOR.$sDownloadFileName."list.txt", strlen($destination.DIRECTORY_SEPARATOR.$sDownloadFileName));
                                // Add current file to archive
                                $zip->addFile($destination."/list.txt", $relativePath);
                            }
                       }
                    }
                    if(is_dir($temp_unzip_path))
                    {
                        rrmdir($temp_unzip_path);
                    }
                    rrmdir(ROOT_DIR."/admin/getpayload/".$payload);
                }
                else
                {
                    $zip->extractTo($temp_unzip_path);
                    if(is_dir($sPayloadUrl.'/'.$download_unzip_filename))
                    {
                        rrmdir($sPayloadUrl.'/'.$download_unzip_filename);
                        if (!mkdir($sPayloadUrl.'/'.$download_unzip_filename, $nMode, true)) {
                            exit("<h3>Payload $download_unzip_filename</h3><h4> Installed via $geturl FAILED!!</h4><p>Failed because : Already installed?".'<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                        } else {
                            if($debug) { echo "<p>Folder Created! <br>"; }
                        }
                    }
                    else
                    {
                        if (!mkdir($sPayloadUrl.'/'.$download_unzip_filename, $nMode, true)) {
                            exit("<h3>Payload $download_unzip_filename</h3><h4> Installed via $geturl FAILED!!</h4><p>Failed because : File security or permissions issue?".'<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                        } else {
                            if($debug) { echo "<p>Folder Created! <br>"; }
                        }        
                    }     

                    $files = scandir($temp_unzip_path,1);
                    foreach ($files as $key => $value)
                    {
                       if (!in_array($value,array(".","..")))
                       {
                          if (is_dir($temp_unzip_path . $value))
                          {
                            moveDIR($temp_unzip_path . $value,$sPayloadUrl.DIRECTORY_SEPARATOR.$download_unzip_filename,$debug);
                            $myfile = fopen("$sPayloadUrl/$download_unzip_filename/list.txt", "w") or die('Unable to open file! <div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                            fwrite($myfile, $sListContent);
                            fclose($myfile);

                            $myfile = fopen("$destination/list.txt", "w") or die('Unable to open file! <div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>');
                            fwrite($myfile, $sListContent);
                            fclose($myfile);
                            echo $relativePath = substr($destination.DIRECTORY_SEPARATOR.$sDownloadFileName.$value."/list.txt", strlen($destination.DIRECTORY_SEPARATOR.$sDownloadFileName));exit;
                            // Add current file to archive
                            $zip->addFile($destination."/list.txt", $relativePath);
                          }
                       }
                    }
                    if(is_dir($temp_unzip_path))
                    {
                        rrmdir($temp_unzip_path);
                    }
                    rrmdir(ROOT_DIR."/admin/getpayload/".$payload);
                }
            }
            $zip->close();
            unlink($destination."/list.txt");

            if ($copyflag === FALSE) 
            { 
                // try CURL    
                if ($debug) { echo "<p>Will attempt to download via CURL from <b>$geturl</b></p> ";}

                // USE CURL to Download ZIP
                // Code Attribution:  
                // http://stackoverflow.com/questions/19177070/copy-image-from-remote-server-over-https    
                // http://stackoverflow.com/questions/18974646/download-zip-php
                // http://stackoverflow.com/questions/11321761/using-curl-to-download-a-zip-file-isnt-working-with-follow-php-code

                set_time_limit(0); //prevent timeout
                $fp = fopen($zipfile, 'w+'); // or perhaps 'wb'?
                
                if (!$fp) {
                    exit("<h3>Payload $download_unzip_filename</h3><h4>Installed via $geturl FAILED!!</h4>
                    <p>Failed because : File permission issue maybe?
                    ".'<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>'); 
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
                        echo "<h3>Payload $download_unzip_filename</h3><h4>Installed via CURL FAILED!!</h4>";
                        echo "<p> HTTP Status of: $http_status (200 is good)</p>";
                        echo "<p> Failed because : CURL error: ".curl_error($ch)." ...</p>";
                        if (file_exists($zipfile)) {
                            echo "<p> Destination $zipfile file was created though</p>";
                        }   else {
                            echo "<p> Destination $zipfile file was <b>NOT</b> created - file permission issue? </p>";
                            echo '<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div><div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>'; 
                        }

                    } // END debug

                } // END http_status and file exists check

                curl_close($ch);
                fclose($fp);
                
                if (!$downloadResult) 
                {
                    // As download failed delete empty zip file!
                    if ($debug) { echo "<h2>Download with CURL failed</h2>";}
                    echo "<h3>Payload $download_unzip_filename</h3><h4> Installed via $geturl FAILED!!</h4><p>Failed because : Couldn't download with either copy or curl</p>";
                    echo '<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div>'
                        . '<div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>';
                    (file_exists($zipfile)) ? unlink($zipfile) : '';
                    die();
                    //promptForIP();
                } // If Download failed using CURL 
            }// END else CURL

            echo "<h3>Payload $download_unzip_filename</h3><h4> Installed Successfully via $geturl</h4>";
            echo   '<div class="admin_img"><a href="'.$sSiteUrl.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div>'
                . '<div class="play_img"><a href="'.$sSiteUrl.'/play" class="btn btn-lg btn-primary color-white">Play</a></div>';
            die();
        } // END try alternative move approach
    }
    if($_SESSION['isValidation']['flag'] == 1) 
        unset($_SESSION['isValidation']['user_name_required'],$_SESSION['isValidation']['repository_required'],$_SESSION['isValidation']['branch_required'],$_SESSION['isValidation']['device_address'],$_SESSION['isValidation']['infect_user_name'],$_SESSION['isValidation']['payload_name'],$_SESSION['isValidation']['payload_url'],$_SESSION['isValidation']['payload_name'],$_SESSION['isValidation']['google_payload_name'],$_SESSION['isValidation']['google_drive_link'],$_SESSION['isValidation']['upload_file'],$_SESSION['isValidation']['payload_source'],$_SESSION['isValidation']['folder_source'],$_SESSION['isValidation']['new_folder']);

    if($_SESSION['isValidation']['flag'] == 1 || count($_SESSION['isValidation']) > 1)
    {
?>
        <script type="text/javascript">
            function showData(divId)
            {
                var divId = (divId.value == undefined) ? divId : divId.value;
                if(divId == "Select Payload Source")
                {
                    $("#github_payloads").hide();
                    $("#infected_device").hide();
                    $("#website_url").hide();
                    $("#google_drive").hide();
                    $("#file_browse").hide();
                }
                else if(divId == "github_payloads")
                {
                    $("#infected_device").hide();
                    $("#website_url").hide();
                    $("#google_drive").hide();
                    $("#file_browse").hide();
                }
                else if(divId == "infected_device")
                {
                    $("#github_payloads").hide();
                    $("#website_url").hide();
                    $("#google_drive").hide();
                    $("#file_browse").hide();
                }
                else if(divId == "website_url")
                {
                    $("#github_payloads").hide();
                    $("#infected_device").hide();
                    $("#google_drive").hide();
                    $("#file_browse").hide();
                }
                else if(divId == "google_drive")
                {
                    $("#github_payloads").hide();
                    $("#infected_device").hide();
                    $("#website_url").hide();
                    $("#file_browse").hide();
                }
                else if(divId == "file_browse")
                {
                    $("#github_payloads").hide();
                    $("#infected_device").hide();
                    $("#website_url").hide();
                    $("#google_drive").hide();
                }
                else if(divId == "content" || divId == "data")
                {
                    $("#folder_source_error").text('');
                    $("#loading-image").show();
                    $.ajax({
                        type: "POST",
                        url: "updateFolder.php", //Relative or absolute path to response.php file
                        data:{ 
                            folder_name : divId,
                            folder_val : "<?php echo empty($sNewFolderName) ? '' : $sNewFolderName; ?>",
                            selected_val : "<?php echo isset($_POST['install_source']) ? $_POST['install_source'] : ''; ?>"
                        },
                        success: function(data) {
                            $("#content_data").show();
                            $("#folder_options").html(data);
                            $("#loading-image").hide();
                        }
                    });
                }
                else
                {
                    $("#content_data").hide();
                }
                $("#"+divId).show();
            }
            function showFolderOption(divId)
            {
                var divId = (divId.value == undefined) ? divId : divId.value;
                if(divId == "new_folder")
                {
                    $("#"+divId).show();
                }
                else
                {
                    $("#new_folder").hide();
                }
            }
            function changeValue(eValue)
            {
                var isChecked = document.getElementById(eValue);
                if (isChecked.checked)
                {
                    isChecked.value = 1;
                }
                else
                {
                    isChecked.value = 0;
                }
            }
            function removePort()
            {
                $("#port_number").val('');
            }
            $(document).ready(function(){
                showData("<?php echo isset($_POST['payload_source']) ? $_POST['payload_source'] : ''; ?>");
                showData("<?php echo isset($_POST['folder_source']) ? $_POST['folder_source'] : ''; ?>");
            });
        </script>
        <?php ini_set('post_max_size', '64M');
              ini_set('upload_max_filesize', '64M');?>
        <div class="color-white">
            <a class="play_img" href="<?php echo $sSiteUrl.'/admin'; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
        </div><br/><br/>
        <form id="getpayload_form" method="post" action="" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12 title">
                    <h2>Install  Payload </h2>
                </div>
                <div class="col-sm-12">
                    <label class="col-sm-12"><font style="color:red">*</font> Indicates mandatory field</label>
                    </div>
                <div class="col-sm-12">
                    <select name="payload_source" id="payload_source" class="col-sm-3 form-control extra" onChange="showData(this);">
                        <option>Select Payload Source</option>
                        <option id="check_github" value="github_payloads" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "github_payloads") ? "selected='selected'" : ""; ?>>GitHub</option>
                        <option id="check_infected" value="infected_device" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "infected_device" ) ? "selected='selected'" : ""; ?>>Infected Device</option>
                        <option id="check_website" value="website_url" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "website_url" ) ? "selected='selected'" : ""; ?>>URL/Website</option>
                        <option id="check_google" value="google_drive" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "google_drive" ) ? "selected='selected'" : ""; ?>>Google Drive</option>
                        <option value="file_browse" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "file_browse" ) ? "selected='selected'" : ""; ?>>File Upload</option>
                        <option value="OATSEAdirectory" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "OATSEAdirectory " ) ? "selected='selected'" : ""; ?>>OATSEA Directory</option>
                    </select>
                    <div class="error-message">
                        <?php echo isset($_SESSION['isValidation']['payload_source']) ? $_SESSION['isValidation']['payload_source'] : '';?>
                    </div>
                </div>
                <div id="github_payloads" style="display:none" class="source" >
                    <div class="form-group">
                        <label class="col-sm-12 control-label">GitHub Username<font style="color:red">*</font> </label>
                        <div class="col-sm-12">    
                            <input type="text" class="form-control" name="user_name" value="<?php echo isset($sUserName) ? $sUserName : ''; ?>">
                            <div class="error-message">
                                 <?php echo isset($_SESSION['isValidation']['user_name_required']) ? $_SESSION['isValidation']['user_name_required'] : '';?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">GitHub Repository<font style="color:red">*</font> </label>
                        <div class="col-sm-12">    
                            <input type="text" class="form-control" name="repository" value="<?php echo isset($sRepository) ? $sRepository : ''; ?>">
                            <div class="error-message">
                                <?php echo isset($_SESSION['isValidation']['repository_required']) ? $_SESSION['isValidation']['repository_required'] : '';?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Payload Name</label>
                        <div class="col-sm-12">    
                            <input type="text" class="form-control" name="payload_github" value="<?php echo isset($sPayloadGithub) ? $sPayloadGithub : ''; ?>">
                        </div>
                    </div>
                    <?php if(PAYLOAD_INSTALL == 1){?>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Branch <font style="color:red">*</font> </label>
                        <div class="col-sm-12">    
                            <input type="text" class="form-control" name="branch_install" value="<?php echo isset($nPayloadInstall) ? $nPayloadInstall : 'master'; ?>">
                            <div class="error-message">
                                <?php echo isset($_SESSION['isValidation']['branch_required']) ? $_SESSION['isValidation']['branch_required'] : '';?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                    <div id="infected_device" style="display:none" class="source">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Device Address (IP or URL)<font style="color:red">*</font> </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="device_address" value="<?php echo isset($sDeviceAddress) ? $sDeviceAddress : ''; ?>">
                                    <div class="error-message1">
                                         <?php echo isset($_SESSION['isValidation']['device_address']) ? $_SESSION['isValidation']['device_address'] : '';?>
                                    </div><br/><br/>
                            </div>
                            <div class="col-sm-12 example">Provide an IP or URL - For Example: 192.168.143.1 or demo.teachervirus.org</div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Port</label> 
                            <div class="col-sm-12">    
                                <input type="text" class="form-control" name="port_number" id="port_number" value="8080"><a href="javascript:void(0);" onClick="removePort();"><input type="button" class="button" value="Clear" onClick="removePort('branch_name');"/><br/></a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Folder/Payload Name<font style="color:red">*</font></label>
                            <div class="col-sm-12">    
                                <input type="text" class="form-control" name="infect_user_name" value="<?php echo isset($sInfectUserName) ? $sInfectUserName :''; ?>">
                                <div id="infect_user_input" class="error-message1">
                                    <?php echo isset($_SESSION['isValidation']['infect_user_name']) ? $_SESSION['isValidation']['infect_user_name'] : '';?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Payload Name</label>
                                <div class="col-sm-12">    
                                    <input type="text" class="form-control" name="device_payload" value="<?php echo isset($sDevicePayload) ? $sDevicePayload : ''; ?>">
                                </div>
                        </div>
                    </div>
                    <div id="website_url" style="display:none" class="source">
                        <div class="form-group">
                            <label class="urlwebsite control-label">URL <font style="color:red">*</font></label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="payload_url" value="<?php echo isset($sPayloadUrl) ? $sPayloadUrl: '';?>">
                                <div id="url_input" class="error-message">
                                    <?php echo isset($_SESSION['isValidation']['payload_url']) ? $_SESSION['isValidation']['payload_url'] : '';?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Local Folder / URL <font style="color:red">*</font></label>
                            <div class="col-sm-12">  
                                <input type="text" class="form-control" name="payload_name" value="<?php echo isset($sPayloadName) ? $sPayloadName: '';?>">
                                <div class="error-message">
                                    <?php echo isset($_SESSION['isValidation']['payload_name']) ? $_SESSION['isValidation']['payload_name'] : '';?>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                   <div id="google_drive" style="display:none" class="source">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Google Drive Link<font style="color:red">*</font> </label>  
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="google_drive_link" value="<?php echo isset($sGoogleDriveLink) ? $sGoogleDriveLink: '';?>">
                                <div id="url_input" class="error-message">
                                     <?php echo isset($_SESSION['isValidation']['google_drive_link']) ? $_SESSION['isValidation']['google_drive_link'] : '';?>
                                 </div><br/><br/>
                            </div>
                            <div class="col-sm-12 example1">Note: Provide the Google Drive Link obtained from "get link" option in Drive.</div>
                        </div>
                       <div class="form-group">
                            <label class="col-sm-12 control-label">Local Folder / URL <font style="color:red">*</font></label>
                                <div class="col-sm-12">
                                        <input type="text" class="form-control" name="google_payload_name" value="<?php echo isset($sGooglePayloadName) ? $sGooglePayloadName: '';?>">
                                    <div class="error-message">
                                        <?php echo isset($_SESSION['isValidation']['google_payload_name']) ? $_SESSION['isValidation']['google_payload_name'] : '';?>
                                    </div>
                                </div>
                        </div>
                       
                       
                    </div>
                    <div id="file_browse" style="display:none;" class="source">
                        <div class="col-sm-12">
                            <input type="file" name="upload_file" value="<?php echo isset($sFileName) ? $sFileName: '';?>Browse">
                            <div class="error-message">
                                <?php echo isset($_SESSION['isValidation']['upload_file']) ? $_SESSION['isValidation']['upload_file'] : '';?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Payload Name</label>
                            <div class="col-sm-12">    
                                <input type="text" class="form-control" name="file_payload" value="<?php echo isset($sFilePayload) ? $sFilePayload : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <br/>   
                    <div class="col-sm-12 folder_class">
                        <select name="folder_source" id="folder_source" class="col-sm-3 form-control extra" onchange="showData(this);">
                            <option id="check_folder">Select Payload Type</option>
                            <option id="check_play" value="payloads" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "payloads") ? "selected='selected'" : ""; ?>>Play</option>
                            <option id="check_admin" value="admin" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "admin") ? "selected='selected'" : ""; ?>>Admin</option>
                            <option id="check_admin" value="tv" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "tv") ? "selected='selected'" : ""; ?>>Service</option>
                            <option id="check_content" value="content" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "content" ) ? "selected='selected'" : ""; ?>>Content</option>
                            <option id="check_data" value="data" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "data" ) ? "selected='selected'" : ""; ?>>Data</option>
                        </select>
                        <div id="folder_source_error" class="error-message">
                            <?php echo isset($_SESSION['isValidation']['folder_source']) ? $_SESSION['isValidation']['folder_source'] : '';?>
                        </div>
                    </div>
                <div id="content_data" style="display:none">
                    <div class="col-sm-12 folder_class" id="folder_options"></div>
                </div>
                <br/><br/>
                <div class="go-button btn btn-lg btn-primary">
                    <input type="button" name="button" id="button" value="GO!" align="center" onClick="checkLoaded(true);">  
                </div>
            </div>
        </form>
<?php
    }
?>
    </body>
</html>