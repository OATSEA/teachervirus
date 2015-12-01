<?php
     if(file_exists('../../../.general.txt'))
    {
        $myfile = fopen('../../../.general.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize('../../../.general.txt'));
        $constant = explode(';',$protocol);
        $constantpath = $constant[1];
    }
    require_once("../../../$constantpath/constants.php");
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
<div class="color-white">
    <a class="play_img" href="<?php echo $playURL; ?>"><i class="mainNav fa fa-play-circle-o fa-3x"></i></a>
    <a class="logout_img" href="<?php echo $sSiteUrl ?>/tv/admin/buttons/logout.php"><i class="mainNav fa fa-sign-out fa-3x"></i></a>
</div>