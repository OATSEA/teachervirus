<?php
    session_start();
    // Unset all of the session variables.
    session_unset();
    session_destroy();
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST'];
    header("Location:".$protocol.'/play/');
?>