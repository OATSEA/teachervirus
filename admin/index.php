<!DOCTYPE html>
<html>
<head>
<title>Icons Menu</title>
<link href="buttons.css" rel="stylesheet">
<link href="../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<script src="../js/jquery.js"></script>
<script src='../js/jquery.imagefit.js'></script>
<script src="buttons.js"></script>
<script>$(document).ready(function() { setup(); }); </script>
</head>
<body class="main" >

<?php
    //header("Cache-Control: max-age=300, must-revalidate");
    //ini_set('session.cache_limiter', 'private');
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST'];
    //Starts session
    if (@session_id() == "") @session_start();

    //$_SESSION['password_generated'] = false;
    if (file_exists("username_password.php")) 
    {
        require 'username_password.php';
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
            $rootdir = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) )."*";
            // echo $rootdir."<br>";

            $thisURL = $_SERVER['REQUEST_URI'];
            $playURL =  str_replace('admin', 'play', $thisURL);
            $sChangePasswordURL =  str_replace('admin', 'admin/changePassword', $thisURL);
            require 'header.php';
            foreach(glob($rootdir, GLOB_ONLYDIR) as $dir) { 
                    $dir = basename($dir); 
                    $imgText = $dir."/icon.png";
                    $imgTest = file_exists( $imgText);
                    if ($imgTest) {
                            echo '<a href="'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$imgText.'" /></a>';
                            // <span class="pluscap"><br>'.$dir.'</span>
                } else {
                    // Icon provided so use the default
                    echo '<a href="'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="default.png" /></a>';
                }
            } 
            (isset($sChangePasswordURL) && !empty($sChangePasswordURL)) ? '<a href="'.$protocol.$sChangePasswordURL.'"><img class="mybutton" alt="Play" src="'.$sChangePasswordURL.'icon.png" /></a>' : '';
            //echo '<a href="'.$playURL.'"><img class="mybutton" alt="Play" src="'.$playURL.'icon.png" /></a>';
        }
        else
        {
    ?>
            <link rel="stylesheet" type="text/css" href="changePassword/_style/changePassword.css"/>
            <script src="changePassword/js/jquery-1.11.1.js"></script>

            <script>
                function submitform(){
                   return true;
                }
            </script>

            <script src="changePassword/_script/changePassword.js"></script>
            <div class="color-white">
                <a class="play_img" href="<?php echo $protocol.'/play'; ?>">
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
            $_SESSION['new_password'] = (isset($_POST['new_password']) ? md5($_POST['new_password']) : (isset($_SESSION['new_password']) ? $_SESSION['new_password'] : ''));
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
            ?>            
                <div>
                    <link rel="stylesheet" type="text/css" href="changePassword/_style/changePassword.css"/>
                    <script src="changePassword/js/jquery-1.11.1.js"></script>
                    <script>
                        function submitform(){
                           return true;
                        }
                    </script>
                    <script src="changePassword/_script/changePassword.js"></script>
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

        if($_SESSION['password_generated'])
        {
            $username_password = 'username_password.php';
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
            $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            $protocol .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header("Location:".$protocol);
        }
        else if(!isset($_SESSION['new_password']) && !$_SESSION['password_generated'])
        {
    ?>
            <div id="login">
                <link rel="stylesheet" type="text/css" href="changePassword/_style/changePassword.css"/>
                <script src="changePassword/js/jquery-1.11.1.js"></script>
                <script src="changePassword/_script/changePassword.js"></script>
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

