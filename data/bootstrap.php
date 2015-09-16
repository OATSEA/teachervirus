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
        runkit_constant_redefine('ROOT_DIR','$sDocumentRoot');
        runkit_constant_redefine('SITE_URL','$aExplodeUrl[0]');
        runkit_constant_redefine('EXTERNAL_FOLDER','');
        runkit_constant_redefine('EXTERNAL_PATH','$sDocumentRoot');
        runkit_constant_redefine('LANGUAGE','en');
        runkit_constant_redefine('DEBUG_TEXT','0');
        runkit_constant_redefine('EXTERNAL_TEXT','0');
        runkit_constant_redefine('PAYLOAD_INSTALL','0');
        runkit_constant_redefine('CHMOD','$bChmod');
        runkit_constant_redefine('TV_BRANCH','$sTvBranchName');
        runkit_constant_redefine('GETINFECTED_BRANCH','master');    
        runkit_constant_redefine('ADMIN_COG','1');
        runkit_constant_redefine('SHOW_TV','0');
        runkit_constant_redefine('INFECTED_RESOURCE','$sInfectionResource');
        runkit_constant_redefine('DEVICE_ADDRESS','$sDeviceAddress');
        runkit_constant_redefine('PORT_NUMBER','$nPort');";
        
        $myfile = fopen("$sDocumentRoot/data/constants.php", "w")or die('Cannot open file: constants.php');
        fwrite($myfile, $sListContent);
        fclose($myfile);
        require($sDestination);
    }