<!DOCTYPE html>
<html>
<head>
<title>Icons Menu</title>
<link href="buttons.css" rel="stylesheet">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<script src="../js/jquery.js"></script>
<script src='../js/jquery.imagefit.js'></script>
<script src="buttons.js"></script>
<script>$(document).ready(function() { setup(); }); </script>
</head>
<body class="main" >
<br><br>	  
<?php
 
$rootdir = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) )."*";
// echo $rootdir."<br>";

$thisURL = $_SERVER['REQUEST_URI'];
$playURL =  str_replace('admin', 'play', $thisURL);
   
foreach(glob($rootdir, GLOB_ONLYDIR) as $dir) { 
	$dir = basename($dir); 
	$imgText = $dir."/icon.png";
	$imgTest = file_exists( $imgText);
	if ($imgTest) {
		echo '<a href="'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="'.$imgText.'" /></a>';
		// <span class="pluscap"><br>'.$dir.'</span>
    } else {
        // Icon provided so use the default
        echo '<a href="'.$dir.'"><img class="mybutton" alt="'.$dir.'" src="default.png" /></a>';
    }
} 

echo '<a href="'.$playURL.'"><img class="mybutton" alt="Play" src="'.$playURL.'icon.png" /></a>';

?>
</table>
</body>
</html>

