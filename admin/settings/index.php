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
            $sLanguage = $_POST['language'];
            $bShowDebugText = isset($_POST['show_debug']) ? $_POST['show_debug'] : 0;
            $sPayloadPath = isset($_POST['folder_source'])? $_POST['folder_source'] : '';
            if($sPayloadPath == "Select Payload Folder")
            {
                $_SESSION['isValidation']['folder_source'] = 'Please select payload folder!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            if(empty($sLanguage))
            {
                $_SESSION['isValidation']['language_required'] = 'Please enter language!!';
                $_SESSION['isValidation']['flag'] = FALSE;
            }
            if($_SESSION['isValidation']['flag'] == 1)
            {
                $sDocumentRoot = $_SERVER['DOCUMENT_ROOT'];
                $sSiteUrl = (isset($_SERVER["HTTP_HOST"]) ? "http://".$_SERVER["HTTP_HOST"] : '');
                $sListContent = "<?php
    define('ROOT_DIR','$sDocumentRoot');
    define('SITE_URL','$sSiteUrl');
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
            }   
            
        }
        if($_SESSION['isValidation']['flag'] == 1) 
        unset($_SESSION['isValidation']['site_url_required'],$_SESSION['isValidation']['base_url_required'],$_SESSION['isValidation']['language_required'],$_SESSION['isValidation']['root_dir_required']);
        
        if($_SESSION['isValidation']['flag'] == 1 || count($_SESSION['isValidation']) > 1)
        {

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
            <form id="getsetting_form" method="post" action="" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 title">
                        <h2>Enter settings Details</h2>
                    </div>
                    <div class="col-sm-12">
                        <select name="folder_source" id="folder_source" class="col-sm-3 form-control extra">
                             <option id="check_folder">Select Payload Folder</option>
                             <option id="check_admin" value="admin" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "admin") ? "selected='selected'" : ""; ?>>Admin</option>
                             <option id="check_payloads" value="payloads" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "payloads" ) ? "selected='selected'" : ""; ?>>Payloads</option>
                             <option id="check_data" value="data" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "data" ) ? "selected='selected'" : ""; ?>>Data</option>
                             <option id="check_content" value="content" <?php echo (isset($_POST['folder_source']) && $_POST['folder_source'] == "content" ) ? "selected='selected'" : ""; ?>>Content</option>
                         </select>
                         <div class="error-message">
                         <?php echo isset($_SESSION['isValidation']['folder_source']) ? $_SESSION['isValidation']['folder_source'] : '';?>
                          </div>
                     </div>
                    <div class="source">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Language<font style="color:red">*</font> </label>
                            <div class="col-sm-12">    
                                <input type="text" class="form-control" name="language">
                                <div class="error-message">
                                    <?php echo isset($_SESSION['isValidation']['language_required']) ? $_SESSION['isValidation']['language_required'] : '';?>
                                </div>
                            </div>
                        </div>
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