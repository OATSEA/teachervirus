<?php
    require_once("../../data/constants.php");
    $protocol = SITE_URL."/getinfected.php?isValidUser=true";
    header("Location: $protocol");