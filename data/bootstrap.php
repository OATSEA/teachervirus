<?php
    $sSiteUrl = (isset($_SERVER["HTTP_HOST"]) ? "http://".$_SERVER["HTTP_HOST"] : '');
    $sRequestUrl = $sSiteUrl.$_SERVER['REQUEST_URI'];
    $aExplodeUrl = explode("/getinfected.php", $sRequestUrl);
    $sDestination = getcwd().'/data/constants.php';
    
    if (file_exists($sDestination)) 
    {
        require("constants.php"); 
    }
    else 
    {
        $sDocumentRoot = getcwd();
        $sTvBranchName = isset($_SESSION['teachervirus_branch']) ? $_SESSION['teachervirus_branch'] : 'master';
        $sListContent = "<?php
        define('ROOT_DIR','$sDocumentRoot');
        define('SITE_URL','$aExplodeUrl[0]');
        define('EXTERNAL_FOLDER','');
        define('EXTERNAL_PATH','$sDocumentRoot');
        define('LANGUAGE','en');
        define('DEBUG_TEXT','0');
        define('EXTERNAL_TEXT','0');
        define('PAYLOAD_INSTALL','0');
        define('DEBUG_COMMENT','0');
        define('SHOW_CHMOD','1');
        define('TV_BRANCH','$sTvBranchName');
        define('GETINFECTED_BRANCH','$sGetInfectedBranch');    
        define('ADMIN_COG','1');";
        $myfile = fopen("$sDocumentRoot/data/constants.php", "w")or die('Cannot open file: constants.php');
        fwrite($myfile, $sListContent);
        fclose($myfile);
        require($sDestination);
    }
?>