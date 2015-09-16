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
        if(!define('ROOT_DIR')) 
            define('ROOT_DIR','$sDocumentRoot');
        
        if(!define('SITE_URL')) 
            define('SITE_URL','$aExplodeUrl[0]');
        
        if(!define('EXTERNAL_FOLDER')) 
            define('EXTERNAL_FOLDER','');
        
        if(!define('EXTERNAL_PATH')) 
            define('EXTERNAL_PATH','$sDocumentRoot');
        
        if(!define('LANGUAGE')) 
            define('LANGUAGE','en');
        
        if(!define('DEBUG_TEXT')) 
            define('DEBUG_TEXT','0');
        
        if(!define('EXTERNAL_TEXT')) 
            define('EXTERNAL_TEXT','0');
        
        if(!define('PAYLOAD_INSTALL')) 
            define('PAYLOAD_INSTALL','0');
        
        if(!define('CHMOD')) 
            define('CHMOD','$bChmod');
        
        if(!define('TV_BRANCH')) 
            define('TV_BRANCH','$sTvBranchName');
        
        if(!define('ROOT_DIR')) 
            define('GETINFECTED_BRANCH','master');    
        
        if(!define('ADMIN_COG')) 
            define('ADMIN_COG','1');
        
        if(!define('SHOW_TV')) 
            define('SHOW_TV','0');
        
        if(!define('INFECTED_RESOURCE')) 
            define('INFECTED_RESOURCE','$sInfectionResource');
    
        if(!define('DEVICE_ADDRESS')) 
            define('DEVICE_ADDRESS','$sDeviceAddress');
        
        if(!define('PORT_NUMBER')) 
            define('PORT_NUMBER','$nPort');";
        
        $myfile = fopen("$sDocumentRoot/data/constants.php", "w")or die('Cannot open file: constants.php');
        fwrite($myfile, $sListContent);
        fclose($myfile);
        require($sDestination);
    }