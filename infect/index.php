<?php
// provide an index of files available for download
// getinfected.php, tv-android, DroidPHP.apk
$debug=1;
echo "<h1>Infectious Files Include:</h1";
$currentFilePath = realpath(dirname(__FILE__));
$dir = new RecursiveDirectoryIterator($currentFilePath,FilesystemIterator::SKIP_DOTS );

foreach(new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::SELF_FIRST) as $file) {

	$filename= $file->getFilename();
	
	if (($file->isDir())&&(substr( $filename ,0,1) != ".")) {
		// Is a directory:
    		echo "<p>".realpath($file)."</p>";
	} else {
		// Is a file
		echo "<p>".realpath($file)."</p>";
  }// END is Dir or File checks
    
} // END foreach

?>
