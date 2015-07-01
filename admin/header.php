<?php 
    require 'checkLogin.php';
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST'];
?>
<div class="color-white">
    <a class="play_img" href="<?php echo $protocol.$playURL; ?>"><i class="mainNav fa fa-play-circle-o fa-3x"></i></a>
    <!--<a href="<?php echo $protocol ?>/admin/logout.php"><img src="logout.png" class="logout_img"></a>-->
    <a class="logout_img" href="<?php echo $protocol ?>/admin/logout.php"><i class="mainNav fa fa-sign-out fa-3x"></i></a>
</div>
<br><br>