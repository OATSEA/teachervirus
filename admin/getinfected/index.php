<?php
    $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
    $sDestination = $sFolderPath.'/data/bootstrap.php';
    require_once $sDestination;
    $sGetInfectedUrl = SITE_URL."/getinfected.php?isValidUser=true";
    header("Location: $sGetInfectedUrl");