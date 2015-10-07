<?php
    require_once("../data/constants.php");
    error_reporting(0);
    $sSiteUrl = SITE_URL;
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $sSiteUrl = trim($protocol);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Icons Menu</title>
        <link href="<?php echo $sSiteUrl; ?>/play/buttons.css" rel="stylesheet">
        <link href="<?php echo $sSiteUrl; ?>/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <script src="<?php echo $sSiteUrl; ?>/js/jquery.js"></script>
        <script src='<?php echo $sSiteUrl; ?>/js/jquery.imagefit.js'></script>
        <script src="<?php echo $sSiteUrl; ?>/play/buttons.js"></script>
        <script>$(document).ready(function() { setup(); }); </script>
    </head>
    <body class="main>
    <?php
        $rootdir = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) )."*";
        $payloadsDir = str_replace("play", (EXTERNAL_TEXT == 1) ? EXTERNAL_FOLDER.'/payloads' : '/payloads', $rootdir);
        $payloadsPath = str_replace("play", (EXTERNAL_TEXT == 1) ? EXTERNAL_FOLDER.'/payloads' : 'payloads',preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) ));
        $payloadsURL = $sSiteUrl.'/'.((EXTERNAL_TEXT == 1) ? EXTERNAL_FOLDER.'/payloads' : 'payloads');
        $adminURL =  $sSiteUrl.'/admin';
        if(ADMIN_COG == 1)
        {
            echo '<div class="color-white"><a class="admin_img" href="'.$adminURL.'"><i class="mainNav fa fa-cog fa-3x"></i></a></div><br/><br/>';
        }
        if(glob($payloadsDir, GLOB_ONLYDIR)==FALSE){
          $path = $sSiteUrl."/admin/getpayload";
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
                echo '<div class="full-width"><a href="'.$payloadsURL.'/'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$payloadsURL.'/'.$svgText.'" />';
                $aPayloadLabel = explode('-',$dir);
                echo '<label class="payload-label">';
                echo (PAYLOAD_LABEL == 1) ? ucfirst(substr($aPayloadLabel[2],0,13)) : '';
                echo '</label></a>';
                echo '</div>';
            }
            else if($imgTest)
            {
                echo '<div class="full-width"><a href="'.$payloadsURL.'/'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$payloadsURL.'/'.$imgText.'" >';
                $aPayloadLabel = explode('-',$dir);
                echo '<label class="payload-label">';
                echo (PAYLOAD_LABEL == 1) ? ucfirst(substr($aPayloadLabel[2],0,13)) : '';
                echo '</label></a>';
                echo '</div>';
            }
            else
            {
                // Icon provided so use the default
                
                echo '<div class="full-width"><a href="'.$payloadsURL.'/'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$payloadsURL.'/'.'default.svg" />';
                $aPayloadLabel = explode('.',$dir);
                echo '<label class="payload-label">';
                echo (PAYLOAD_LABEL == 1) ? ucfirst(substr($aPayloadLabel[0],0,13)) : '';
                echo '</label></a>';
                echo '</div>';
            }
        }
    ?>
    
    </body>
</html>