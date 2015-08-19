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
            $sLanguage = isset($_POST['language']) ? $_POST['language'] : 0;
            $bShowDebugText = isset($_POST['show_debug']) ? $_POST['show_debug'] : 0;
            $sFolderLocation = isset($_POST['folder_location'])? $_POST['folder_location'] : '';
            $bExternalSource = isset($_POST['external_source'])? $_POST['external_source'] : 0;
            $bAdminCog = isset($_POST['admin_cog']) ? $_POST['admin_cog'] : 0;

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
define('EXTERNAL_PATH','$sFolderLocation');
define('LANGUAGE','$sLanguage');
define('DEBUG_TEXT','$bShowDebugText');
define('EXTERNAL_TEXT','$bExternalSource');
define('ADMIN_COG','$bAdminCog');
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
                            <!--<input type="text" name="language" id="language" value="<?php echo isset($_POST['language']) ? $_POST['language'] : LANGUAGE; ?>" >-->
                            <select name="language" class="col-sm-3 form-control extra">
                                <option value="ar"<?php echo (isset($_POST['language']) && $_POST['language'] == "ar") ? "selected='selected'" : "selected='selected'"; ?>>Arabic</option>
                                <option value="af"<?php echo (isset($_POST['language']) && $_POST['language'] == "af") ? "selected='selected'" : ""; ?>>Afrikaans</option>
                                <option value="gu"<?php echo (isset($_POST['language']) && $_POST['language'] == "gu") ? "selected='selected'" : ""; ?>>Gujarati</option>
                                <option value="sq"<?php echo (isset($_POST['language']) && $_POST['language'] == "sq") ? "selected='selected'" : ""; ?>>Albanian</option>
                                <option value="hy"<?php echo (isset($_POST['language']) && $_POST['language'] == "hy") ? "selected='selected'" : ""; ?>>Armenian</option>
                                <option value="az"<?php echo (isset($_POST['language']) && $_POST['language'] == "az") ? "selected='selected'" : ""; ?>>Azerbaijani</option>
                                <option value="eu"<?php echo (isset($_POST['language']) && $_POST['language'] == "eu") ? "selected='selected'" : ""; ?>>Basque</option>
                                <option value="be"<?php echo (isset($_POST['language']) && $_POST['language'] == "be") ? "selected='selected'" : ""; ?>>Belarusian</option>
                                <option value="bn"<?php echo (isset($_POST['language']) && $_POST['language'] == "bn") ? "selected='selected'" : ""; ?>>Bengali</option>
                                <option value="bs"<?php echo (isset($_POST['language']) && $_POST['language'] == "bs") ? "selected='selected'" : ""; ?>>Bosnian</option>
                                <option value="bg"<?php echo (isset($_POST['language']) && $_POST['language'] == "bg") ? "selected='selected'" : ""; ?>>Bulgarian</option>
                                <option value="my"<?php echo (isset($_POST['language']) && $_POST['language'] == "my") ? "selected='selected'" : ""; ?>>Burmese</option>
                                <option value="ca"<?php echo (isset($_POST['language']) && $_POST['language'] == "ca") ? "selected='selected'" : ""; ?>>Catalan</option>
                                <option value="ceb"<?php echo (isset($_POST['language']) && $_POST['language'] == "ceb") ? "selected='selected'" : ""; ?>>Cebuano</option>
                                <option value="zh-CN"<?php echo (isset($_POST['language']) && $_POST['language'] == "zh-CN") ? "selected='selected'" : ""; ?>>Chinese (Simplified)</option>
                                <option value="zh-TW"<?php echo (isset($_POST['language']) && $_POST['language'] == "zh-TW") ? "selected='selected'" : ""; ?>>Chinese (Traditional)</option>
                                <option value="hr"<?php echo (isset($_POST['language']) && $_POST['language'] == "hr") ? "selected='selected'" : ""; ?>>Croatian</option>
                                <option value="cs"<?php echo (isset($_POST['language']) && $_POST['language'] == "cs") ? "selected='selected'" : ""; ?>>Czech</option>
                                <option value="da"<?php echo (isset($_POST['language']) && $_POST['language'] == "da") ? "selected='selected'" : ""; ?>>Danish</option>
                                <option value="nl"<?php echo (isset($_POST['language']) && $_POST['language'] == "nl") ? "selected='selected'" : ""; ?>>Dutch</option>
                                <option value="english"<?php echo (isset($_POST['language']) && $_POST['language'] == "english") ? "" : "selected='1'"; ?>>English</option>
                                <option value="eo"<?php echo (isset($_POST['language']) && $_POST['language'] == "eo") ? "selected='selected'" : ""; ?>>Esperanto</option>
                                <option value="et"<?php echo (isset($_POST['language']) && $_POST['language'] == "et") ? "selected='selected'" : ""; ?>>Estonian</option>
                                <option value="tl"<?php echo (isset($_POST['language']) && $_POST['language'] == "tl") ? "selected='selected'" : ""; ?>>Filipino</option>
                                <option value="fi"<?php echo (isset($_POST['language']) && $_POST['language'] == "fi") ? "selected='selected'" : ""; ?>>Finnish</option>
                                <option value="fr"<?php echo (isset($_POST['language']) && $_POST['language'] == "fr") ? "selected='selected'" : ""; ?>>French</option>
                                <option value="gl"<?php echo (isset($_POST['language']) && $_POST['language'] == "gl") ? "selected='selected'" : ""; ?>>Galician</option>
                                <option value="ka"<?php echo (isset($_POST['language']) && $_POST['language'] == "ka") ? "selected='selected'" : ""; ?>>Georgian</option>
                                <option value="de"<?php echo (isset($_POST['language']) && $_POST['language'] == "de") ? "selected='selected'" : ""; ?>>German</option>
                                <option value="el"<?php echo (isset($_POST['language']) && $_POST['language'] == "el") ? "selected='selected'" : ""; ?>>Greek</option>
                                <option value="gu"<?php echo (isset($_POST['language']) && $_POST['language'] == "gu") ? "selected='selected'" : ""; ?>>Gujarati</option>
                                <option value="ht"<?php echo (isset($_POST['language']) && $_POST['language'] == "ht") ? "selected='selected'" : ""; ?>>Haitian</option>
                                <option value="ha"<?php echo (isset($_POST['language']) && $_POST['language'] == "ha") ? "selected='selected'" : ""; ?>>Hausa</option>
                                <option value="iw"<?php echo (isset($_POST['language']) && $_POST['language'] == "iw") ? "selected='selected'" : ""; ?>>Hebrew</option>
                                <option value="hi"<?php echo (isset($_POST['language']) && $_POST['language'] == "hi") ? "selected='selected'" : ""; ?>>Hindi</option>
                                <option value="hmn"<?php echo (isset($_POST['language']) && $_POST['language'] == "hmn") ? "selected='selected'" : ""; ?>>Hmong</option>
                                <option value="hu"<?php echo (isset($_POST['language']) && $_POST['language'] == "hu") ? "selected='selected'" : ""; ?>>Hungarian</option>
                                <option value="is"<?php echo (isset($_POST['language']) && $_POST['language'] == "is") ? "selected='selected'" : ""; ?>>Icelandic</option>
                                <option value="ig"<?php echo (isset($_POST['language']) && $_POST['language'] == "ig") ? "selected='selected'" : ""; ?>>Igbo</option>
                                <option value="id"<?php echo (isset($_POST['language']) && $_POST['language'] == "id") ? "selected='selected'" : ""; ?>>Indonesian</option>
                                <option value="ga"<?php echo (isset($_POST['language']) && $_POST['language'] == "ga") ? "selected='selected'" : ""; ?>>Irish</option>
                                <option value="it"<?php echo (isset($_POST['language']) && $_POST['language'] == "it") ? "selected='selected'" : ""; ?>>Italian</option>
                                <option value="ja"<?php echo (isset($_POST['language']) && $_POST['language'] == "ja") ? "selected='selected'" : ""; ?>>Japanese</option>
                                <option value="jv"<?php echo (isset($_POST['language']) && $_POST['language'] == "jv") ? "selected='selected'" : ""; ?>>Javanese</option>
                                <option value="kn"<?php echo (isset($_POST['language']) && $_POST['language'] == "kn") ? "selected='selected'" : ""; ?>>Kannada</option>
                                <option value="kk"<?php echo (isset($_POST['language']) && $_POST['language'] == "kk") ? "selected='selected'" : ""; ?>>Kazakh</option>
                                <option value="km"<?php echo (isset($_POST['language']) && $_POST['language'] == "km") ? "selected='selected'" : ""; ?>>Khmer</option>
                                <option value="ko"<?php echo (isset($_POST['language']) && $_POST['language'] == "ko") ? "selected='selected'" : ""; ?>>Korean</option>
                                <option value="lo"<?php echo (isset($_POST['language']) && $_POST['language'] == "lo") ? "selected='selected'" : ""; ?>>Lao</option>
                                <option value="la"<?php echo (isset($_POST['language']) && $_POST['language'] == "la") ? "selected='selected'" : ""; ?>>Latin</option>
                                <option value="lv"<?php echo (isset($_POST['language']) && $_POST['language'] == "lv") ? "selected='selected'" : ""; ?>>Latvian</option>
                                <option value="lt"<?php echo (isset($_POST['language']) && $_POST['language'] == "lt") ? "selected='selected'" : ""; ?>>Lithuanian</option>
                                <option value="mk"<?php echo (isset($_POST['language']) && $_POST['language'] == "mk") ? "selected='selected'" : ""; ?>>Macedonian</option>
                                <option value="mg"<?php echo (isset($_POST['language']) && $_POST['language'] == "mg") ? "selected='selected'" : ""; ?>>Malagasy</option>
                                <option value="ms"<?php echo (isset($_POST['language']) && $_POST['language'] == "ms") ? "selected='selected'" : ""; ?>>Malay</option>
                                <option value="ml"<?php echo (isset($_POST['language']) && $_POST['language'] == "ml") ? "selected='selected'" : ""; ?>>Malayalam</option>
                                <option value="mt"<?php echo (isset($_POST['language']) && $_POST['language'] == "mt") ? "selected='selected'" : ""; ?>>Maltese</option>
                                <option value="mi"<?php echo (isset($_POST['language']) && $_POST['language'] == "mi") ? "selected='selected'" : ""; ?>>Maori</option>
                                <option value="mr"<?php echo (isset($_POST['language']) && $_POST['language'] == "mr") ? "selected='selected'" : ""; ?>>Marathi</option>
                                <option value="mn"<?php echo (isset($_POST['language']) && $_POST['language'] == "mn") ? "selected='selected'" : ""; ?>>Mongolian</option>
                                <option value="ne"<?php echo (isset($_POST['language']) && $_POST['language'] == "ne") ? "selected='selected'" : ""; ?>>Nepali</option>
                                <option value="no"<?php echo (isset($_POST['language']) && $_POST['language'] == "no") ? "selected='selected'" : ""; ?>>Norwegian</option>
                                <option value="ny"<?php echo (isset($_POST['language']) && $_POST['language'] == "ny") ? "selected='selected'" : ""; ?>>Nyanja</option>
                                <option value="fa"<?php echo (isset($_POST['language']) && $_POST['language'] == "fa") ? "selected='selected'" : ""; ?>>Persian</option>
                                <option value="pl"<?php echo (isset($_POST['language']) && $_POST['language'] == "pl") ? "selected='selected'" : ""; ?>>Polish</option>
                                <option value="pt"<?php echo (isset($_POST['language']) && $_POST['language'] == "pt") ? "selected='selected'" : ""; ?>>Portuguese</option>
                                <option value="pa"<?php echo (isset($_POST['language']) && $_POST['language'] == "pa") ? "selected='selected'" : ""; ?>>Punjabi</option>
                                <option value="ro"<?php echo (isset($_POST['language']) && $_POST['language'] == "ro") ? "selected='selected'" : ""; ?>>Romanian</option>
                                <option value="ru"<?php echo (isset($_POST['language']) && $_POST['language'] == "ru") ? "selected='selected'" : ""; ?>>Russian</option>
                                <option value="sr"<?php echo (isset($_POST['language']) && $_POST['language'] == "sr") ? "selected='selected'" : ""; ?>>Serbian</option>
                                <option value="si"<?php echo (isset($_POST['language']) && $_POST['language'] == "si") ? "selected='selected'" : ""; ?>>Sinhala</option>
                                <option value="sk"<?php echo (isset($_POST['language']) && $_POST['language'] == "sk") ? "selected='selected'" : ""; ?>>Slovak</option>
                                <option value="sl"<?php echo (isset($_POST['language']) && $_POST['language'] == "sl") ? "selected='selected'" : ""; ?>>Slovenian</option>
                                <option value="so"<?php echo (isset($_POST['language']) && $_POST['language'] == "so") ? "selected='selected'" : ""; ?>>Somali</option>
                                <option value="es"<?php echo (isset($_POST['language']) && $_POST['language'] == "es") ? "selected='selected'" : ""; ?>>Spanish</option>
                                <option value="su"<?php echo (isset($_POST['language']) && $_POST['language'] == "su") ? "selected='selected'" : ""; ?>>Sundanese</option>
                                <option value="sw"<?php echo (isset($_POST['language']) && $_POST['language'] == "sw") ? "selected='selected'" : ""; ?>>Swahili</option>
                                <option value="sv"<?php echo (isset($_POST['language']) && $_POST['language'] == "sv") ? "selected='selected'" : ""; ?>>Swedish</option>
                                <option value="tg"<?php echo (isset($_POST['language']) && $_POST['language'] == "tg") ? "selected='selected'" : ""; ?>>Tajik</option>
                                <option value="ta"<?php echo (isset($_POST['language']) && $_POST['language'] == "ta") ? "selected='selected'" : ""; ?>>Tamil</option>
                                <option value="te"<?php echo (isset($_POST['language']) && $_POST['language'] == "te") ? "selected='selected'" : ""; ?>>Telugu</option>
                                <option value="th"<?php echo (isset($_POST['language']) && $_POST['language'] == "th") ? "selected='selected'" : ""; ?>>Thai</option>
                                <option value="tr"<?php echo (isset($_POST['language']) && $_POST['language'] == "tr") ? "selected='selected'" : ""; ?>>Turkish</option>
                                <option value="uk"<?php echo (isset($_POST['language']) && $_POST['language'] == "uk") ? "selected='selected'" : ""; ?>>Ukrainian</option>
                                <option value="ur"<?php echo (isset($_POST['language']) && $_POST['language'] == "ur") ? "selected='selected'" : ""; ?>>Urdu</option>
                                <option value="uz"<?php echo (isset($_POST['language']) && $_POST['language'] == "uz") ? "selected='selected'" : ""; ?>>Uzbek</option>
                                <option value="vi"<?php echo (isset($_POST['language']) && $_POST['language'] == "vi") ? "selected='selected'" : ""; ?>>Vietnamese</option>
                                <option value="cy"<?php echo (isset($_POST['language']) && $_POST['language'] == "cy") ? "selected='selected'" : ""; ?>>Welsh</option>
                                <option value="yi"<?php echo (isset($_POST['language']) && $_POST['language'] == "yi") ? "selected='selected'" : ""; ?>>Yiddish</option>
                                <option value="yo"<?php echo (isset($_POST['language']) && $_POST['language'] == "yo") ? "selected='selected'" : ""; ?>>Yoruba</option>
                                <option value="zu"<?php echo (isset($_POST['language']) && $_POST['language'] == "zu") ? "selected='selected'" : ""; ?>>Zulu</option>
                                </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="checkbox" name="external_source" id="external_source" value="<?php echo isset($bExternalSource) ? $bExternalSource: EXTERNAL_TEXT; ?>" <?php echo ((isset($bExternalSource) && ($bExternalSource == 1)) || (EXTERNAL_TEXT == '1')) ? "checked='checked'" : ""; ?>onClick="changeValue('external_source');">  
                            <label class="start_payload">Use External Storage?</label>
                        </div>
                    </div>
                    <div id="folder_location_address" style="<?php echo ((isset($bExternalSource) && ($bExternalSource == 1)) || (EXTERNAL_TEXT == '1')) ? "display:block;" : "display:none;"; ?>">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Folder Location:<font style="color:red">*</font></label>
                            <div class="col-sm-12">
                                <input type="text" name="folder_location" class="form-control" value="<?php echo isset($_POST['folder_location']) ? $_POST['folder_location'] : EXTERNAL_PATH ; ?>" ></label>
                                <div class="error-message">
                                    <?php echo isset($_SESSION['isValidation']['folder_location_required']) ? $_SESSION['isValidation']['folder_location_required'] : '';?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($bShowDebugText) ? $bShowDebugText : DEBUG_TEXT; ?>" <?php echo ((isset($bShowDebugText) && $bShowDebugText == 1) || (DEBUG_TEXT == '1')) ? "checked='checked'" : ""; ?> onClick="changeValue('show_debug');">
                            <label class="start_payload">Show debug text?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="checkbox" name="admin_cog" id="admin_cog" value="<?php echo isset($bAdminCog) ? $bAdminCog : ADMIN_COG; ?>" <?php echo ((isset($bAdminCog) && $bAdminCog == 1) || (ADMIN_COG == '1')) ? "checked='checked'" : ""; ?> onClick="changeValue('admin_cog');">
                            <label class="start_payload">Show admin cog?</label>
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