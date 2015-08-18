<?php  
    $sFolderPath = $_SERVER['DOCUMENT_ROOT'];
    $sDestination = $sFolderPath.'/data/constants.php';
    if (file_exists($sDestination)) 
    {
        require 'constants.php'; 
    }
    else 
    {
        $sDocumentRoot = $_SERVER['DOCUMENT_ROOT'];
        $sSiteUrl = (isset($_SERVER["HTTP_HOST"]) ? "http://".$_SERVER["HTTP_HOST"] : '');
        $sListContent = "<?php
        define('ROOT_DIR','$sDocumentRoot');
        define('SITE_URL','$sSiteUrl');
        define('ROOT_PATH','$sDocumentRoot');
        define('LANGUAGE','en');
        define('DEBUG_TEXT','0');
        define('ADMIN_TEXT','1');
        define('EXTERNAL_TEXT','0');
    ?>";
        $myfile = fopen("$sDestination", "w");
        $txt = $sListContent;
        fwrite($myfile, $txt);
        fclose($myfile);
        require 'constants.php';
    }
?>