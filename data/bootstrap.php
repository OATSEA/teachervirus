<?php
    error_reporting(0);
    if(file_exists(getcwd().'/IP.txt'))
    {
        $myfile = fopen(getcwd().'/IP.txt', "r") or die("Unable to open file!");
        $aExplodeUrl[0] = fread($myfile,filesize(getcwd().'/IP.txt'));
    }
    else
    {
        $sSiteUrl = (isset($_SERVER["HTTP_HOST"]) ? "http://".$_SERVER["HTTP_HOST"] : '');
        $sRequestUrl = $sSiteUrl.$_SERVER['REQUEST_URI'];
        $aExplodeUrl = explode("/getinfected.php", $sRequestUrl);
    }
    
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
if(!defined('ROOT_DIR'))
    define('ROOT_DIR','$sDocumentRoot');
        
if(!defined('SITE_URL'))
    define('SITE_URL','$aExplodeUrl[0]');
        
if(!defined('EXTERNAL_FOLDER'))
    define('EXTERNAL_FOLDER','');
        
if(!defined('EXTERNAL_PATH'))
    define('EXTERNAL_PATH','$sDocumentRoot');
        
if(!defined('LANGUAGE'))
    define('LANGUAGE','en');
        
if(!defined('PAYLOAD_LABEL'))
    define('PAYLOAD_LABEL','0');
        
if(!defined('EXTERNAL_TEXT'))
    define('EXTERNAL_TEXT','0');
        
if(!defined('PAYLOAD_INSTALL'))
    define('PAYLOAD_INSTALL','0');
        
if(!defined('CHMOD'))
    define('CHMOD','$bChmod');
        
define('TV_BRANCH','$sTvBranchName');
        
define('GETINFECTED_BRANCH','master');
        
define('ADMIN_COG','1');
        
define('SHOW_TV','0');
        
define('INFECTED_RESOURCE','$sInfectionResource');
    
define('DEVICE_ADDRESS','$sDeviceAddress');
        
define('PORT_NUMBER','$nPort');
                
define('TVPLAYER_LOCATION','');";
        
        $myfile = fopen("$sDocumentRoot/data/constants.php", "w")or die('Cannot open file: constants.php');
        fwrite($myfile, $sListContent);
        fclose($myfile);
        require($sDestination);
    }