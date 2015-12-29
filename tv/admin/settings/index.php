<!doctype html>
<html>
    <head>
       <meta charset="utf-8">
        <?php
            if(file_exists('../../../.general.txt'))
            {
                $myfile = fopen('../../../.general.txt', "r") or die("Unable to open file!");
                $suuid = fread($myfile,filesize('../../../.general.txt'));
                $constant = explode(';',$suuid);
                $constantpath = $constant[1];
                
            }
            require_once("../../../data/$constantpath/constants.php");
            require(ROOT_DIR.'/tv/admin/buttons/checkLogin.php');
            error_reporting(0);
            $sSiteUrl = SITE_URL;
            if(file_exists(ROOT_DIR.'/IP.txt'))
            {
                $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
                $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
                $sSiteUrl = trim($protocol);
            }
        ?>
       <link href="<?php echo $sSiteUrl; ?>/tv/css/bootstrap.min.css" rel="stylesheet">
       <link href="<?php echo $sSiteUrl; ?>/tv/admin/buttons/buttons.css" rel="stylesheet">
       <link href="<?php echo $sSiteUrl; ?>/tv/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
       <script src="<?php echo $sSiteUrl; ?>/tv/js/jquery.js" type="text/javascript"></script>
    </head>
    <body>
    <?php
        $_SESSION['isValidation']['flag'] = TRUE;
        if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_SESSION['isValidation']))
        {
            $sLanguage = isset($_POST['language']) ? $_POST['language'] : 0;
            $bShowDebugText = isset($_POST['show_debug']) ? $_POST['show_debug'] : 0;
            $bShowLabel = isset($_POST['show_label']) ? $_POST['show_label'] : 0;
            $sFolderLocation = isset($_POST['folder_location'])? $_POST['folder_location'] : '';
            $sTvplayerLocation = isset($_POST['tvplayer_location'])? $_POST['tvplayer_location'] : '';
            $bExternalSource = isset($_POST['external_source'])? $_POST['external_source'] : 0;
            $bPayloadInstall = isset($_POST['show_payload'])? $_POST['show_payload'] : 0;
            $bTvUpdate = isset($_POST['show_tv_update']) ? $_POST['show_tv_update'] : 0;
            $bAdminCog = isset($_POST['admin_cog']) ? $_POST['admin_cog'] : 0;
            $sTvBranchName = isset($_POST['tv_branch']) ? trim($_POST['tv_branch']) : '';
            $sGetInfectedBranch = isset($_POST['getinfected_branch']) ? trim($_POST['getinfected_branch']) : '';
            
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
                $sSiteUrl = (isset($_SERVER["HTTP_HOST"]) ? "http://".$_SERVER["HTTP_HOST"] : '');
                $sDestination = ROOT_DIR.'/data/'.$constantpath.'/constants.php';
                if(file_exists(ROOT_DIR.'/IP.txt'))
                {
                    $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
                    $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
                    $sSiteUrl = trim($protocol);
                }
                if(file_exists($sDestination))
                {
                    $sDocumentRoot = ROOT_DIR;
                    $sSiteUrl = SITE_URL;
                    $sInfectionResource = INFECTED_RESOURCE;
                    $sDeviceAddress = DEVICE_ADDRESS;
                    $nPort = PORT_NUMBER;
                    $bChmod = CHMOD;
                }
                $sListContent = "<?php
define('ROOT_DIR','$sDocumentRoot');
define('SITE_URL','$sSiteUrl');
define('EXTERNAL_FOLDER','$sFolderLocation');
define('EXTERNAL_PATH','$sDocumentRoot/$sFolderLocation');
define('LANGUAGE','$sLanguage');
define('DEBUG_TEXT','$bShowDebugText');
define('PAYLOAD_LABEL','$bShowLabel');
define('EXTERNAL_TEXT','$bExternalSource');
define('PAYLOAD_INSTALL','$bPayloadInstall');
define('CHMOD','$bChmod');
define('TV_BRANCH','$sTvBranchName');
define('ADMIN_COG','$bAdminCog');
define('SHOW_TV','$bTvUpdate');
define('INFECTED_RESOURCE','$sInfectionResource');
define('DEVICE_ADDRESS','$sDeviceAddress');
define('PORT_NUMBER','$nPort');
define('TVPLAYER_LOCATION','$sTvplayerLocation');
define('GETINFECTED_BRANCH','$sGetInfectedBranch');";
                $myfile = fopen("$sDestination", "w");
                fwrite($myfile, $sListContent);
                fclose($myfile);
                echo '<h2>Settings Saved Successfully!!</h2>'
                    . '<div class="admin_img"><a href="'.$sSiteUrl.'/tv/admin/buttons" class="btn btn-lg btn-primary color-white">Admin</a></div>'
                    . '<div class="play_img"><a href="'.$sSiteUrl.'/tv/play/teacherbot" class="btn btn-lg btn-primary color-white">Play</a></div>';
                die();
            }
        }
        if($_SESSION['isValidation']['flag'] == 1)
            unset($_SESSION['isValidation']['folder_location_required']);
     
            unset($_SESSION['isValidation']['tvplayer_location_required']);

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

                    if(eValue == "external_source" && isChecked.checked)
                    {
                        $("#folder_location_address").show();
                    }
                    else if(eValue == "external_source")
                    {
                        $("#folder_location_address").hide();
                    }
                    else if(eValue == "show_tv_update" && isChecked.checked)
                    {
                        $("#default_branches").show();
                    }
                    else if(eValue == "show_tv_update")
                    {
                        $("#default_branches").hide();
                    }
                    else if(eValue == "chmod" && isChecked.checked)
                    {
                        $("#chmod_enable").show();
                    }
                    else if(eValue == "chmod")
                    {
                        $("#chmod_enable").hide();
                    }
                }
                
                function toggleShowFile(id,buttonid)
                {
                     var divId = document.getElementById(id);
                     var buttonId = document.getElementById(buttonid);
                     if (divId.style.display == 'block' || divId.style.display=='')
                    {
                        buttonId.value = 'Show Breeder and Mutator Settings ';
                        divId.style.display = 'none';
                    }
                    else 
                    {
                        buttonId.value = 'Hide Breeder and Mutator Settings';
                        divId.style.display = 'block';
                   }
                }
                
            </script>
            <div class="color-white">
                <a class="play_img" href="<?php echo $sSiteUrl.'/tv/admin/buttons'; ?>">
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
                                <option value="ar"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ar") || (LANGUAGE == "ar")) ? "selected='selected'" : ""; ?>>Arabic</option>
                                <option value="af"<?php echo ((isset($_POST['language']) && $_POST['language'] == "af") || (LANGUAGE == "af")) ? "selected='selected'" : ""; ?>>Afrikaans</option>
                                <option value="sq"<?php echo ((isset($_POST['language']) && $_POST['language'] == "sq") || (LANGUAGE == "sq")) ? "selected='selected'" : ""; ?>>Albanian</option>
                                <option value="hy"<?php echo ((isset($_POST['language']) && $_POST['language'] == "hy") || (LANGUAGE == "hy")) ? "selected='selected'" : ""; ?>>Armenian</option>
                                <option value="az"<?php echo ((isset($_POST['language']) && $_POST['language'] == "az") || (LANGUAGE == "az")) ? "selected='selected'" : ""; ?>>Azerbaijani</option>
                                <option value="eu"<?php echo ((isset($_POST['language']) && $_POST['language'] == "eu") || (LANGUAGE == "eu")) ? "selected='selected'" : ""; ?>>Basque</option>
                                <option value="be"<?php echo ((isset($_POST['language']) && $_POST['language'] == "be") || (LANGUAGE == "be")) ? "selected='selected'" : ""; ?>>Belarusian</option>
                                <option value="bn"<?php echo ((isset($_POST['language']) && $_POST['language'] == "bn") || (LANGUAGE == "bn")) ? "selected='selected'" : ""; ?>>Bengali</option>
                                <option value="bs"<?php echo ((isset($_POST['language']) && $_POST['language'] == "bs") || (LANGUAGE == "bs")) ? "selected='selected'" : ""; ?>>Bosnian</option>
                                <option value="bg"<?php echo ((isset($_POST['language']) && $_POST['language'] == "bg") || (LANGUAGE == "bg")) ? "selected='selected'" : ""; ?>>Bulgarian</option>
                                <option value="my"<?php echo ((isset($_POST['language']) && $_POST['language'] == "my") || (LANGUAGE == "my")) ? "selected='selected'" : ""; ?>>Burmese</option>
                                <option value="ca"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ca") || (LANGUAGE == "ca")) ? "selected='selected'" : ""; ?>>Catalan</option>
                                <option value="ceb"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ceb") || (LANGUAGE == "ceb")) ? "selected='selected'" : ""; ?>>Cebuano</option>
                                <option value="zh-CN"<?php echo ((isset($_POST['language']) && $_POST['language'] == "zh-CN") || (LANGUAGE == "zh-CN")) ? "selected='selected'" : ""; ?>>Chinese (Simplified)</option>
                                <option value="zh-TW"<?php echo ((isset($_POST['language']) && $_POST['language'] == "zh-TW") || (LANGUAGE == "zh-TW")) ? "selected='selected'" : ""; ?>>Chinese (Traditional)</option>
                                <option value="hr"<?php echo ((isset($_POST['language']) && $_POST['language'] == "hr") || (LANGUAGE == "hr")) ? "selected='selected'" : ""; ?>>Croatian</option>
                                <option value="cs"<?php echo ((isset($_POST['language']) && $_POST['language'] == "cs") || (LANGUAGE == "cs")) ? "selected='selected'" : ""; ?>>Czech</option>
                                <option value="da"<?php echo ((isset($_POST['language']) && $_POST['language'] == "da") || (LANGUAGE == "da")) ? "selected='selected'" : ""; ?>>Danish</option>
                                <option value="nl"<?php echo ((isset($_POST['language']) && $_POST['language'] == "nl")|| (LANGUAGE == "nl")) ? "selected='selected'" : ""; ?>>Dutch</option>
                                <option value="en"<?php echo (((isset($_POST['language']) && $_POST['language'] == "en")) ? "selected='selected'" : ((!isset($_POST['language']) && (LANGUAGE == "en")) ? "selected='selected'" : "")); ?>>English</option>
                                <option value="eo"<?php echo ((isset($_POST['language']) && $_POST['language'] == "eo") || (LANGUAGE == "eo")) ? "selected='selected'" : ""; ?>>Esperanto</option>
                                <option value="et"<?php echo ((isset($_POST['language']) && $_POST['language'] == "et") || (LANGUAGE == "et")) ? "selected='selected'" : ""; ?>>Estonian</option>
                                <option value="tl"<?php echo ((isset($_POST['language']) && $_POST['language'] == "tl") || (LANGUAGE == "tl")) ? "selected='selected'" : ""; ?>>Filipino</option>
                                <option value="fi"<?php echo ((isset($_POST['language']) && $_POST['language'] == "fi") || (LANGUAGE == "fi")) ? "selected='selected'" : ""; ?>>Finnish</option>
                                <option value="fr"<?php echo ((isset($_POST['language']) && $_POST['language'] == "fr") || (LANGUAGE == "fr")) ? "selected='selected'" : ""; ?>>French</option>
                                <option value="gl"<?php echo ((isset($_POST['language']) && $_POST['language'] == "gl") || (LANGUAGE == "gl")) ? "selected='selected'" : ""; ?>>Galician</option>
                                <option value="ka"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ka") || (LANGUAGE == "ka")) ? "selected='selected'" : ""; ?>>Georgian</option>
                                <option value="de"<?php echo ((isset($_POST['language']) && $_POST['language'] == "de") || (LANGUAGE == "de")) ? "selected='selected'" : ""; ?>>German</option>
                                <option value="el"<?php echo ((isset($_POST['language']) && $_POST['language'] == "el") || (LANGUAGE == "el")) ? "selected='selected'" : ""; ?>>Greek</option>
                                <option value="gu"<?php echo ((isset($_POST['language']) && $_POST['language'] == "gu") || (LANGUAGE == "gu")) ? "selected='selected'" : ""; ?>>Gujarati</option>
                                <option value="ht"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ht") || (LANGUAGE == "ht")) ? "selected='selected'" : ""; ?>>Haitian</option>
                                <option value="ha"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ha") || (LANGUAGE == "ha")) ? "selected='selected'" : ""; ?>>Hausa</option>
                                <option value="iw"<?php echo ((isset($_POST['language']) && $_POST['language'] == "iw") || (LANGUAGE == "iw")) ? "selected='selected'" : ""; ?>>Hebrew</option>
                                <option value="hi"<?php echo ((isset($_POST['language']) && $_POST['language'] == "hi") || (LANGUAGE == "hi")) ? "selected='selected'" : ""; ?>>Hindi</option>
                                <option value="hmn"<?php echo ((isset($_POST['language']) && $_POST['language'] == "hmn") || (LANGUAGE == "hmn")) ? "selected='selected'" : ""; ?>>Hmong</option>
                                <option value="hu"<?php echo ((isset($_POST['language']) && $_POST['language'] == "hu") || (LANGUAGE == "hu")) ? "selected='selected'" : ""; ?>>Hungarian</option>
                                <option value="is"<?php echo ((isset($_POST['language']) && $_POST['language'] == "is") || (LANGUAGE == "is")) ? "selected='selected'" : ""; ?>>Icelandic</option>
                                <option value="ig"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ig") || (LANGUAGE == "ig")) ? "selected='selected'" : ""; ?>>Igbo</option>
                                <option value="id"<?php echo ((isset($_POST['language']) && $_POST['language'] == "id") || (LANGUAGE == "id")) ? "selected='selected'" : ""; ?>>Indonesian</option>
                                <option value="ga"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ga") || (LANGUAGE == "ga")) ? "selected='selected'" : ""; ?>>Irish</option>
                                <option value="it"<?php echo ((isset($_POST['language']) && $_POST['language'] == "it") || (LANGUAGE == "it")) ? "selected='selected'" : ""; ?>>Italian</option>
                                <option value="ja"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ja") || (LANGUAGE == "ja")) ? "selected='selected'" : ""; ?>>Japanese</option>
                                <option value="jv"<?php echo ((isset($_POST['language']) && $_POST['language'] == "jv") || (LANGUAGE == "jv")) ? "selected='selected'" : ""; ?>>Javanese</option>
                                <option value="kn"<?php echo ((isset($_POST['language']) && $_POST['language'] == "kn") || (LANGUAGE == "kn")) ? "selected='selected'" : ""; ?>>Kannada</option>
                                <option value="kk"<?php echo ((isset($_POST['language']) && $_POST['language'] == "kk") || (LANGUAGE == "kk")) ? "selected='selected'" : ""; ?>>Kazakh</option>
                                <option value="km"<?php echo ((isset($_POST['language']) && $_POST['language'] == "km") || (LANGUAGE == "km")) ? "selected='selected'" : ""; ?>>Khmer</option>
                                <option value="ko"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ko") || (LANGUAGE == "ko")) ? "selected='selected'" : ""; ?>>Korean</option>
                                <option value="lo"<?php echo ((isset($_POST['language']) && $_POST['language'] == "lo") || (LANGUAGE == "lo")) ? "selected='selected'" : ""; ?>>Lao</option>
                                <option value="la"<?php echo ((isset($_POST['language']) && $_POST['language'] == "la") || (LANGUAGE == "la")) ? "selected='selected'" : ""; ?>>Latin</option>
                                <option value="lv"<?php echo ((isset($_POST['language']) && $_POST['language'] == "lv") || (LANGUAGE == "lv")) ? "selected='selected'" : ""; ?>>Latvian</option>
                                <option value="lt"<?php echo ((isset($_POST['language']) && $_POST['language'] == "lt") || (LANGUAGE == "lt")) ? "selected='selected'" : ""; ?>>Lithuanian</option>
                                <option value="mk"<?php echo ((isset($_POST['language']) && $_POST['language'] == "mk") || (LANGUAGE == "mk")) ? "selected='selected'" : ""; ?>>Macedonian</option>
                                <option value="mg"<?php echo ((isset($_POST['language']) && $_POST['language'] == "mg") || (LANGUAGE == "mg")) ? "selected='selected'" : ""; ?>>Malagasy</option>
                                <option value="ms"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ms") || (LANGUAGE == "ms")) ? "selected='selected'" : ""; ?>>Malay</option>
                                <option value="ml"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ml") || (LANGUAGE == "ml")) ? "selected='selected'" : ""; ?>>Malayalam</option>
                                <option value="mt"<?php echo ((isset($_POST['language']) && $_POST['language'] == "mt") || (LANGUAGE == "mt")) ? "selected='selected'" : ""; ?>>Maltese</option>
                                <option value="mi"<?php echo ((isset($_POST['language']) && $_POST['language'] == "mi") || (LANGUAGE == "mi")) ? "selected='selected'" : ""; ?>>Maori</option>
                                <option value="mr"<?php echo ((isset($_POST['language']) && $_POST['language'] == "mr") || (LANGUAGE == "mr")) ? "selected='selected'" : ""; ?>>Marathi</option>
                                <option value="mn"<?php echo ((isset($_POST['language']) && $_POST['language'] == "mn") || (LANGUAGE == "mn")) ? "selected='selected'" : ""; ?>>Mongolian</option>
                                <option value="ne"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ne") || (LANGUAGE == "ne")) ? "selected='selected'" : ""; ?>>Nepali</option>
                                <option value="no"<?php echo ((isset($_POST['language']) && $_POST['language'] == "no") || (LANGUAGE == "no")) ? "selected='selected'" : ""; ?>>Norwegian</option>
                                <option value="ny"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ny") || (LANGUAGE == "ny")) ? "selected='selected'" : ""; ?>>Nyanja</option>
                                <option value="fa"<?php echo ((isset($_POST['language']) && $_POST['language'] == "pl") || (LANGUAGE == "pl")) ? "selected='selected'" : ""; ?>>Polish</option>
                                <option value="pt"<?php echo ((isset($_POST['language']) && $_POST['language'] == "pt") || (LANGUAGE == "pt")) ? "selected='selected'" : ""; ?>>Portuguese</option>
                                <option value="pa"<?php echo ((isset($_POST['language']) && $_POST['language'] == "pa") || (LANGUAGE == "pa")) ? "selected='selected'" : ""; ?>>Punjabi</option>
                                <option value="ro"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ro") || (LANGUAGE == "ro")) ? "selected='selected'" : ""; ?>>Romanian</option>
                                <option value="ru"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ru") || (LANGUAGE == "ru")) ? "selected='selected'" : ""; ?>>Russian</option>
                                <option value="sr"<?php echo ((isset($_POST['language']) && $_POST['language'] == "sr") || (LANGUAGE == "sr")) ? "selected='selected'" : ""; ?>>Serbian</option>
                                <option value="si"<?php echo ((isset($_POST['language']) && $_POST['language'] == "si") || (LANGUAGE == "si")) ? "selected='selected'" : ""; ?>>Sinhala</option>
                                <option value="sk"<?php echo ((isset($_POST['language']) && $_POST['language'] == "sk") || (LANGUAGE == "sk")) ? "selected='selected'" : ""; ?>>Slovak</option>
                                <option value="sl"<?php echo ((isset($_POST['language']) && $_POST['language'] == "sl") || (LANGUAGE == "sl")) ? "selected='selected'" : ""; ?>>Slovenian</option>
                                <option value="so"<?php echo ((isset($_POST['language']) && $_POST['language'] == "so") || (LANGUAGE == "so")) ? "selected='selected'" : ""; ?>>Somali</option>
                                <option value="es"<?php echo ((isset($_POST['language']) && $_POST['language'] == "es") || (LANGUAGE == "es")) ? "selected='selected'" : ""; ?>>Spanish</option>
                                <option value="su"<?php echo ((isset($_POST['language']) && $_POST['language'] == "su") || (LANGUAGE == "su")) ? "selected='selected'" : ""; ?>>Sundanese</option>
                                <option value="sw"<?php echo ((isset($_POST['language']) && $_POST['language'] == "sw") || (LANGUAGE == "sw")) ? "selected='selected'" : ""; ?>>Swahili</option>
                                <option value="sv"<?php echo ((isset($_POST['language']) && $_POST['language'] == "sv") || (LANGUAGE == "sv")) ? "selected='selected'" : ""; ?>>Swedish</option>
                                <option value="tg"<?php echo ((isset($_POST['language']) && $_POST['language'] == "tg") || (LANGUAGE == "tg")) ? "selected='selected'" : ""; ?>>Tajik</option>
                                <option value="ta"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ta") || (LANGUAGE == "ta")) ? "selected='selected'" : ""; ?>>Tamil</option>
                                <option value="te"<?php echo ((isset($_POST['language']) && $_POST['language'] == "te") || (LANGUAGE == "te")) ? "selected='selected'" : ""; ?>>Telugu</option>
                                <option value="th"<?php echo ((isset($_POST['language']) && $_POST['language'] == "th") || (LANGUAGE == "th")) ? "selected='selected'" : ""; ?>>Thai</option>
                                <option value="tr"<?php echo ((isset($_POST['language']) && $_POST['language'] == "tr") || (LANGUAGE == "tr")) ? "selected='selected'" : ""; ?>>Turkish</option>
                                <option value="uk"<?php echo ((isset($_POST['language']) && $_POST['language'] == "uk") || (LANGUAGE == "uk")) ? "selected='selected'" : ""; ?>>Ukrainian</option>
                                <option value="ur"<?php echo ((isset($_POST['language']) && $_POST['language'] == "ur") || (LANGUAGE == "ur")) ? "selected='selected'" : ""; ?>>Urdu</option>
                                <option value="uz"<?php echo ((isset($_POST['language']) && $_POST['language'] == "uz") || (LANGUAGE == "uz")) ? "selected='selected'" : ""; ?>>Uzbek</option>
                                <option value="vi"<?php echo ((isset($_POST['language']) && $_POST['language'] == "vi") || (LANGUAGE == "vi")) ? "selected='selected'" : ""; ?>>Vietnamese</option>
                                <option value="cy"<?php echo ((isset($_POST['language']) && $_POST['language'] == "cy") || (LANGUAGE == "cy")) ? "selected='selected'" : ""; ?>>Welsh</option>
                                <option value="yi"<?php echo ((isset($_POST['language']) && $_POST['language'] == "yi") || (LANGUAGE == "yi")) ? "selected='selected'" : ""; ?>>Yiddish</option>
                                <option value="yo"<?php echo ((isset($_POST['language']) && $_POST['language'] == "yo") || (LANGUAGE == "yo")) ? "selected='selected'" : ""; ?>>Yoruba</option>
                                <option value="zu"<?php echo ((isset($_POST['language']) && $_POST['language'] == "zu") || (LANGUAGE == "zu")) ? "selected='selected'" : ""; ?>>Zulu</option>
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
                            <label class="col-sm-12 control-label">Folder Location<font style="color:red">*</font></label>
                            <label class="col-sm-4 control-label"><?php echo ROOT_DIR.'/';?></label>
                            <div class="col-sm-8 folder_text">
                                <input type="text" name="folder_location" class="form-control" value="<?php echo isset($_POST['folder_location']) ? $_POST['folder_location'] : EXTERNAL_FOLDER ; ?>" ></label>
                                <div class="error-message">
                                    <?php echo isset($_SESSION['isValidation']['folder_location_required']) ? $_SESSION['isValidation']['folder_location_required'] : '';?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="checkbox" name="admin_cog" id="admin_cog" value="<?php echo isset($bAdminCog) ? $bAdminCog : ADMIN_COG; ?>" <?php echo ((isset($bAdminCog) && $bAdminCog == 1) || (ADMIN_COG == '1')) ? "checked='checked'" : ""; ?> onClick="changeValue('admin_cog');">
                            <label class="start_payload">Show admin cog to student?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="checkbox" name="show_label" id="show_label" value="<?php echo isset($bShowLabel) ? $bShowLabel : PAYLOAD_LABEL; ?>" <?php echo ((isset($bShowLabel) && $bShowLabel == 1) || (PAYLOAD_LABEL == '1')) ? "checked='checked'" : ""; ?> onClick="changeValue('show_label');">
                            <label class="start_payload">Show labels on payloads?</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Tv Player Location</label>
                        <label class="col-sm-5 control-label"><?php echo ROOT_DIR.DIRECTORY_SEPARATOR.'content'.DIRECTORY_SEPARATOR;?></label>
                        <div class="col-sm-7 folder_text">
                            <input type="text" name="tvplayer_location" class="form-control" value="<?php echo isset($_POST['tvplayer_location']) ? $_POST['tvplayer_location'] : TVPLAYER_LOCATION ; ?>" ></label>
                        </div>
                    </div><br/>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <div class="col-sm-5 button-setting">
                                <input type="button" id="show_branch_option" class="form-control" value="Show Breeder and Mutator Settings" onclick="toggleShowFile('branch_option','show_branch_option');">
                            </div>
                        </div>
                    </div> 
                <div id="branch_option" style="display:none">
                        <div class="form-group tv-left">
                            <div class="col-sm-12">
                                <input type="checkbox" name="show_tv_update" id="show_tv_update" value="<?php echo isset($bTvUpdate) ? $bTvUpdate : SHOW_TV; ?>" <?php echo ((isset($bTvUpdate) && ($bTvUpdate == 1)) || (SHOW_TV == '1')) ? "checked='checked'" : "";?> onclick="changeValue('show_tv_update')" >
                                <label class="start_payload"> Show Branch option for TV updates</label>
                            </div>
                        </div>
                        
                    <div id="default_branches" <?php if(SHOW_TV == 1) { echo 'style="display:block"';} else { echo 'style="display:none"';}?>>
                        <div class="form-group teacherbranch tv-leftinner">
                            <div class="col-sm-4">
                                <label class="start_payload2">Default Teacher Virus Branch</label>
                            </div>
                            <div class="col-sm-8 teacherbranch">
                                <input type="text" name="tv_branch" class="form-control" value="<?php echo isset($_POST['tv_branch']) ? $_POST['tv_branch'] : TV_BRANCH ; ?>" >
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="col-sm-12 teacherbranch tv-leftinner">
                            <div class="form-group">
                                <div class="col-sm-4">
                                    <label>Default getinfected.php Branch</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="getinfected_branch" class="form-control" value="<?php echo isset($_POST['getinfected_branch']) ? $_POST['getinfected_branch'] : GETINFECTED_BRANCH ; ?>" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group tv-left">
                        <div class="col-sm-12">
                            <input type="checkbox" name="show_payload" id="show_payload" value="<?php echo isset($bPayloadInstall) ? $bPayloadInstall : PAYLOAD_INSTALL; ?>" <?php echo ((isset($bPayloadInstall) && ($bPayloadInstall == 1)) || (PAYLOAD_INSTALL == '1')) ? "checked='checked'" : ""; ?>onClick="changeValue('show_payload');">
                            <label class="start_payload"> Show Branch Option For Payload Install</label>
                        </div>
                    </div>
                    <div class="form-group tv-left">
                        <div class="col-sm-12">
                            <input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($bShowDebugText) ? $bShowDebugText : DEBUG_TEXT; ?>" <?php echo ((isset($bShowDebugText) && $bShowDebugText == 1) || (DEBUG_TEXT == '1')) ? "checked='checked'" : ""; ?> onClick="changeValue('show_debug');">
                            <label class="start_payload">Show Debug Comments</label>
                        </div>
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