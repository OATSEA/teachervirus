<?php 
    if(session_status()!=PHP_SESSION_ACTIVE) session_start();
    error_reporting(E_ALL ^ E_WARNING);
    require_once("../../data/constants.php");
    require(ROOT_DIR.'/admin/checkLogin.php');
    $sSiteUrl = SITE_URL;
    if(file_exists(ROOT_DIR.'/IP.txt'))
    {
        $myfile = fopen(ROOT_DIR.'/IP.txt', "r") or die("Unable to open file!");
        $protocol = fread($myfile,filesize(ROOT_DIR.'/IP.txt'));
        $sSiteUrl = trim($protocol);
    }

    $sPayloadName = $sPayloadUrl = $sIsAdmin = '';
    function listFolderFiles($dir,$sHiddenName,$sCheckId)
    {
        $sNewDirPath = ROOT_DIR.DIRECTORY_SEPARATOR.$dir;
        $ffs = array();
        if(is_dir(ROOT_DIR.DIRECTORY_SEPARATOR.$dir))
        $ffs = scandir(ROOT_DIR.DIRECTORY_SEPARATOR.$dir);
        $nHiddenCnt = 0;
        foreach($ffs as $ff)
        {
            if($dir == "payloads" || $dir == "admin")
            {
                if(is_dir(ROOT_DIR.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$ff) && $ff != '.' && $ff != '..')
                {
                    $extension = pathinfo($ff, PATHINFO_EXTENSION);
                    if ($extension != 'zip') 
                    {
                ?>
                        <input class="text-left" type='checkbox' id='<?php echo $sCheckId.'_'.$nHiddenCnt ?>' name="delete_payload[]" value="<?php echo $sNewDirPath.DIRECTORY_SEPARATOR.$ff ?>" onClick="getDetails('<?php echo $sCheckId.'_'.$nHiddenCnt ?>')">
                        <div class="text-field"><?php echo '&nbsp;'.$ff ?></div><br/>

                <?php
                        $nHiddenCnt++;
                    }
                }
            }
            
            if($dir == "content" || $dir == "data")
            {
                if(is_dir(ROOT_DIR.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$ff) && $ff != '.' && $ff != '..')
                {
                    if(is_dir(ROOT_DIR.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$ff))
                        $aFolders = scandir(ROOT_DIR.DIRECTORY_SEPARATOR.$dir.DIRECTORY_SEPARATOR.$ff);
                    
                    foreach($aFolders as $sFolder)
                    {
                        if($sFolder != '.' && $sFolder != '..')
                        {
                            $extension = pathinfo($sFolder, PATHINFO_EXTENSION);
                            if ($extension != 'zip') 
                            {
                    ?>
                            <input class="text-left" type='checkbox' id='<?php echo $sCheckId.'_'.$nHiddenCnt ?>' name="delete_payload[]" value="<?php echo $sNewDirPath.DIRECTORY_SEPARATOR.$ff.DIRECTORY_SEPARATOR.$sFolder ?>" onClick="getDetails('<?php echo $sCheckId.'_'.$nHiddenCnt ?>')">
                            <div class="text-field"><?php echo '&nbsp;'.$sFolder ?></div><br/>

                    <?php
                                $nHiddenCnt++;
                            }
                        }
                    }
                }
            }
        }
    }
// RRMDIR: Recursively remove subdirectories function 
// SOURCE: taken http://php.net/manual/en/function.rmdir.php 

function rrmdir($dir) 
{
    if (is_dir($dir)) { 
     $objects = scandir($dir);
     foreach ($objects as $object) { 
       if ($object != "." && $object != "..")
           { 
            if (filetype($dir."/".$object) == "dir")
                rrmdir($dir."/".$object);
            else unlink($dir."/".$object); 
       } 
     } 
     reset($objects);
     rmdir($dir);
   } 
   else
   {
       (file_exists($dir)) ? unlink($dir) : '';
       if (preg_match('/admin/',$dir))
           rrmdir ($_SERVER['ROOT_DIR'].'infect/admin');
       
       if (preg_match('/payloads/',$dir))
           rrmdir ($_SERVER['ROOT_DIR'].'infect/payloads');
   }
} // END RRMDIR

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    foreach ($_POST['delete_payload'] as $aPost)
    {
        (empty($aPost)) ? '' :rrmdir($aPost);
        (file_exists($aPost.'.zip')) ? unlink($aPost.'.zip') : '';
    }
}
    $protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST'];
?>
<html>
    <head>
        <title>Payloads</title>
        <meta charset="utf-8">
        <link href="../../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <script src="../../js/jquery.js" type="text/javascript"></script>
        <style>
            label {
            font-weight: normal;
            line-height: 24px !important;
            }
      @media only screen  and (max-width:1366px)
            {          
            form{
                border: 1px solid #fff;
                float: left;
                margin: 20px auto;
                padding: 20px;
                text-align: left;
                width: 100%;
               }
               select{
                   width : 100%;
               }
            }

            .example-text{
                width: 100%;
            }
            .go-button{
                    float: right;
                    margin-right: 10px;
                    padding:10px !important;
            }
            .go-button > a{
                    color: #000;
                    background: blue !important;
                    border-radius: 5px;
                    padding:7px !important;
                    border: none;
                    color: white;

            }
            .go-button > a:hover{
                color: white;
                text-decoration: none;
            }
            .admin_img {
                color: #fff;
                float: right;
                padding-bottom: 10px;
                padding-right: 20px;
                padding-top: 10px;
            }
            
            .payload-details{
                border-bottom: 1px solid #fff;
                margin-bottom: 20px;
                text-align: center;
                width: 100%;
            }
            .mandatory{
                font-weight: bold;
                font-size: 18px;
            }
            .sources{
                    margin-left: 13px;
                    }
            .text-left{
                float: left;
            }
            .admin-payloads{
                border-right: 1px solid #fff;
                float: left;
                width: 50%;
            }
            .general-payloads{
                border-right: 1px solid #fff;
                float: right;
                width: 48%;
            }
            .payloads{
                width: 100%;

            }
            #loading {
                font-size: 70px;
                font-weight: bold;
                color: #000;
                width: 100%;
                height: 100%;
                top: 0px;
                left: 0px;
                position: fixed;
                display: block;
                opacity: 0.7;
                background-color: #fff;
                z-index: 99;
                text-align: center;
            }
            #loading-image {
               position: absolute;
               top: 100px;
               left: 500px;
               z-index: 100;
            }
            @media only screen and (max-width:1366px)
            {
                input[type="text"] {
                    color: #000;
                    display: block;
                    margin-bottom: 10px;
                    background-color: wheat;
                    width: 24%;
                }  
            }
            @media only screen and (min-width:20px) and (max-width:480px)
            {
            input[type="text"] {
                    color: #000;
                    display: block;
                    margin-bottom: 10px;
                    background-color: wheat;
                    width: 100%;
                    }
            }

        
            input[type="radio"] {
            line-height: normal;
            margin: 11px 0 0;
           }
            
            .title h2 {
             margin: auto 0px;
             text-align: center;
             border-bottom: 1px solid;
             margin-bottom: 17px;
             padding-bottom: 10px;
            }
            input[type="checkbox"]{
                margin: 4px 0px 0px 16px;
                line-height: normal;
            }
           
        </style>
        
        <script type="text/javascript">
            function setHiddenValue(hiddenFieldId, checkId, dirPath)
            {
                if($("#"+checkId).is(":checked"))
                {
                    $('#'+hiddenFieldId).val(dirPath);
                }
                else
                {
                    $('#'+hiddenFieldId).val('');
                }
            }
            
            function changeValue()
            {
                if ($('#ckeck_admin').is(":checked"))
                {
                    $('#ckeck_admin').val(1);
                }
                else
                {
                    $('#ckeck_admin').val(0);
                }
            }
            
            function deletePayload()
            {
                var x = confirm("Are you sure you want to delete payload!!");
                if (x == true)
                {
                    $("#getpayload_form").submit();
                }
                return false;
            }
        </script>
        <link href="<?php echo $sSiteUrl; ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo $sSiteUrl; ?>/admin/buttons.css" rel="stylesheet">
        
    </head>
    <body class="main">
        <div class="color-white">
            <a class="play_img" href="<?php echo $sSiteUrl; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
        </div><br/><br/>
        <div class="container">
            <form id="getpayload_form" method="post" name="form1" action="" enctype="multipart/form-data" style="width:100%;">
                <div class="payloads">
                    <div class="payload-details">
                        <h2>Payload Details</h2>
                    </div>
                    
                    <div class="admin-payloads">
                        <div class="text-field">
                            <h2>Admin Payloads</h2><hr/>
                            <label class="lable">
                            <?php
                                listFolderFiles("admin","admin","admin_check");
                                listFolderFiles("infect/admin","infect_admin","infect_admin_check");
                                
                            ?>
                            </label>
                        </div>
                    </div>

                    <div class="general-payloads">
                        <div class="text-field">
                            <h2>General Payloads</h2><hr/>
                            <label class="lable">
                            <?php
                                listFolderFiles("payloads","payloads","payloads_check");
                                listFolderFiles("content","content","content_check");
                                listFolderFiles("data","data","data_check");
                                listFolderFiles("infect/payloads","infect_payloads","infect_payloads_check");
                            ?>
                            </label>
                        </div>
                    </div>
                    <div class="go-button">
                        <a href="javascript:void(0);" onclick="deletePayload()">Delete</a>
                    </div>
                </div>
                <br/>
            </form>
        </div>
    </body>
</html>