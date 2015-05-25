<?php
// provide an index of files available for download
// getinfected.php, tv-android, DroidPHP.apk
$debug=1;
echo "<h1>Infectious Files Include:</h1>";
$currentFilePath = realpath(dirname(__FILE__));
$dir = new RecursiveDirectoryIterator($currentFilePath,FilesystemIterator::SKIP_DOTS );

foreach(new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::SELF_FIRST) as $file) {
	$filename= $file->getFilename();
	if ($filename !="index.php") {
		echo "<p>$filename</p>";	
	}
} // END foreach

?>
