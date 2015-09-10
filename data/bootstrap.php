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
        $sInfectionResource = isset($_SESSION['infection_resource']) ? $_SESSION['infection_resource'] : '';
        $sTvBranchName = isset($_SESSION['teachervirus_branch']) ? $_SESSION['teachervirus_branch'] : 'master';
        $sDeviceAddress = isset($_SESSION['device_address']) ? $_SESSION['device_address'] : '';
        $nPort = isset($_SESSION['port_number']) ? $_SESSION['port_number'] : '';
        
        $bChmod = isset($_SESSION['chmod']) ? $_SESSION['chmod'] : '0';
        $sListContent = "<?php
        define('ROOT_DIR','$sDocumentRoot');
        define('SITE_URL','$aExplodeUrl[0]');
        define('EXTERNAL_FOLDER','');
        define('EXTERNAL_PATH','$sDocumentRoot');
        define('LANGUAGE','en');
        define('DEBUG_TEXT','0');
        define('EXTERNAL_TEXT','0');
        define('PAYLOAD_INSTALL','0');
        define('CHMOD','$bChmod');
        define('TV_BRANCH','$sTvBranchName');
        define('GETINFECTED_BRANCH','master');    
        define('ADMIN_COG','1');
        define('SHOW_TV','0');
        define('INFECTED_RESOURCE','$sInfectionResource');
        define('DEVICE_ADDRESS','$sDeviceAddress');
        define('PORT_NUMBER','$nPort');";
        
        $myfile = fopen("$sDocumentRoot/data/constants.php", "w")or die('Cannot open file: constants.php');
        fwrite($myfile, $sListContent);
        fclose($myfile);
        require($sDestination);
    }