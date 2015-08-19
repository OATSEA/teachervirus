<?php
    $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
    $sDestination = $sFolderPath.'/data/bootstrap.php';
    require_once($sDestination);
    
    header("Location:".SITE_URL.'/play/');
?>