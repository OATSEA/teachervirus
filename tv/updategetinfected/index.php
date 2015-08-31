<?php 
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    error_reporting(E_ALL ^ E_WARNING);
    require_once("../../data/constants.php");
    require(ROOT_DIR.'/admin/checkLogin.php');
?>
<html>
    <head>
        <title>Get Infected</title>
        <meta charset="utf-8">
        <style>
                body{
                    background-color: black;
                    min-height:800px;
                    padding: 0px;
                    margin: 0;
                    color: #fff;
                }
                form{
                    border: thin solid #fff;
                    margin-left: 25%;
                    padding: 15px;
                    width: 50%;
                }
                .error-message{
                    color: red;
                    text-align: right;
                    width: 20%;
                }
                .sources{
                    margin-left: 40px;
                }
                .go-button{
                    color: #000;
                    float: right;
                    width: 60px;
                }
                .admin_img {
                    color: #fff;
                    float: right;
                    padding-bottom: 10px;
                    padding-right: 20px;
                    padding-top: 10px;
                }
                a { color: #fff; text-decoration: none;}
                .color-white{
                    color: #fff;
                    line-height: 15px;
                    margin-left: 15px;
                    margin-top: 15px;
                }
                .mainNav:hover {
                        color: blue;
                    }
                input[type="text"] {
                    color: #000;
                    float: left;
                    width: 35%;
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
                #loading {
                    font-size: 70px;
                    font-weight: bold;
                    color: #000;
                    width: 100%;
                    height: 100%;
                    top: 0px;
                    left: 0px;
                    position: fixed;
                    display: block;
                    opacity: 0.7;
                    background-color: #fff;
                    z-index: 99;
                    text-align: center;
                }
                #loading-image {
                   position: absolute;
                   top: 100px;
                   left: 240px;
                   z-index: 100;
                }
                .button
		{
			color: #fff;
			text-decoration: none;
			display: inline-block;
			padding: 4px 10px;
			-webkit-border-radius: 5px;
			font: normal 14px/16px Helvetica, Arial, sans-serif;
		}
		.button.black {
			background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, from(#7d828c),color-stop(0.5, #303749), color-stop(0.5, #121a2e), to(#121a2e));
			border: 5px solid rgba(255, 255, 255, 1);
                        border-radius: 25px 0 0 25px;
		}
		.button.black:hover {
			background-image: -webkit-gradient(linear, 0% 0%, 0% 100%, 
				from(#4286f5), 
				color-stop(0.5, #4286f5),
				color-stop(0.5, #194fdb),
				to(#194fdb));
		}
		.button.back {
			position: relative;
			padding-left: 5px;
			margin-left: 8px;
		}
		.back.black > span {
                        display: block;
                        height: 20px;
                        width: 20px;
                        background-image: -webkit-gradient(linear, left top, right bottom, 
                               from(#7d828c),
                               color-stop(0.5, #303749), 
                               color-stop(0.5, #121a2e), 
                               to(#121a2e));
                        border-left: solid 1px rgba(79, 79, 79, 0.75);
                        border-bottom: solid 1px rgba(79, 79, 79, 0.75);
                       -webkit-transform: rotate(45deg);
                       -webkit-mask-image: -webkit-gradient(linear, left bottom, right top, 
                               from(#000000), 
                               color-stop(0.5,#000000), 
                               color-stop(0.5, transparent), 
                               to(transparent));
                 }
		.back:hover > span {
			background-image: -webkit-gradient(linear, left top, right bottom, 
				from(#4286f5), 
				color-stop(0.5, #4286f5),
				color-stop(0.5, #194fdb),
				to(#194fdb));
		}
                .arrow-left {
                        border-bottom: 30px solid transparent;
                        border-right: 30px solid #fff;
                        border-top: 30px solid transparent;
                        height: 0;
                        width: 20px;
                }
                .radio_class
                {
                   margin: 10px 0px 10px 4px; 
                }
                .go-back{
                    background: #fff none repeat scroll 0 0;
                    border: 1px solid #fff;
                    color: #000;
                    font-size: 18px;
                    font-weight: bold;
                    margin-left: 15px;
                    padding: 0 8px;
                }
                
        </style>
         <script type="text/javascript">
            function checkLoaded(loaded){
                if(loaded == true)
                {
                    document.getElementById("loading").style.display = "block";
                    document.getElementById("getinfected_form").submit();
                }
                else
                {
                    document.getElementById("loading").style.display = "none";
                }
            }
        </script>
    </head>
    <body class="main" onload="checkLoaded(false);">
    <div id="loading">
        <?php 
        
            echo (is_dir(ROOT_DIR."/admin")) ? "Updating..." : "Installing...";
        ?>
    </div>
    <script>
        checkLoaded(false);
    </script>
<?php
    $debug = isset($_POST['show_debug']) ? $_POST['show_debug'] : 0;
    $bChmod = isset($_POST['chmod']) ? $_POST['chmod'] : 0;
    $nMode = ($bChmod == 1) ? 0755 : '';
    $installed=0;
    $_SESSION['isValidation']['flag'] = TRUE;
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_SESSION['isValidation']))
    {
        $sBranchName = isset($_POST['branch_name']) ? $_POST['branch_name'] : '';
        $sDeviceAddress = isset($_POST['device_address']) ? ($_POST['device_address']):'';
        $sFileName = isset($_FILES['upload_file']['name']) ? ($_FILES['upload_file']['name']):'';
        $sTempFileName = isset($_FILES['upload_file']['tmp_name'])? ($_FILES['upload_file']['tmp_name']):'';
        $nPort = isset($_POST['port_number']) ? $_POST['port_number']:'';
        $sInfectionResource = isset($_POST['infection_resource']) ? $_POST['infection_resource'] : '';
        
        if($sInfectionResource == 'branch_value')
        {
            if(empty($sBranchName))
            {
                $_SESSION['isValidation']['branch_name'] = 'Please enter branch!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
        }
        if($sInfectionResource == 'infected_device')
        {
            if(empty($sDeviceAddress))
            {
                $_SESSION['isValidation']['device_address'] = 'Please enter device address!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
        }
        if($sInfectionResource == 'file_browse')
        {
            if(empty($sFileName))
            {
                $_SESSION['isValidation']['upload_file'] = 'Please Choose File!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
        }
        
        if($_SESSION['isValidation']['flag'] == 1)
        {
            $_SESSION['getinfected_branch'] = $sBranchName;
            unlink(ROOT_DIR."/data/constants.php");
            require_once(getcwd().'/data/bootstrap.php');
            function rrmdir($dir)
            {
               if (is_dir($dir)) { 
                 $objects = scandir($dir); 
                 foreach ($objects as $object) { 
                   if ($object != "." && $object != "..") { 
                       
                     if (filetype($dir."/".$object) == "dir") 
                     {
                        rrmdir($dir."/".$object); 
                     }
                     else 
                     {
                         unlink($dir."/".$object); 
                     }
                   } 
                 } 
                 reset($objects); 
                 rmdir($dir);
               } 
            }
            
            // getinfected.php is the initial teacher virus PHP infection script that is used to install the core Teacher Virus files.
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

            // prompt for IP address as alternative infector

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
                <p>Enter IP address or DNS of infected device</p>
                <p><b>Tip:</b> You can find the IP address of an infected device in the admin page of Teacher Virus.</p>
                <p>Address of Infected Device:</p>
                <p><input id='address' type='text' name='address' required></p>
                <p><button type='button' onclick='buttonClick();'>Go!</button></p>
                ";

                exit("<hr>");

            } // END promptForIP

            //----------
            //Make a new directory with optional error messages
            function makeDIR($directory,$debugtxt=0) {
                
                // Create infect directory if it doesn't exist:
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

            function moveDIR($dir,$dest="",$debug) {
                //$debug = 1;
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

                            if (!moveDIR($pathFile,$newDir,$debug)) {
                                $result = false;
                            }

                        } else {
                            if($debug) {echo "<p>$pathFile is a file</p>"; }

                            // $currentFile = realpath($file); // current location
                            $currentFile = $pathFile;

                            $newFile = $dest."/".$file;

                            if (!file_exists($dest)) {
                                makeDIR($dest,$debug);
                            }
                            // if file already exists remove it
                            if (file_exists($newFile)) {
                                //if($debug) { echo "<p>File $newFile already exists - Deleting</p>"; }
                                unlink($newFile);
                            } else {
                                if($debug) { echo "<p>File $newFile doesn't exist yet</p>"; }
                            }

                            // Move via rename
                            // rename(oldname, newname)
                            if (rename($currentFile , $newFile)) {
                                //if($debug) { echo "<p>Moved $currentFile to $newFile</p>"; }
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
                    <title>Loading Teacher Virus</title>
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
            /*if (file_exists('play')) {
                // if play folder exists then Teacher Virus is already installed and we don't want to allow script to run again so
                //displayRedirect();

            } else {*/
                if ($debug) { echo "<h1>Updating Get Infected!</h1>";}
                // play folder doesn't exist
                // Check if ip param is set to either an IP address or a url (i.e. without http:// infront)    
                // $ip="10.1.1.38" or "test.teachervirus.org"

                if(isset($sDeviceAddress) && (!empty($sDeviceAddress))) {
                    $ip= $sDeviceAddress;
                    if($debug) {echo "<p>Address has been provided as: $ip</p>"; }
                } else {
                    $ip="no";
                } // end IP is set check

            //} //  END play check
            
            //----------------------------------    
            // Download OATSEA-teachervirus.zip 
            // ------------------------------------
            if ($debug) { echo "<h2>Attempting to update Get Infected</h2>"; }

            $sUpdateinfectedDir = ROOT_DIR.'/tv/updategetinfected/';
            // default destination for downloaded zipped files

            
            if($sInfectionResource == 'file_browse')
            {
                move_uploaded_file($sTempFileName, $sUpdateinfectedDir.'/'.$sFileName);
            }
            
            if(empty($sFileName))
            {
                $username = "OATSEA";
                $repo = "getinfected";
                $download_filename = $username.'-'.$repo.'.zip';
                $download_unzip_filename = $username.'-'.$repo;
            }
            else
            {
                $aExplodeFileName = explode(".zip",$sFileName);
                $download_filename = $sFileName;
                $download_unzip_filename = $aExplodeFileName[0];
            }
            $zipfile = $sUpdateinfectedDir.$download_filename;
            $sUrl = (is_dir(ROOT_DIR."/admin")) ? SITE_URL."/admin" : ROOT_DIR."/getinfected.php";
            // Check for IP param and set $ip if param provided
            // ** TO DO **
            // Download file if OATSEA-teachervirus.zip doesn't already exist
            if (file_exists($zipfile)) 
            {
                if ($debug) { echo "<h2>Download Files</h2>";}

                // ** TO DO ** catch warnings
                // get following error on MAC: 
                // Warning: copy(): SSL operation failed with code 1.
                umask(0);
                echo "<h3>Unzip Successful!</h3>";
                $zip = new ZipArchive;
                // Get array of all source files
                //$payload = '/tv/updategetinfected';
                // Identify directories
                $sFolderPath = ROOT_DIR;

                $destination = $sFolderPath.'/tv/updategetinfected';
                if (!file_exists($destination))
                    mkdir($destination,0775,true);

                $copyflag = FALSE;

                if(($ip == "no" && $sInfectionResource == 'branch_value') )
                {
                    $geturl = (!empty($sBranchName) && isset($_POST['infection_resource']) && $_POST['infection_resource'] == "branch_value") ? "https://github.com/$username/$repo/zipball/$sBranchName/" : "https://github.com/$username/$repo/zipball/master/";
                    $copyflag = copy($geturl,ROOT_DIR.'/'.$zipfile);
                }
                else if($sInfectionResource == 'infected_device')
                {
                    $geturl = empty($nPort) ? "http://$ip/$zipfile" : "http://$ip:$nPort/$zipfile";
                    $copyflag = copy($geturl,ROOT_DIR.'/'.$zipfile);
                }
                else if($sInfectionResource == 'file_browse')
                {
                    $copyflag = TRUE;
                }
                
                if ($debug) {echo "<h2>Attempting to Unzip</h2><p>Zipped file:  $zipfile </p>";}
                $zipFlag = $zip->open($destination.'/'.$download_filename,true);
                if ($zipFlag === TRUE) 
                {

                    $sUpdateInfectUrl = ROOT_DIR.'/tv/updategetinfected';
                    // Create full temp sub_folder path
                    $temp_unzip_path = $sUpdateInfectUrl.'/'.uniqid('unzip_temp_', true)."/";

                    if($debug) { echo "Temp Unzip Path is: ".$temp_unzip_path."<br>"; }

                    // Make the new temp sub_folder for unzipped files
                    if (!mkdir($temp_unzip_path, $nMode, true)) {
                        exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create unzip folder: $temp_unzip_path</p><p>File security or permissions issue? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
                    } else {
                        if($debug) { echo "<p>Temp unzip Folder Created! <br>"; }
                    }
                    if(is_dir($sUpdateInfectUrl))
                    {
                        $zip->extractTo($temp_unzip_path);
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>Already installed? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
                            } else {
                                if($debug) { echo "<p>Folder Created! <br>"; }
                            }
                        }
                        else
                        {
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>File security or permissions issue? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
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
                                    moveDIR($temp_unzip_path . $value,$sUpdateInfectUrl.'/'.$download_unzip_filename,$debug);
                                }
                            }
                        }
                        if(is_dir($temp_unzip_path))
                        {
                            rrmdir($temp_unzip_path);
                        }
                        
                        $files = scandir($sUpdateInfectUrl.'/'.$download_unzip_filename,1);
                        foreach ($files as $key => $value)
                        {
                           if (!in_array($value,array(".","..")))
                           {
                                copy($sUpdateInfectUrl.'/'.$download_unzip_filename.'/'.$value,ROOT_DIR.'/'.$value);
                           }
                        }
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                        }
                    }
                    else
                    {
                        $zip->extractTo($temp_unzip_path);
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>Already installed? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
                            } else {
                                if($debug) { echo "<p>Folder Created! <br>"; }
                            }
                        }
                        else
                        {
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>File security or permissions issue? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
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
                                moveDIR($temp_unzip_path . $value,$sUpdateInfectUrl.'/'.$download_unzip_filename,$debug);
                              }
                           }
                        }
                        if(is_dir($temp_unzip_path))
                        {
                            rrmdir($temp_unzip_path);
                        }
                        
                        $files = scandir($sUpdateInfectUrl.'/'.$download_unzip_filename,1);
                        foreach ($files as $key => $value)
                        {
                           if (!in_array($value,array(".","..")))
                           {
                                copy($sUpdateInfectUrl.'/'.$download_unzip_filename.'/'.$value,ROOT_DIR.'/'.$value);
                           }
                        }
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                        }
                    }
                }
                $zip->close();
                unlink($zipfile);
                $installed = 1;
                echo "<h2>Update Successfully</h2>";
                if (is_dir(ROOT_DIR."/admin")) 
                {
                    echo '<link href="'.SITE_URL.'/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
                            <div class="color-white">
                                <a class="play_img" href="'.$sUrl.'">
                                    <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
                                </a>
                            </div><br/><br/>';
                }
                else
                {
                    echo '<div class="color-white">
                                <a href="'.$sUrl.'" class="go-back">Go Back</a>
                            </div><br/><br/>';
                }
            }
            else 
            {
                if ($ip=="no") {
                    // Download from github zipball/master as no IP address set
                    $geturl = (!empty($sBranchName) && isset($_POST['infection_resource']) && $_POST['infection_resource'] == "branch_value") ? "https://github.com/$username/$repo/zipball/$sBranchName/" : "https://github.com/$username/$repo/zipball/master/";
                } else {
                    // as IP address has been set attempt download from IP address
                   $geturl = empty($nPort) ? "http://$ip/$zipfile" : "http://$ip:$nPort/$zipfile";
                }
                // TRY DOWNLOAD via copy
                if ($debug) { echo "<h2>Download Files</h2>
                   <p>Will attempt to download via copy from <b>$geturl</b></p> ";}
                // ** TO DO ** catch warnings
                // get following error on MAC: 
                // Warning: copy(): SSL operation failed with code 1.
                $copyflag = copy($geturl,$zipfile);
                
                if ($copyflag === TRUE) {
                    if($debug) { echo "<h3>Download Succeeded</h3>"; }
                    if($debug) { echo "<p>Files downloaded using <b>Copy</b> instead</p>"; }
                } else { 
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
                        exit("<h3><b>ERROR! Update getinfected failed</h3> 
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
                                <p>Error updating getinfected via CURL</p>";
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
                        echo "<h3>Update Failed!</h3><p>Couldn't download with either copy or curl</p>";
                            echo '<link href="'.SITE_URL.'/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
                                    <div class="color-white">
                                        <a class="play_img" href="'.$sUrl.'">
                                            <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
                                        </a>
                                    </div><br/><br/>';
                        unlink(ROOT_DIR.'/'.$zipfile);
                        die();
                        //promptForIP();
                    } // If Download failed using CURL 
                }// END else CURL
            


                if ($debug) { echo "<h2>Download Files</h2>";}

                // ** TO DO ** catch warnings
                // get following error on MAC: 
                // Warning: copy(): SSL operation failed with code 1.
                umask(0);
                echo "<h3>Unzip Successful!</h3>";
                $zip = new ZipArchive;
                // Get array of all source files
                //$payload = '/tv/updategetinfected';
                // Identify directories
                $sFolderPath = ROOT_DIR;

                $destination = $sFolderPath.'/tv/updategetinfected';
                if (!file_exists($destination))
                    mkdir($destination,0775,true);

                $copyflag = FALSE;

                
                if ($debug) {echo "<h2>Attempting to Unzip</h2><p>Zipped file:  $zipfile </p>";}
                $zipFlag = $zip->open($destination.'/'.$download_filename,true);
                if ($zipFlag === TRUE) 
                {

                    $sUpdateInfectUrl = ROOT_DIR.'/tv/updategetinfected';
                    // Create full temp sub_folder path
                    $temp_unzip_path = $sUpdateInfectUrl.'/'.uniqid('unzip_temp_', true)."/";

                    if($debug) { echo "Temp Unzip Path is: ".$temp_unzip_path."<br>"; }

                    // Make the new temp sub_folder for unzipped files
                    if (!mkdir($temp_unzip_path, $nMode, true)) {
                        exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create unzip folder: $temp_unzip_path</p><p>File security or permissions issue? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
                    } else {
                        if($debug) { echo "<p>Temp unzip Folder Created! <br>"; }
                    }
                    if(is_dir($sUpdateInfectUrl))
                    {
                        $zip->extractTo($temp_unzip_path);
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>Already installed? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
                            } else {
                                if($debug) { echo "<p>Folder Created! <br>"; }
                            }
                        }
                        else
                        {
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>File security or permissions issue? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
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
                                    moveDIR($temp_unzip_path . $value,$sUpdateInfectUrl.'/'.$download_unzip_filename,$debug);
                                }
                            }
                        }
                        if(is_dir($temp_unzip_path))
                        {
                            rrmdir($temp_unzip_path);
                        }
                        
                        $files = scandir($sUpdateInfectUrl.'/'.$download_unzip_filename,1);
                        foreach ($files as $key => $value)
                        {
                           if (!in_array($value,array(".","..")))
                           {
                                copy($sUpdateInfectUrl.'/'.$download_unzip_filename.'/'.$value,ROOT_DIR.'/'.$value);
                           }
                        }
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                        }
                    }
                    else
                    {
                        $zip->extractTo($temp_unzip_path);
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>Already installed? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
                            } else {
                                if($debug) { echo "<p>Folder Created! <br>"; }
                            }
                        }
                        else
                        {
                            if (!mkdir($sUpdateInfectUrl.'/'.$download_unzip_filename, $nMode, true)) {
                                exit("<h2>Error - Update Get Infected Failed!</h2><p> Could not create folder: $download_unzip_filename</p><p>File security or permissions issue? Please check Chmod On?<a href='".$sUrl."' class='go-back'>Go Back</a>");
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
                                moveDIR($temp_unzip_path . $value,$sUpdateInfectUrl.'/'.$download_unzip_filename,$debug);
                              }
                           }
                        }
                        if(is_dir($temp_unzip_path))
                        {
                            rrmdir($temp_unzip_path);
                        }
                        
                        $files = scandir($sUpdateInfectUrl.'/'.$download_unzip_filename,1);
                        foreach ($files as $key => $value)
                        {
                           if (!in_array($value,array(".","..")))
                           {
                                copy($sUpdateInfectUrl.'/'.$download_unzip_filename.'/'.$value,ROOT_DIR.'/'.$value);
                           }
                        }
                        if(is_dir($sUpdateInfectUrl.'/'.$download_unzip_filename))
                        {
                            rrmdir($sUpdateInfectUrl.'/'.$download_unzip_filename);
                        }
                    }
                }
                    $zip->close();
                    unlink($zipfile);
                    $installed = 1;
                    echo "<h2>Update Successfully</h2>";
                    if (is_dir(ROOT_DIR."/admin")) 
                    {
                        echo '<link href="'.SITE_URL.'/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
                                <div class="color-white">
                                    <a class="play_img" href="'.$sUrl.'">
                                        <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
                                    </a>
                                </div><br/><br/>';
                    }
                    else
                    {
                        echo '<div class="color-white">
                                    <a href="'.$sUrl.'"" class="go-back">Go Back</a>
                                </div><br/><br/>';
                    }
            } // END Download if zipfile doesn't already exists
        }
    }
    function redirect($filename)
    {
        if (!headers_sent())
            header('Location: '.$filename);
        else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="'.$filename.'";';
            echo '</script>';
            echo '<noscript>';
            echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
            echo '</noscript>';
        }
    }
if($_SESSION['isValidation']['flag'] == 1) 
        unset($_SESSION['isValidation']['user_name_required'],$_SESSION['isValidation']['repository_required'],$_SESSION['isValidation']['branch_name'],$_SESSION['isValidation']['device_address'],$_SESSION['isValidation']['upload_file']);

    if($_SESSION['isValidation']['flag'] == 1 || count($_SESSION['isValidation']) > 1)
    {
        $_SESSION['isLoggedIn'] = isset($_SESSION['isLoggedIn']) ? $_SESSION['isLoggedIn'] : FALSE;
        if((is_dir(ROOT_DIR."/admin") && (isset($_SESSION['isLoggedIn']) && !$_SESSION['isLoggedIn'])) || (isset($_GET['isValidUser']) && (isset($_SESSION['isLoggedIn']) && !$_SESSION['isLoggedIn'])))
        {
            redirect(SITE_URL."/admin");
        }
        else if(!$installed)
        {
?>
        <script type="text/javascript">
            function showData(divId)
            {
                if(divId == "infected_device")
                {
                  document.getElementById("infected_device").style.display = "block";
                  document.getElementById("branch_value").style.display = "none";
                  document.getElementById("file_browse").style.display = "none";
                }
                else if(divId == "branch_value")
                {
                    document.getElementById("infected_device").style.display = "none";
                    document.getElementById("branch_value").style.display = "block";
                    document.getElementById("file_browse").style.display = "none";
                }
                else if(divId == "file_browse")
                {
                  document.getElementById("file_browse").style.display = "block";
                  document.getElementById("branch_value").style.display = "none";
                  document.getElementById("infected_device").style.display = "none";
                }
            }
            function changeValue(boxId)
            {
                if (document.getElementById(boxId).checked)
                {
                    document.getElementById(boxId).value = 1;
                }
                else
                {
                    document.getElementById(boxId).value = 0;
                }
                if(boxId == "remove_previous_install")
                {
                    document.getElementById("delete_data").checked = true;
                    document.getElementById("delete_payload").checked = true;
                    document.getElementById("admin_payload").checked = true;
                    document.getElementById("delete_content").checked = true;
                    document.getElementById("delete_data").value = 1;
                    document.getElementById("delete_payload").value = 1;
                    document.getElementById("admin_payload").value = 1;
                    document.getElementById("delete_content").value = 1;
                }
                if(boxId == "download_latest_version")
                {
                    if (document.getElementById(boxId).checked)
                    {
                        document.getElementById("infection_sources").style.display = "block";
                    }
                    else
                    {
                        document.getElementById("infection_sources").style.display = "none";
                    }
                }
            }
            function removePort(textId)
            {
                document.getElementById(textId).value = '';
            }
            function showMain(mainId)
            {
                var buttonId = document.getElementById('show_settings');
                var deleteButtonId = document.getElementById('show_delete_option');
                var divId = document.getElementById('delete_file');
                if(mainId != "")
                {
                    document.getElementById(mainId).style.display = "block";
                    document.getElementById("setting_value").value = 'main';
                    buttonId.value= 'Hide Advanced Settings';
                    deleteButtonId.value = 'Hide Options';
                    divId.style.display = 'block';
                }
                else
                {
                    document.getElementById("setting_value").value = 'main';
                    buttonId.value= 'Show Advanced Settings';
                    deleteButtonId.value = 'Show Options';
                    divId.style.display = 'none';
                }
            }
            function disableDelete(isInstalledInfect)
            {
                if(isInstalledInfect == 1)
                {
                    document.getElementById("delete_data").checked = false;
                    document.getElementById("delete_payload").checked = false;
                    document.getElementById("admin_payload").checked = false;
                    document.getElementById("delete_content").checked = false;
                    document.getElementById("delete_data").value = 0;
                    document.getElementById("delete_payload").value = 0;
                    document.getElementById("admin_payload").value = 0;
                    document.getElementById("delete_content").value = 0;
                }
            }
            window.onload = function ()
            {
                showData("<?php echo isset($_POST['infection_resource']) ? $_POST['infection_resource'] : 'branch_value'; ?>");
                showMain("<?php echo isset($_POST['setting_value']) ? $_POST['setting_value'] : ''?>");
                disableDelete("<?php echo is_dir(ROOT_DIR."/admin") ? 1 : 0; ?>")
            }
            function toggleVisibility(id,inputid) 
            {
                var divId = document.getElementById(id);
                var buttonId = document.getElementById(inputid);
                if (divId.style.display == 'block' || divId.style.display=='')
                {
                    buttonId.value= 'Show Advanced Settings';
                    divId.style.display = 'none';
                }
                else 
                {
                    buttonId.value= 'Hide Advanced Settings';
                    divId.style.display = 'block';
                }
            }
            function toggleDeleteFile(id,buttonid)
            {
                 var divId = document.getElementById(id);
                 var buttonId = document.getElementById(buttonid);
                 if (divId.style.display == 'block' || divId.style.display=='')
                {
                    buttonId.value = 'Show Options';
                    divId.style.display = 'none';
                }
                else 
                {
                    buttonId.value = 'Hide Options';
                    divId.style.display = 'block';
               }
            }
        </script>
    <?php 
        if (is_dir(ROOT_DIR."/admin")) 
        {
    ?>
            <link href="<?php echo SITE_URL; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <div class="color-white">
                <a class="play_img" href="<?php echo SITE_URL.'/admin'; ?>">
                    <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
                </a>
            </div><br/><br/>
    <?php 
        } 
    ?>  
        <form method="post" action="" id="getinfected_form" enctype="multipart/form-data">
            <div id="container">
                <div class="payload-details">
                <h2>Update Get Infected</h2>
                </div>
                <div>
                    <input type="button" id="show_settings" value="Show Advanced Settings" onclick="toggleVisibility('main','show_settings');">
                </div><br/>
                <div id="main" style="display:none">
                    <div id="infection_sources">
                        <div style="font-weight:bold;">Update Source:</div><br/>
                        <input type="radio" class="radio_class" name="infection_resource" value="branch_value" <?php echo (isset($_POST['infection_resource']) && $_POST['infection_resource'] == "branch_value") ? "checked='checked'" : "checked='checked'"; ?> onclick="showData('branch_value');"> GitHub
                        <div id="branch_value" style="display:none;" class="sources">
                            <br/>
                            <div class="text-field">Branch?<font color="red">*</font></div>
                            <input type="text" value="<?php echo isset($_POST['branch_name']) ? $_POST['branch_name'] : TV_BRANCH; ?>" name="branch_name" id="branch_name">
                            <input type="button" value="Clear" onclick="removePort('branch_name');"/><br/>
                            <div class="error-message">
                                <?php echo isset($_SESSION['isValidation']['branch_name']) ? $_SESSION['isValidation']['branch_name'] : '';?>
                            </div>
                        </div><br/>
                        <input type="radio" class="radio_class" name="infection_resource" value="infected_device" <?php echo (isset($_POST['infection_resource']) && $_POST['infection_resource'] == "infected_device" ) ? "checked='checked'" : ""; ?> onclick="showData('infected_device');"> Infected Device
                    </div>
                    
                    <div id="infected_device" style="display:none;" class="sources">
                        <div class="text-field">Infected Device Address <font color="red">*</font></div>
                        <input type="text" name="device_address">
                        <div class="error-message">
                            <?php echo isset($_SESSION['isValidation']['device_address']) ? $_SESSION['isValidation']['device_address'] : '';?>
                        </div>
                        <br/><br/>
                        <div class="example-text">Provide an IP or URL - For Example: 192.168.143.1 or demo.teachervirus.org</div><br/>
                        <div class="text-field">Port</div>
                        <input type="text" name="port_number" id="port_number" value="8080">
                        <input type="button" value="Clear" onclick="removePort('port_number');"/>
                        <br/><br/><div class="example-text">Android devices are normally 8080.  Clear the field if using a normal webserver</div>
                    </div>
                    <div>
                        <input type="radio" class="radio_class"  name="infection_resource" value="file_browse" <?php echo (isset($_POST['infection_resource']) && $_POST['infection_resource'] == "file_browse" ) ? "checked='checked'" : ""; ?> onclick="showData('file_browse');"> File Upload
                    </div>
                    <div id="file_browse" style="display:none;" class="sources">
                        <div class="radio_class">
                            <input type="file" name="upload_file" value="Browse">
                        </div>
                        <div class="error-message">
                            <?php echo isset($_SESSION['isValidation']['upload_file']) ? $_SESSION['isValidation']['upload_file'] : '';?>
                        </div>
                    </div>
                    <div>
                        <b><input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($_POST['show_debug']) ? $_POST['show_debug'] : '0'; ?>" <?php echo isset($_POST['show_debug']) ? "checked='checked'" : ""; ?> onclick="changeValue('show_debug');">  Show debug text</b>
                    </div>
                    <br/>
                    <div>
                        <b><input type="checkbox" name="chmod" id="chmod" value="<?php echo isset($_POST['chmod']) ? $_POST['chmod'] : '0'; ?>" <?php echo isset($_POST['chmod']) ? "checked='checked'" : ""; ?> onclick="changeValue('chmod');">  Chmod?</b>
                    </div>
                     <br/>
                    <div class="mandatory"><font color="red">*</font> indicates mandatory field</div>
                </div>
                    <div class="go-button">
                        <input type="button" name="button" id="button" value="GO!" align="center" onclick="checkLoaded(true);">  
                    </div><br/>    
            </div>
            <input type="hidden" name="setting_value" id="setting_value">
        </form>
<?php
        }
    }
?>
    </body>
</html>