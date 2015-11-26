<?php
    if(file_exists('../../../.general.txt'))
    {
        $myfile = fopen('../../../.general.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize('../../../.general.txt'));
        $constant = explode(';',$protocol);
        $constantpath = $constant[1];
    }
    require_once("../../../data/$constantpath/constants.php");
    error_reporting(0);
    $sSiteUrl = SITE_URL;
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $sSiteUrl = trim($protocol);
        
    }
    $protocol = $sSiteUrl."/getinfected.php?isValidUser=true";
    header("Location: $protocol");