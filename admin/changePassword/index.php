<?php
    require '../checkLogin.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=320; user-scalable=no; initial-scale=1.0; maximum-scale=1.0" />
    <title>Pattern Lock</title>
</head>
<body class="main" >
    <link rel="stylesheet" type="text/css" href="_style/changePassword.css"/>
    <link href="../buttons.css" rel="stylesheet">
    <link href="../../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="_script/changePassword.js"></script>
    <script src="js/jquery-1.11.1.js"></script>
    <script>
        function submitform(){
           return true;
        }
    </script>
    <?php
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
        $protocol .= "://" . $_SERVER['HTTP_HOST']."/admin";
    ?>
<?php
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['old_password']) && isset($_SESSION['pattern_password']) && (md5($_POST['old_password']) == $_SESSION['pattern_password']))
    {
        $_SESSION['old_password'] = md5($_POST['old_password']);
        if(($_SESSION['old_password'] == $_SESSION['pattern_password']))
        {
?>
        <div class="color-white">
            <a class="play_img" href="<?php echo $protocol; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
            <h2>New Password</h2>
        </div><br/><br/>
        <div id="login">
            <form method="post" action="" id="newPasswordForm">
                <div>
                    <input type="password" id="change_new_password" name="change_new_password" class="patternlock" />
                    <input type="submit" value="login"/>
                </div>
            </form>
        </div>
<?php
        }
        else
        {
            $_SESSION['old_password_not_matched'] = "Old password not matched!!";
?>
            <div class="color-white">
                <a class="play_img" href="<?php echo $protocol; ?>">
                    <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
                </a>
                <h2>Old Password</h2>
            </div><br/><br/>
            <div>
                <form method="post" onsubmit="return submitform()" id="oldPasswordForm">
                    <div>
                        <input type="password" id="old_password" name="old_password" class="patternlock" />
                        <input type="submit" value="login"/>
                    </div>
                </form><br/>
                <h3> <?php echo isset($_SESSION['old_password_not_matched']) ? $_SESSION['old_password_not_matched'] : '';?> </h3>
            </div>
<?php
        }
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['change_new_password']) && isset($_SESSION['old_password']))
    {
        $_SESSION['change_new_password'] = md5($_POST['change_new_password']);
?>
        <div class="color-white">
            <a class="play_img" href="<?php echo $protocol; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
            <h2>Confirm Password</h2>
        </div><br/><br/>
        <div>
            <form method="post" onsubmit="return submitform()" id="confirmPasswordForm">
                <div>
                    <input type="password" id="change_confirm_password" name="change_confirm_password" class="patternlock" />
                    <input type="submit" value="login"/>
                </div>
            </form><br/>
            <h3> <?php echo isset($_SESSION['not_valid_password']) ? $_SESSION['not_valid_password'] : '';?> </h3>
        </div>
<?php
    }
    else if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['change_confirm_password']) && isset($_SESSION['change_new_password']))
    {
        $_SESSION['change_new_password'] = (isset($_POST['change_new_password']) ? md5($_POST['change_new_password']) : (isset($_SESSION['change_new_password']) ? $_SESSION['change_new_password'] : ''));
        if(isset($_POST['change_confirm_password']) && isset($_SESSION['change_new_password']))
        {
            if($_SESSION['change_new_password'] == md5($_POST['change_confirm_password']))
            {
                $_SESSION['change_confirm_password'] = md5($_POST['change_confirm_password']);
                $_SESSION['password_changed'] = true;
            }
            else
            {
                $_SESSION['not_valid_password'] = 'Password not matched!!';
                $_SESSION['password_changed'] = false;
            }
        }
        else
        {
            unset($_SESSION['not_valid_password']);
        }
    }
    else
    {
        $_SESSION['old_password_not_matched'] = isset($_POST['old_password']) ?  "Old password not matched!!" : "";
?>
        <div class="color-white">
            <a class="play_img" href="<?php echo $protocol; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
            <h2>Old Password</h2>
        </div><br/><br/>
        <div>
            <form method="post" onsubmit="return submitform()" id="oldPasswordForm">
                <div>
                    <input type="password" id="old_password" name="old_password" class="patternlock" />
                    <input type="submit" value="login"/>
                </div>
            </form><br/>
            <h3> <?php echo isset($_SESSION['old_password_not_matched']) ? $_SESSION['old_password_not_matched'] : '';?> </h3>
        </div>
<?php
    }
    if($_SESSION['password_changed'])
    {
        $sDirName = $_SERVER['DOCUMENT_ROOT']."/admin/";
        $username_password = 'username_password.php';
        unlink($sDirName.$username_password);
        $handle = fopen($sDirName.$username_password, 'w')or die('Cannot open file:  '.$username_password); ;
        $sPassword = $_SESSION['change_confirm_password'];
        $_SESSION['pattern_password'] = $_SESSION['change_confirm_password'];
        $txt = '<?php

        //Encrypted UserName and Password
        $sUserName = md5("admin");
        $sPassword = "'.$sPassword.'";
        // Defining UserName and Password to check against credentials
        define("USER_NAME", $sUserName);
        define("PASSWORD", $sPassword);
        ?>';
        fwrite($handle, $txt);
        unset($_SESSION['change_confirm_password'],$_SESSION['old_password'],$_SESSION['change_new_password'],$_SESSION['password_changed'],$_SESSION['not_valid_password']);
        header("Location:".$protocol);
    }
    else if(isset($_SESSION['not_valid_password']))
    {
?>
        <div class="color-white">
            <a class="play_img" href="<?php echo $protocol; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
            <h2>Confirm Password</h2>
        </div><br/><br/>
        <div>
            <form method="post" onsubmit="return submitform()" id="confirmPasswordForm">
                <div>
                    <input type="password" id="change_confirm_password" name="change_confirm_password" class="patternlock" />
                    <input type="submit" value="login"/>
                </div>
            </form><br/>
            <h3> <?php echo isset($_SESSION['not_valid_password']) ? $_SESSION['not_valid_password'] : '';?> </h3>
        </div>
<?php
    }
?>
</body>
</html>
