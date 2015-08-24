<?php
    require_once("../../data/constants.php");
    require(ROOT_DIR.'/admin/checkLogin.php');
    
    $_SESSION['isValidation']['flag'] = TRUE;
    if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_SESSION['isValidation']))
    {
        if(empty($_POST['folder_val']))
        {
            $_SESSION['isValidation']['folder_val'] = 'Please select payload type!!';
            $_SESSION['isValidation']['flag'] = FALSE;
        }
    }
    function listFolderFiles($dir,$sSelectedVal)
    {
        $sNewDirPath = ROOT_DIR.'/'.$dir;
        $ffs = array();
        if(is_dir($sNewDirPath))
        $ffs = scandir($sNewDirPath);
        $nHiddenCnt = 0;
        foreach($ffs as $ff)
        {
                if(is_dir($sNewDirPath.'/'.$ff) && $ff != '.' && $ff != '..')
                {
        ?>
                    <option value="<?php echo $ff ?>" <?php echo ($sSelectedVal == $ff) ? "selected='selected'"  : "" ; ?>><?php echo $ff ?></option>

        <?php
                }
        }
    }
    if($_SESSION['isValidation']['flag'] == 1)
        unset($_SESSION['isValidation']['folder_name'],$_SESSION['isValidation']['folder_val']);
    
    $sFolderName = $_POST['folder_name'];
?>
<div class="col-sm-12">
    <select name="install_source" id="install_source" class="col-sm-3 form-control extra" onchange="showFolderOption(this);">
        <option value="new_folder" <?php ($_POST['selected_val'] == 'new_folder') ? "selected='selected'" : ""; ?>>New</option>
        <?php
            listFolderFiles($sFolderName,$_POST['selected_val']);
        ?>
    </select>
</div>
<div class="col-sm-12">
    <div id="new_folder" style="<?php //echo (isset($_SESSION['isValidation']['folder_name']) && $_POST['selected_val'] == "new_folder") ? 'display:block' : 'display:none'; ?>">
        <div class="col-sm-12">
            <label>Folder Name:</label>
        </div>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="new_folder" value="<?php echo $_POST['folder_val']; ?>">
        </div>
        <div class="error-message">
            <?php //echo isset($_SESSION['isValidation']['folder_val']) ? $_SESSION['isValidation']['folder_val'] : '';?>
        </div>
    </div>
</div>