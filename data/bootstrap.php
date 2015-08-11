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
        define('PAYLOAD_FOLDER','payloads');
        define('PAYLOAD_PATH','$sDocumentRoot/payloads');
        define('LANGUAGE','en');
        define('DEBUG_TEXT','FALSE');
    ?>";
        $myfile = fopen("$sDestination", "w");
        $txt = $sListContent;
        fwrite($myfile, $txt);
        fclose($myfile);
        require 'constants.php';
    }
?>