<?php
    require_once("../data/constants.php");
    session_start();
    session_destroy();
    header("Location:".SITE_URL.'/play');
?>