<?php
if (@session_id() == "") @session_start();
$_SESSION['isLoggedIn'] = (isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == 1) ? 1 : 0;
if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] != 1)
{
    session_destroy();
    $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    $protocol .= "://" . $_SERVER['HTTP_HOST']."/admin";
    header("Location:".$protocol);
}
?>