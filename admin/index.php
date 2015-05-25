<?php
// Need to check if password has been set on the admin folder, if not then create it
// create a page of buttons for initial functions

$debug=1;
echo "<!DOCTYPE html><html><title>Admin Area</title></head><body>";
echo "<h1>Admin Area</h1>";
$currentFilePath = realpath(dirname(__FILE__));
$dir = new RecursiveDirectoryIterator($currentFilePath,FilesystemIterator::SKIP_DOTS );
foreach(new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::SELF_FIRST) as $file) {
	$filename= $file->getFilename();
	if (!is_dir($filename)) {
		if ($filename !="index.php") {
			$justname = substr($filename,0,-4);
			echo "<p><a href='$filename'>$justname</a></p>";	
		}
	} // end is dir

} // END foreach

echo "<hr></body></html>";

?>

