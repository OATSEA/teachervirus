<?php
    session_start();
    function listFolderFiles($dir,$sHiddenName,$sCheckId)
    {
        $sNewDirPath = $_SERVER['DOCUMENT_ROOT'].'/'.$dir;
        $ffs = array();
        if(is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$dir))
        $ffs = scandir($_SERVER['DOCUMENT_ROOT'].'/'.$dir);
        $nHiddenCnt = 0;
        foreach($ffs as $ff)
        {
            if($dir == "payloads" || $dir == "admin")
            {
                if(is_dir($_SERVER['DOCUMENT_ROOT'].'/'.$dir.'/'.$ff) && $ff != '.' && $ff != '..')
                {
        ?>
                        <input class="text-left" type='checkbox' id='<?php echo $sCheckId.'_'.$nHiddenCnt ?>' onclick='setHiddenValue("<?php echo $sHiddenName.'_'.$nHiddenCnt ?>","<?php echo $sCheckId.'_'.$nHiddenCnt ?>","<?php echo $sNewDirPath.'/'.$ff ?>");'>
                        <div class="text-field"><?php echo $ff ?></div>
                        <input type='hidden' id='<?php echo $sHiddenName.'_'.$nHiddenCnt ?>' name='<?php echo $sHiddenName.'_'.$sHiddenName.'_'.$nHiddenCnt ?>'><br/><br/>
                    
        <?php
                    $nHiddenCnt++;
                }
            }
            else
            {
                $extension = pathinfo($ff, PATHINFO_EXTENSION);
                if ($extension == 'zip') {
        ?>
                    <input class="text-right" type='checkbox' id='<?php echo $sCheckId.'_'.$nHiddenCnt ?>' onclick='setHiddenValue("<?php echo $sHiddenName.'_'.$nHiddenCnt ?>","<?php echo $sCheckId.'_'.$nHiddenCnt ?>","<?php echo $sNewDirPath.'/'.$ff ?>")'>
                    <div class="text-field"><?php echo $ff ?></div>    
                    <input type='hidden' id='<?php echo $sHiddenName.'_'.$nHiddenCnt ?>' name='<?php echo $sHiddenName.'_'.$nHiddenCnt ?>'><br/><br/>
        <?php
                        //$_SESSION['nHiddenCnt'] = isset($_SESSION['nHiddenCnt']) ? $_SESSION['nHiddenCnt'] + 1 : $nHiddenCnt + 1;
                        $nHiddenCnt++;
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
           if ($object != "." && $object != "..") { 
             if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object); 
           } 
         } 
         reset($objects);
         rmdir($dir);
       } 
       else
       {
           (file_exists($dir)) ? unlink($dir) : '';
           if (preg_match('/admin/',$dir))
               rrmdir ($_SERVER['DOCUMENT_ROOT'].'admin');

           if (preg_match('/payloads/',$dir))
                   rrmdir ($_SERVER['DOCUMENT_ROOT'].'payloads');
       }
    } // END RRMDIR

    $protocol = isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST'];
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['delete']))
    {
        foreach ($_POST as $aPost)
        {
            (empty($aPost)) ? '' :rrmdir($aPost);
        }
        echo '<h2>Delete Complete!</h2>'
        . '<div class="admin_img"><a href="'.$protocol.'/admin" class="color-white"><i class="mainNav fa fa-cog fa-3x"></i></a></div>'
        . '<div class="play_img"><a href="'.$protocol.'/play/" class="color-white"><i class="mainNav fa fa-play-circle-o fa-3x"></i></a></div>';
     die();
    }
?>
<html>
    <head>
        <title>Payloads</title>
        <meta charset="utf-8">
        <link href="../buttons.css" rel="stylesheet">
        <link href="../../css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <script src="../../js/jquery.js" type="text/javascript"></script>
        <style>
                body{
                    background-color: black;
                    min-height:800px;
                    padding: 0px;
                    margin: 0;
                    color: #fff;
                }
                form{
                    border: 1px solid #fff;
                    height: 88%;
                    margin-left: 25%;
                    padding: 15px;
                    width: 50%;
                }
                .error-message{
                    color: red;
                    float: right;
                    margin-bottom: 10px;
                    width: 250px;
                }
                .text-field{
                    padding-right: 10px;
                    text-align: left;
                }
                .text-left{
                    float: left;
                }
                .example-text{
                    text-align: right;
                    width: 370px;
                }
                .go-button{
                    float: right;
                }
                .go-button > input{
                    color: #000;
                }
                .admin_img {
                    color: #fff;
                    float: right;
                    padding-bottom: 10px;
                    padding-right: 20px;
                    padding-top: 10px;
                }
                .color-white{
                    color: #fff;
                    line-height: 15px;
                }
                input[type="text"] {
                    color: #000;
                    float: left;
                    width: 30%;
                    display: block;
                    margin-bottom: 10px;
                    background-color: wheat;
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
                .admin-payloads{
                    border-right: 1px solid #fff;
                    float: left;
                    min-height: 500px;
                    width: 50%;
                }
                .general-payloads{
                    float: right;
                    min-height: 400px;
                    width: 48%;
                }
                .payloads{
                    height: 700px;
                    width: 100%;
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
        </script>
    </head>
    <body class="main">
        <div class="color-white">
            <a class="play_img" href="<?php echo $protocol; ?>">
                <i class="mainNav fa fa-arrow-circle-left fa-3x"></i>
            </a>
        </div><br/><br/>
        <div id="container">
            <form method="post" name="form1" action="">
                <div class="payloads">
                    <div class="payload-details">
                        <h2>Payload Details</h2>
                    </div>
                    <div class="admin-payloads">
                        <div class="text-field">
                            <h2>Admin Payloads</h2><hr/>
                            <?php
                                listFolderFiles("admin","infect_admin","infect_admin_check");
                            ?>
                        </div>
                    </div>

                    <div class="general-payloads">
                        <div class="text-field">
                            <h2>General Payloads</h2><hr/>
                            <?php
                                listFolderFiles("payloads","infect_payloads","infect_payloads_check");
                            ?>
                        </div>
                    </div>
                    <div class="go-button">
                        <input type="submit" name="delete" id="delete" value="Delete">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>