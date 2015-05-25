<?php
// Need to check if password has been set on the admin folder, if not then create it
// create a page of buttons for initial functions

$debug=1;
echo "<h1>Admin Area</h1>";
$currentFilePath = realpath(dirname(__FILE__));
$dir = new RecursiveDirectoryIterator($currentFilePath,FilesystemIterator::SKIP_DOTS );
foreach(new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::SELF_FIRST) as $file) {
	$filename= $file->getFilename();
	if ($filename !="index.php") {
	  $justname = substr($filename,0,-3);
		echo "<p><a href='$filename'>$justname</a></p>";	
	}
} // END foreach

?>

