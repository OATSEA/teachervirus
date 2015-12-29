<?php
if(isset($_POST['dir_name']) && is_dir($_POST['dir_name']))
{
    if(file_exists($_POST['dir_name'].'/list.txt'))
    {
        $aExplodeFiles = explode(";", file_get_contents($_POST['dir_name'].'/list.txt'));
    }
}
if(!empty($aExplodeFiles))
{
?>
    <form name="payload_details_update" id="payload_details_update" method="POST" action="update.php" enctype="multipart/form-data">
        <div class="col-sm-12 title">
            <h2>Update Payload</h2>
        </div>
        <label class="start_payload"><input type="checkbox" name="check_admin" id="check_admin" value="<?php echo ($aExplodeFiles[1] == 'A') ? 1 : 0; ?>" <?php echo ($aExplodeFiles[1] == 'A') ? "checked='checked'" : ""; ?> onclick="changeValue();"/> Is this an Admin Payload ?  
        </label>
        <div><label class="col-sm-12 extra">
            <input type="radio" name="payload_source" id="ckeck_github" value="github_payloads" <?php echo ($aExplodeFiles[0] == "github_payloads") ? "checked='checked'" : ""; ?> onclick="showData('github_payloads');"> GitHub
            </label></div>
            <div id="github_payloads" style="<?php echo ($aExplodeFiles[0] == "github_payloads") ? "display:block" : "display:none"; ?>" class="sources">
                <div class="form-group">
                   <label class="col-sm-12 control-label">GitHub Username<font style="color:red">*</font> </label>
                   <div class="col-sm-12">
                    <input type="text" class="form-control" name="user_name" value="<?php echo ($aExplodeFiles[0] == "github_payloads") ? $aExplodeFiles[2] : ''; ?>">
                    <div class="error-message">
                    <?php echo isset($_SESSION['isValidation']['user_name_required']) ? $_SESSION['isValidation']['user_name_required'] : '';?>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-12 control-label">GitHub Repository<font style="color:red">*</font> </label>
                    <div class="col-sm-12">
                <input type="text" class="form-control" name="repository" value="<?php echo ($aExplodeFiles[0] == "github_payloads") ? $aExplodeFiles[3] : ''; ?>">
                <div class="error-message">
                    <?php echo isset($_SESSION['isValidation']['repository_required']) ? $_SESSION['isValidation']['repository_required'] : '';?>
                </div>
                </div>
                </div>
                
            </div>
            <label class="col-sm-12 control-label extra">
            <input type="radio" name="payload_source" id="ckeck_infected" value="infected_device" <?php echo ($aExplodeFiles[0] == "infected_device") ? "checked='checked'" : ""; ?> onclick="showData('infected_device');"> Infected Device
            </label>
            <div id="infected_device" style="<?php echo ($aExplodeFiles[0] == "infected_device") ? "display:block" : "display:none"; ?>" class="sources">
                <div class="form-group">
                    <label class="col-sm-12 control-label">Device Address (IP or URL)<font style="color:red">*</font> </label>
                    <div class="col-sm-12">
                <input type="text" class="form-control" name="device_address" value="<?php echo ($aExplodeFiles[0] == "infected_device") ? $aExplodeFiles[2] : ''; ?>">
                <div class="error-message">
                    <?php echo isset($_SESSION['isValidation']['device_address']) ? $_SESSION['isValidation']['device_address'] : '';?>
                </div><br/><br/>
                </div>
                </div>
                <div class="col-sm-12 example">Provide an IP or URL - For Example: 192.168.143.1 or demo.teachervirus.org</div>
                <div class="form-group">
                <label class="col-sm-12 control-label">Port</label>
                <div class="col-sm-12">
                <input type="text" class="form-control" name="port_number" id="port_number" value="<?php echo ($aExplodeFiles[0] == "infected_device") ? $aExplodeFiles[3] : ''; ?>">
                &nbsp;&nbsp;&nbsp;<a href="javascript:void(0);" onclick="removePort();"><i class="fa fa-times"></i></a>
                </div>
                </div>
                <div class="form-group">
                <label class="col-sm-12 control-label">Folder/Payload Name<font style="color:red">*</font></label>
                <div class="col-sm-12">
                <input type="text" class="form-control" name="infect_user_name" value="<?php echo ($aExplodeFiles[0] == "infected_device") ? $aExplodeFiles[4] : ''; ?>">
                <div id="infect_user_input" class="error-message">
                    <?php echo isset($_SESSION['isValidation']['infect_user_name']) ? $_SESSION['isValidation']['infect_user_name'] : '';?>
                </div>
                </div>
                </div>
        </div>
        <label class="col-sm-12 control-label extra">
           <input type="radio" name="payload_source" id="ckeck_website" value="website_url" <?php echo ($aExplodeFiles[0] == "website_url") ? "checked='checked'" : ""; ?> onclick="showData('website_url');"> URL/Website
        </label> 
            <div id="website_url" style="<?php echo ($aExplodeFiles[0] == "website_url") ? "display:block" : "display:none"; ?>" class="sources">
                 <div class="form-group">
                <label class="col-sm-12 control-label">Payload Name <font style="color:red">*</font></label>
                <div class="col-sm-12">
                <input type="text" class="form-control" name="payload_name" value="<?php echo ($aExplodeFiles[0] == "website_url") ? $aExplodeFiles[2] : ''; ?>">
                <div class="error-message">
                    <?php echo isset($_SESSION['isValidation']['payload_name']) ? $_SESSION['isValidation']['payload_name'] : '';?>
                </div>
                </div>
                 </div>
                <div class="form-group">
                <label class="col-sm-12 control-label">URL <font style="color:red">*</font></label>
                <div class="col-sm-12">
                <input type="text" class="form-control" name="payload_url" value="<?php echo ($aExplodeFiles[0] == "website_url") ? $aExplodeFiles[3] : ''; ?>">
                <div id="url_input" class="error-message">
                    <?php echo isset($_SESSION['isValidation']['payload_url']) ? $_SESSION['isValidation']['payload_url'] : '';?>
                </div>
                </div></div>
                
            </div>
             <label class="col-sm-12 control-label extra">
            <input type="radio" name="payload_source" id="ckeck_google" value="google_drive" <?php echo ($aExplodeFiles[0] == "google_drive") ? "checked='checked'" : ""; ?> onclick="showData('google_drive');"> Google Drive
             </label>
            <div id="google_drive" style="<?php echo ($aExplodeFiles[0] == "google_drive") ? "display:block" : "display:none"; ?>" class="sources">
                <div class="form-group">
                <label class="col-sm-12 control-label">Payload Name <font style="color:red">*</font></label>
                <div class="col-sm-12">
                <input type="text" class="form-control" name="google_payload_name" value="<?php echo ($aExplodeFiles[0] == "google_drive") ? $aExplodeFiles[2] : ''; ?>">
                <div class="error-message">
                    <?php echo isset($_SESSION['isValidation']['google_payload_name']) ? $_SESSION['isValidation']['google_payload_name'] : '';?>
                </div>
                </div>
                </div>
                <div class="form-group">
                <label class="col-sm-12 control-label">Google Drive Link<font style="color:red">*</font> </label>  
                <div class="col-sm-12">
                <input type="text" class="form-control" name="google_drive_link" value="<?php echo ($aExplodeFiles[0] == "google_drive") ? $aExplodeFiles[3] : ''; ?>">
                <div id="url_input" class="error-message">
                    <?php echo isset($_SESSION['isValidation']['google_drive_link']) ? $_SESSION['isValidation']['google_drive_link'] : '';?>
                </div><br/><br/>
                </div>
                </div>
                <div class="col-sm-12 example1">Note: Provide the Google Drive Link obtained from "get link" option in Drive.</div>
            </div>
                    <label class="col-sm-12 control-label extra">
                        <input type="radio"  name="payload_source" value="file_browse" <?php echo (isset($_POST['payload_source']) && $_POST['payload_source'] == "file_browse" ) ? "checked='checked'" : ""; ?> onclick="showData('file_browse');"> File Upload
                    </label>
                    <div id="file_browse" style="display:none;" class="sources">
                        <div class="col-sm-12">
                            <input type="file" name="upload_file" value="<?php echo ($aExplodeFiles[0] == "Browse") ? $aExplodeFiles[3] : ''; ?>">
                            <div class="error-message">
                                <?php echo isset($_SESSION['isValidation']['upload_file']) ? $_SESSION['isValidation']['upload_file'] : '';?>
                            </div>
                        </div>
                    </div>
        <div><label class="start_payload"><input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($_POST['show_debug']) ? $_POST['show_debug'] : '0'; ?>" <?php echo isset($_POST['show_debug']) ? "checked='checked'" : ""; ?> onClick="changeValue('show_debug');">  Show debug text</label></div>
                <div><label class="start_payload"><input type="checkbox" name="show_debug" id="show_debug" value="<?php echo isset($_POST['show_debug']) ? $_POST['show_debug'] : '0'; ?>" <?php echo isset($_POST['show_debug']) ? "checked='checked'" : ""; ?> onClick="changeValue('show_debug');">  Chmod?</label>
                </div>
                <label class="col-sm-12"><font style="color:red">*</font> Indicates mandatory field</label>
        <div class="go-button btn btn-lg btn-primary">
            <input type="submit" name="update" id="update" value="Update">
        </div>
    </form>
<?php 
}
?>
