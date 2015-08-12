<!doctype html>
<html>
    <head>
       <meta charset="utf-8">
       <link href="../../css/bootstrap.min.css" rel="stylesheet">
       <link href="../../admin/buttons.css" rel="stylesheet">
       <link href="../../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
       <script src="../../js/jquery.js" type="text/javascript"></script>
    </head>
    <body>
<?php
        $_SESSION['isValidation']['flag'] = TRUE;
        if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_SESSION['isValidation']))
        {
            $sLanguage = isset($_POST['language']) ? $_POST['language'] : '';
            $bShowDebugText = isset($_POST['show_debug']) ? $_POST['show_debug'] : 0;
            $sPayloadPath = isset($_POST['folder_source'])? $_POST['folder_source'] : '';
            if($_SESSION['isValidation']['flag'] == 1)
            {
                $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
                $destination = $sFolderPath.'/data';
                if(file_exists($destination."/constants.php"))
                {
                    require_once "$destination/constants.php";
                    $sDocumentRoot = ROOT_DIR;
                    $sSiteUrl = SITE_URL;
                }
                else
                {
                    $sDocumentRoot = $_SERVER['DOCUMENT_ROOT'];
                    $sSiteUrl = (isset($_SERVER["HTTP_HOST"]) ? "http://".$_SERVER["HTTP_HOST"] : '');
                    rtrim($sSiteUrl, "/");
                }
                $sListContent = "<?php
    define('ROOT_DIR','$sDocumentRoot');
    define('SITE_URL','$sSiteUrl');
    define('PAYLOAD_FOLDER','$sPayloadPath');
    define('PAYLOAD_PATH','$sDocumentRoot/$sPayloadPath');
    define('LANGUAGE','$sLanguage');
    define('DEBUG_TEXT','$bShowDebugText');
?>";
                $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
                $destination = $sFolderPath.'/data';
                $myfile = fopen("$destination/constants.php", "w");
                $txt = $sListContent;
                fwrite($myfile, $txt);
                fclose($myfile);
                
                require_once "$destination/constants.php";
                echo '<h2>Settings Saved Successfully!!</h2>'
                    . '<div class="admin_img"><a href="'.SITE_URL.'/admin" class="btn btn-lg btn-primary color-white">Admin</a></div>'
                    . '<div class="play_img"><a href="'.SITE_URL.'/play/" class="btn btn-lg btn-primary color-white">Play</a></div>';
                die();
            }
        }
        
        if($_SESSION['isValidation']['flag'] == 1 || count($_SESSION['isValidation']) > 1)
        {
            $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
            $sDestination = $sFolderPath.'/data/bootstrap.php';
            require_once $sDestination;
?>
            <script type="text/javascript">
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
            </script>
            <div class="color-white">
                <a class="play_img" href="<?php echo SITE_URL.'/admin'; ?>">
                    <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
                </a>
            </div>
            <form id="getsetting_form" class="common-form" method="post" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 title">
                        <h2>Setup Settings</h2>
                    </div>
                    <div class="col-sm-12 playloadfolder">
                        <label>Select Payload Folder<font style="color:red">*</font></label>
                    </div>
                    <div class="col-sm-12">
                        <select name="folder_source" id="folder_source" class="col-sm-3 form-control extra">
<!--                         <option id="check_folder">Select Payload Folder</option>-->
                             <option id="check_admin" value="admin" <?php echo ((isset($_POST['folder_source']) && $_POST['folder_source'] == "admin") || PAYLOAD_FOLDER == "admin") ? "selected='selected'" : ""; ?>>Admin</option>
                             <option id="check_payloads" value="payloads" <?php echo ((isset($_POST['folder_source']) && $_POST['folder_source'] == "payloads" ) || PAYLOAD_FOLDER == "payloads") ? "selected='selected'" : ""; ?>>Payloads</option>
                             <option id="check_data" value="data" <?php echo ((isset($_POST['folder_source']) && $_POST['folder_source'] == "data" ) || PAYLOAD_FOLDER == "data") ? "selected='selected'" : ""; ?>>Data</option>
                             <option id="check_content" value="content" <?php echo ((isset($_POST['folder_source']) && $_POST['folder_source'] == "content" ) || PAYLOAD_FOLDER == "content") ? "selected='selected'" : ""; ?>>Content</option>
                             <option id="check_play" value="play" <?php echo ((isset($_POST['folder_source']) && $_POST['folder_source'] == "play" ) || PAYLOAD_FOLDER == "play") ? "selected='selected'" : ""; ?>>Play</option>
                         </select>
                         
                     </div>
                    <div class="col-sm-12 playloadfolder">
                        <label>Select Language<font style="color:red">*</font></label>
                    </div>
                    <div class="col-sm-12">
                        <select name="language" id="language" class="col-sm-3 form-control extra">
                             <option value="en" <?php echo ((isset($_POST['language']) && $_POST['language'] == "en") || LANGUAGE == "en") ? "selected='selected'" : ""; ?>>English</option>
                             <option value="nl" <?php echo ((isset($_POST['language']) && $_POST['language'] == "nl" ) || LANGUAGE == "nl")? "selected='selected'" : ""; ?>>Dutch</option>
                         </select>
                     </div>
                    <div class="source">
                        <label class="start_payload"><input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($_POST['show_debug']) ? $_POST['show_debug'] : '0'; ?>" <?php echo isset($_POST['show_debug']) ? "checked='checked'" : ""; ?> onClick="changeValue('show_debug');">  Show debug text</label>
                    </div>
                    <label class="col-sm-12 source"><font style="color:red">*</font> Indicates mandatory field</label>
                    <div class="go-button btn btn-lg btn-primary">
                        <input type="submit" name="setting_button" id="setting_button" value="GO!" align="center">  
                    </div>
                </div>
            </form>    
<?php
    }
?>            
    </body>
</html>