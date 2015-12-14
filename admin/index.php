<?php
    if(file_exists('../.general.txt'))
    {
        $myfile = fopen('../.general.txt', "r") or die("Unable to open file!");
        $suuid = fread($myfile,filesize('../.general.txt'));
        $constant = explode(';',$suuid);
        $constantpath = $constant[1];
    }
    require_once("../data/$constantpath/constants.php");
    error_reporting(0);
    $sSiteUrl = SITE_URL;
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $sSiteUrl = trim($protocol);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Icons Menu</title>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <link href="<?php echo $sSiteUrl; ?>/admin/buttons.css" rel="stylesheet">
        <link href="<?php echo $sSiteUrl; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo $sSiteUrl; ?>/admin/changePassword/_style/changePassword.css"/>
        <script src="<?php echo $sSiteUrl; ?>/admin/changePassword/js/jquery-1.11.1.js"></script>
        <script src='<?php echo $sSiteUrl; ?>/js/jquery.imagefit.js'></script>
        <script src="<?php echo $sSiteUrl; ?>/admin/buttons.js"></script>
        <script src="<?php echo $sSiteUrl; ?>/admin/changePassword/_script/changePassword.js"></script>
        <script>$(document).ready(function() { setup(); }); </script>
    </head>
    <body class="main" >
        <?php
            if (@session_id() == "") @session_start();

            $_SESSION['password_generated'] = false;
            $nConfirmPasswordFlag = 0;
            if (file_exists(ROOT_DIR."/data/$constantpath/admin/username_password.php")) 
            {
                require(ROOT_DIR."/data/$constantpath/admin/username_password.php");
                //Checking for request method.
                if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['pattern_password']))
                {
                    if(USER_NAME == $sUserName && PASSWORD == md5($_POST['pattern_password']))
                    {
                        $_SESSION['isLoggedIn'] = true;
                        $_SESSION['pattern_password'] =  md5($_POST['pattern_password']);
                    }
                    else
                    {
                        $_SESSION['isLoggedIn'] = false;
                        $_SESSION['invalid_pattern'] = "Invalid pattern found please try again!!";
                    }
                }

                if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == "1")
                {
                    $rootdir = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) )."*";

                    $playURL = $sSiteUrl.'/play';
                    $sChangePasswordURL =  $sSiteUrl.'/admin/changePassword';//str_replace('admin', 'admin/changePassword', $thisURL);
                    $sInfectedURL =  $sSiteUrl.'/admin/getinfected';//str_replace('admin', 'admin/getinfected', $thisURL);
                    $sSettingURL =  $sSiteUrl.'/admin/settings';//str_replace('admin', 'admin/settings', $thisURL);
                    $sOatseaTeachervirusURL =  $sSiteUrl.'/admin/OATSEA-teachervirus.org';
                    $sInfectURL =  $sSiteUrl.'/admin/infect';
                    
                    require(ROOT_DIR.'/admin/header.php');
                    
                    foreach(glob($rootdir, GLOB_ONLYDIR) as $dir)
                    { 
                        $dir = basename($dir); 
                        $imgText = $dir."/icon.png";
                        $imgTest = file_exists( $imgText);
                        if ($imgTest)
                        {
                            echo '<a href="'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$imgText.'" /></a>';
                        }
                        else
                        {
                            // Icon provided so use the default
                            echo '<a href="'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="default.png" /></a>';
                        }
                    }
                    (isset($sChangePasswordURL) && !empty($sChangePasswordURL)) ? '<a href="'.$sChangePasswordURL.'"><img class="mybutton" alt="Change Password" src="'.$sChangePasswordURL.'icon.png" /></a>' : '';
                    (isset($sInfectedURL) && !empty($sInfectedURL)) ? '<a href="'.$sInfectedURL.'"><img class="mybutton" alt="Get Infected" src="'.$sInfectedURL.'icon.png" /></a>' : '';
                    (isset($sSettingURL) && !empty($sSettingURL)) ? '<a href="'.$sSettingURL.'"><img class="mybutton" alt="Settings" src="'.$sSettingURL.'icon.png" /></a>' : '';
                    (isset($sOatseaTeachervirusURL) && !empty($sOatseaTeachervirusURL)) ? '<a href="'.$sOatseaTeachervirusURL.'"><img class="mybutton" alt="Settings" src="'.$sOatseaTeachervirusURL.'icon.png" /></a>' : '';
                    (isset($sInfectURL) && !empty($sInfectURL)) ? '<a href="'.$sInfectURL.'"><img class="mybutton" alt="Settings" src="'.$sInfectURL.'icon.png" /></a>' : '';
                }
                else
                {
            ?>
                    <script>
                        function submitform(){
                           return true;
                        }
                    </script>

                    <div class="color-white">
                        <a class="play_img" href="<?php echo $sSiteUrl.'/play'; ?>">
                            <i class="mainNav fa fa-play-circle-o fa-3x"></i>
                        </a>
                        <h2>Please Login</h2>
                    </div>
                    <form method="post" onsubmit="return submitform()" id="patternForm">
                        <div>
                            <input id="pattern_name" name="pattern_username" placeholder="username" type="hidden" value="admin">
                            <input type="password" id="pattern_password" name="pattern_password" class="patternlock" />
                            <input type="submit" value="login"/>
                        </div>
                    </form><br/>
                    <h3><?php echo isset($_SESSION['invalid_pattern']) ? $_SESSION['invalid_pattern'] : ''; ?></h3>
            <?php
                }
            } 
            else
            {
                if(($_SERVER['REQUEST_METHOD'] == "POST"  && isset($_POST['new_password'])) || ((isset($_POST['confirm_password']) && (isset($_SESSION['new_password']))) && ($_SESSION['new_password'] != $_POST['confirm_password'] || $_SESSION['new_password'] == $_POST['confirm_password'])))
                {
                    $_SESSION['new_password'] = (isset($_POST['new_password']) ? md5($_POST['new_password']) : (isset($_SESSION['new_password']) ? $_SESSION['new_password'] : true));
                    if(isset($_POST['confirm_password']) && isset($_SESSION['new_password']))
                    {
                        if($_SESSION['new_password'] == md5($_POST['confirm_password']))
                        {

                            $_SESSION['password_generated'] = true;
                        }
                        else
                        {
                            $_SESSION['password_require'] = 'Password not matched!!';
                            $_SESSION['password_generated'] = false;
                        }
                    }
                    else
                    {
                        unset($_SESSION['password_require']);
                    }
                    $nConfirmPasswordFlag = 1;
                    ?>            
                        <div>
                            <script>
                                function submitform(){
                                   return true;
                                }
                            </script>
                            <form method="post" onsubmit="return submitform()" id="confirmPasswordForm">
                                    <h2>Confirm Password</h2>
                                    <div>
                                        <input type="password" id="confirm_password" name="confirm_password" class="patternlock" />
                                        <input type="submit" value="login"/>
                                    </div>
                            </form><br/>
                            <h3> <?php echo isset($_SESSION['password_require']) ? $_SESSION['password_require'] : '';?> </h3>
                        </div>
                    <?php
                }
                if(isset($_SESSION['password_generated']) && $_SESSION['password_generated'])
                {
                    mkdir(ROOT_DIR."/data/$constantpath/admin");
                    $username_password = ROOT_DIR."/data/$constantpath/admin/username_password.php";
                    //echo $username_password;exit;
                    $handle = fopen($username_password, 'w')or die('Cannot open file:  '.$username_password); ;
                    $sPassword = md5($_POST['confirm_password']);
                    $txt = '<?php

                    //Encrypted UserName and Password
                    $sUserName = md5("admin");
                    $sPassword = "'.$sPassword.'";

                    // Defining UserName and Password to check against credentials
                    define("USER_NAME", $sUserName);
                    define("PASSWORD", $sPassword);
                    ?>';
                    fwrite($handle, $txt);
                    header("Location:".$sSiteUrl."/admin");
                }
                else if($nConfirmPasswordFlag == 0)
                {
            ?>
            <div id="login">
                <script>
                    function submitform(){
                       return true;
                    }
                </script>
                <form method="post" action="" id="newPasswordForm">
                    <h2>New Password</h2>
                    <div>
                        <input type="password" id="new_password" name="new_password" class="patternlock" />
                        <input type="submit" value="login"/>
                    </div>
                </form>
            </div>         
        <?php
            }
        }
        ?>
    </body>
</html>