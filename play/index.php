<?php
    require_once("../data/constants.php");
    error_reporting(0);
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $protocol = trim($protocol);
        define('SITE_URL',$protocol);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Icons Menu</title>
        <link href="<?php echo SITE_URL; ?>/play/buttons.css" rel="stylesheet">
        <link href="<?php echo SITE_URL; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <script src="<?php echo SITE_URL; ?>/js/jquery.js"></script>
        <script src='<?php echo SITE_URL; ?>/js/jquery.imagefit.js'></script>
        <script src="<?php echo SITE_URL; ?>/play/buttons.js"></script>
        <script>$(document).ready(function() { setup(); }); </script>
    </head>
    <body class="main>
    <?php
        $rootdir = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) )."*";
        $payloadsDir = str_replace("play", (EXTERNAL_TEXT == 1) ? EXTERNAL_FOLDER.'/payloads' : '/payloads', $rootdir);
        $payloadsPath = str_replace("play", (EXTERNAL_TEXT == 1) ? EXTERNAL_FOLDER.'/payloads' : 'payloads',preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) ));
        $payloadsURL = SITE_URL.'/'.((EXTERNAL_TEXT == 1) ? EXTERNAL_FOLDER.'/payloads' : 'payloads');
        $adminURL =  SITE_URL.'/admin';
        if(ADMIN_COG == 1)
        {
            echo '<div class="color-white"><a class="admin_img" href="'.$adminURL.'"><i class="mainNav fa fa-cog fa-3x"></i></a></div><br/><br/>';
        }
        if(glob($payloadsDir, GLOB_ONLYDIR)==FALSE){
          $path = SITE_URL."/admin/getpayload";
           echo '<div><h2> You have Not Installed Any Payloads Please <a href='.$path.'></h2></div><div><font size="6">Click Here</font></div></a>
                 <div><h2> To Install Payloads</h2></div>';
         
        }
        
        foreach(glob($payloadsDir, GLOB_ONLYDIR) as $dir)
        {
            $dir = basename($dir); 
            $imgText = $dir."/icon.png";
            $svgText = $dir."/icon.svg";

            $svgTest = file_exists( $payloadsPath.$svgText);
            $imgTest = file_exists( $payloadsPath.$imgText);

            // need to add check for support of SVG!

            if ($svgTest)
            {
                echo '<div class="full-width"><div class="half-width"><a href="'.$payloadsURL.'/'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$payloadsURL.'/'.$svgText.'" />';
                $aPayloadLabel = explode('-',$dir);
                echo '<label class="payload-label">';
                echo (PAYLOAD_LABEL == 1) ? substr($aPayloadLabel[2],0,13) : '';
                echo '</label></a>';
                echo '</div></div>';
            }
            else if($imgTest)
            {
                echo '<div class="full-width"><div class="half-width"><a href="'.$payloadsURL.'/'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$payloadsURL.'/'.$imgText.'" >';
                $aPayloadLabel = explode('-',$dir);
                echo '<label class="payload-label">';
                echo (PAYLOAD_LABEL == 1) ? substr($aPayloadLabel[2],0,13) : '';
                echo '</label></a>';
                echo '</div></div>';
            }
            else
            {
                // Icon provided so use the default
                
                echo '<div class="full-width"><div class="half-width"<a href="'.$payloadsURL.'/'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="default.svg" />';
                $aPayloadLabel = explode('.',$dir);
                echo '<label class="payload-label">';
                echo (PAYLOAD_LABEL == 1) ? substr($aPayloadLabel[0],0,13) : '';
                echo '</label></a>';
                echo '</div></div>';
            }
        }
    ?>
    
    </body>
</html>