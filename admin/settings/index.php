<!doctype html>
<html>
    <head>
       <meta charset="utf-8">
       <link href="../../css/bootstrap.min.css" rel="stylesheet">
       <link href="../buttons.css" rel="stylesheet">
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
        $sFolderLocation = isset($_POST['folder_location'])? $_POST['folder_location'] : '';
        $bExternalSource = isset($_POST['external_source'])? $_POST['external_source'] : 0;

        if($bExternalSource)
        {
            if(empty($sFolderLocation))
            {
               $_SESSION['isValidation']['folder_location_required'] = 'Please enter folder location!!';
               $_SESSION['isValidation']['flag'] = FALSE;
            }

        }
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
                $sSiteUrl = (isset($_SERVER['SERVER_NAME']) ? "http://".$_SERVER['SERVER_NAME'] : '');
                rtrim($sSiteUrl, "/");
            }
            $sListContent = "<?php
define('ROOT_DIR','$sDocumentRoot');
define('SITE_URL','$sSiteUrl');
define('ROOT_FOLDER','$sFolderLocation');
define('ROOT_PATH','$sDocumentRoot/$sFolderLocation');
define('LANGUAGE','$sLanguage');
define('DEBUG_TEXT','$bShowDebugText');
define('EXTERNAL_TEXT','$bExternalSource');
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
    if($_SESSION['isValidation']['flag'] == 1)
        unset($_SESSION['isValidation']['folder_location_required']);

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

                if(eValue == "external_source" && isChecked.checked)
                {
                    $("#folder_location_address").show();
                }
                else if(eValue == "external_source")
                {
                    $("#folder_location_address").hide();
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
                    <h2>Global Configuration</h2>
                </div>
                <div class="col-sm-12 title">
                    <label class="control-label"><font style="color:red">*</font>Indicates mandatory field</label>
                </div>
                <div class="form-group">
                    <label class="col-sm-12 control-label">Language:</label>
                    <div class="col-sm-12">    
                        <input type="text" name="language" id="language" value="<?php echo isset($_POST['language']) ? $_POST['language'] : LANGUAGE; ?>" >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="checkbox" name="external_source" id="external_source" value="<?php echo isset($bExternalSource) ? $bExternalSource: '0'; ?>" <?php echo (isset($bExternalSource) && ($bExternalSource)) ? "checked='checked'" : ""; ?>onClick="changeValue('external_source');">  
                        <label class="start_payload">Use External Storage?</label>
                    </div>
                </div>
                <div id="folder_location_address" style="<?php echo (isset($sFolderLocation) && empty($sFolderLocation)) ? 'display:block' : 'display:none'; ?>">
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Folder Location:<font style="color:red">*</font></label>
                        <div class="col-sm-12">
                            <input type="text" name="folder_location" class="form-control" value="<?php echo isset($_POST['folder_location']) ? $_POST['folder_location'] : ROOT_FOLDER ; ?>" ></label>
                            <div class="error-message">
                                <?php echo isset($_SESSION['isValidation']['folder_location_required']) ? $_SESSION['isValidation']['folder_location_required'] : '';?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($_POST['show_debug']) ? $_POST['show_debug'] : '0'; ?>" <?php echo isset($_POST['show_debug']) ? "checked='checked'" : ""; ?> onClick="changeValue('show_debug');">
                        <label class="start_payload">Show debug text?</label>
                    </div>
                </div>
                <div class="go-button btn btn-lg btn-primary">
                    <input type="submit" name="setting_button" id="setting_button" value="Update Settings" align="center">  
                </div>
            </div>
        </form>
<?php
    }
?>            
    </body>
</html>