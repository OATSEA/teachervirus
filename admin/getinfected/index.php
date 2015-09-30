<?php
    require_once("../../data/constants.php");
    error_reporting(0);
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $protocol = trim($protocol);
        define('SITE_URL',$protocol);
    }
    $protocol = SITE_URL."/getinfected.php?isValidUser=true";
    header("Location: $protocol");