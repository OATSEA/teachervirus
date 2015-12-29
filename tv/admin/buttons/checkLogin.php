<?php
    if (@session_id() == "") @session_start();
    $_SESSION['isLoggedIn'] = (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1) ? 1 : 0;
    
    if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] != 1)
    {
        session_destroy();
        header("Location:".$sSiteUrl."/tv/admin/buttons");
    }
?>