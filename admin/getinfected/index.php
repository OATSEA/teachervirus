<?php
    $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
    $sDestination = $sFolderPath.'/data/bootstrap.php';
    require_once($sDestination);
    
    $protocol = SITE_URL."/getinfected.php?isValidUser=true";
    header("Location: $protocol");