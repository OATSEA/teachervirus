<?php
    require_once("../../../data/UUID/constants.php");
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
        <link href="<?php echo $sSiteUrl; ?>/tv/admin/buttons/buttons.css" rel="stylesheet">
        <link href="<?php echo $sSiteUrl; ?>/tv/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo $sSiteUrl; ?>/tv/admin/changePassword/_style/changePassword.css"/>
        <script src="<?php echo $sSiteUrl; ?>/tv/admin/changePassword/js/jquery-1.11.1.js"></script>
        <script src='<?php echo $sSiteUrl; ?>/tv/js/jquery.imagefit.js'></script>
        <script src="<?php echo $sSiteUrl; ?>/tv/admin/buttons/buttons.js"></script>
        <script src="<?php echo $sSiteUrl; ?>/tv/admin/changePassword/_script/changePassword.js"></script>
    </head>
    <body class="main" >
        <?php
            if (@session_id() == "") @session_start();

            $_SESSION['password_generated'] = false;
            $nConfirmPasswordFlag = 0;
            if (file_exists(ROOT_DIR."/data/UUID/admin/username_password.php")) 
            {
                require(ROOT_DIR."/data/UUID/admin/username_password.php");
                //Checking for request method.
                if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['pattern_password']))
                {
                    if(USER_NAME == md5($_POST['pattern_username']) && PASSWORD == md5($_POST['pattern_password']))
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
                    $rootdir = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , ROOT_DIR.'/tv/admin/' )."*";

                    $playURL = $sSiteUrl.'/tv/play';
                    require(ROOT_DIR.'/tv/admin/buttons/header.php');
                    
                    foreach(glob($rootdir, GLOB_ONLYDIR) as $dir)
                    { 
                        $dir = basename($dir);
                        $imgText = ROOT_DIR."/tv/admin/$dir/icon.png";
                        $imgPath = $sSiteUrl."/tv/admin/$dir/icon.png";
                        $sLogoUrl = $sSiteUrl."/tv/admin/$dir";
                        $imgTest = file_exists( $imgText);
                        
                        if ($imgTest)
                        {
                            echo '<div class="full-width"><a href="'.$sLogoUrl.'"><img class="mybutton" alt="'.$dir.'" src="'.$imgPath.'" />';
                            echo '<label class="payload-label">';
                            echo ucfirst($dir);
                            echo '</label></a>';
                            echo '</div>';
                        }
                        else
                        {
                            // Icon provided so use the default
                            echo '<div class="full-width"><a href="'.$sLogoUrl.'"><img class="mybutton" alt="'.$dir.'" src="default.png" />';
                            echo '<label class="payload-label">';
                            echo ucfirst($dir);
                            echo '</label></a>';
                            echo '</div>';
                        }
                    }
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
                        <a class="play_img" href="<?php echo $sSiteUrl.'/tv/play'; ?>">
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
                    mkdir(ROOT_DIR."/data/UUID/admin");
                    $username_password = ROOT_DIR."/data/UUID/admin/username_password.php";
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
                    header("Location:".$sSiteUrl."/tv/admin/buttons");
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