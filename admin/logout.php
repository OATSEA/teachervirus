<?php
    require_once("../data/constants.php");
    error_reporting(0);
    $sSiteUrl = SITE_URL;
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $sSiteUrl = trim($protocol);
    }
    session_start();
    session_destroy();
    header("Location:".$sSiteUrl.'/play');
?>