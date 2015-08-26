<?php
    require_once("../data/constants.php");
    require(ROOT_DIR.'/admin/checkLogin.php');
?>
<div class="color-white">
    <a class="play_img" href="<?php echo $playURL; ?>"><i class="mainNav fa fa-play-circle-o fa-3x"></i></a>
    <a class="logout_img" href="<?php echo SITE_URL ?>/admin/logout.php"><i class="mainNav fa fa-sign-out fa-3x"></i></a>
</div>
<br><br>