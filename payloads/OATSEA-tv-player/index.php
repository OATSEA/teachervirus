<?php


// Start output buffering
ob_start();
// run code in x.php file
// ...
// saving captured output to file


$temp ="";
$mp4=".mp4";
$jpg=".jpg";
$png=".png";
$defaultNav="defaultnav.jpg";
$defaultNavJPG="nav.jpg";
$defaultNavPNG="nav.png";
$folderNav="nav.jpg";
$loopCount=0;
$baseFolder="movies";
$folderName="movies";
$navHTML="";
$thumbsHTML="";
$movieHTML="";
$scriptDir = dirname($_SERVER['SCRIPT_NAME']);
$fullPathPrefix = $_SERVER['DOCUMENT_ROOT'];

if (isset($_GET["folder"])&& !empty($_GET["folder"])) {$folderName=$_GET["folder"];}
// echo "FolderName: ".$folderName;
  $folderName = str_replace($scriptDir."/", '', $folderName);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $folderName; ?></title>
	<link href="movies.css" rel="stylesheet">
	<link href="css/font-awesome.min.css" rel="stylesheet">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <script src="jquery.js"></script>
	<script src='jquery.imagefit.js'></script>
    <script src="movies.js"></script>
	<script>$(document).ready(function() { setup(); }); </script>	
</head>
<body class="main">

	  <div id="menubar">
		  <div id="lefticon" onTouchStart="history.go(-1)" onClick="history.go(-1)"><i class="mainNav fa fa-arrow-circle-left fa-3x"></i></div>
	      <div id="moviecat"><?php echo $folderName; ?></div>
		  <div id="righticon" onTouchStart="toggleView();" onClick="toggleView();"><i class="mainNav fa fa-cog fa-3x"></i></div>
	  </div>
<hr>
	  
<?php

$rootFolder = preg_replace( '~(\w)$~' , '$1' . DIRECTORY_SEPARATOR , realpath( getcwd() ) );
$navCount=0;

$moviesDir = str_replace("payloads/OATSEA-tv-player", 'content', $rootFolder);

$all="'All'";
			echo '<img class="mybutton" id="All_nav" alt="All" src="icons.png" onTouchStart="location.reload();" onclick="location.reload();" />';	
$navdir = new RecursiveDirectoryIterator( $moviesDir.$folderName,FilesystemIterator::SKIP_DOTS );
foreach(new RecursiveIteratorIterator($navdir,RecursiveIteratorIterator::SELF_FIRST) as $file) {

	$filename= $file->getFilename();
	$itemUrl = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
	$checkApple = strpos($itemUrl,".Apple");
	$currentFolder = str_replace($filename, '', $itemUrl);
	$title = $filename;
	$displayTitle = str_replace("-", ' ', $title);
	
	if (($file->isDir())&&(substr( $filename ,0,1) != ".")&&($checkApple===false)) {
			// If it's a directory build navigation for it
			
			$thisDir=$currentFolder.$filename;
			$thisFullPath=$fullPathPrefix.$thisDir;
			
			// If there's no thumbnail for this directory use default one
			if (file_exists($thisFullPath."/".$defaultNavJPG)) {
				$thisFolderNav=$thisDir."/".$defaultNavJPG;
			} else if (file_exists($thisFullPath."/".$defaultNavPNG)) {
				$thisFolderNav=$thisDir."/".$defaultNavPNG;
			} else {
				$thisFolderNav=$defaultNav;
			}
			
			$catID="'".$title."'";

			echo '<img class="mybutton" id="'.$title.'_nav" alt="'.$title.'" src="'.$thisFolderNav.'" onTouchStart="catToggle('.$catID.')" onclick="catToggle('.$catID.')" />
			';	
			$navCount++;
	} // END if
} // END foreach		
		
if ($navCount!=0) {echo "<hr>";}

// MAIN LOOP

echo "<div id='maincontent'/>";
// if ($folderName!="Movies") {
$dir = new RecursiveDirectoryIterator( $moviesDir.$folderName,FilesystemIterator::SKIP_DOTS );
foreach(new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::SELF_FIRST) as $file) {

 	$filename= $file->getFilename(); 
	// echo "<p>File: ".$filename."</p>";
	// $filePath= 
	// echo "filename:".$filename."</p>";

	$title = substr( $filename ,0,strlen($filename)-4);
	$displayTitle = str_replace("-", ' ', $title);
	$displayTitle = str_replace(".", ' ', $displayTitle);
	$displayTitle = str_replace("_", ' ', $displayTitle);		
	
	$titleLen=8;
	if (strlen($title)<=8) { $titleLen=strlen($title);}
	$shortTitle = substr( $title ,0,$titleLen);
    $itemID="'".$title."'";
	$itemUrl = str_replace($_SERVER['DOCUMENT_ROOT'], '', $file);
	
	$checkApple = strpos($itemUrl,".Apple");
	$currentFolder = str_replace($filename, '', $itemUrl);
	
	
	// check isn't a .dot or an .Apple item
	if ((substr( $filename ,0,1) != ".")&&($checkApple===false)) {
		
		// Is it a movie file or directory?
		if ($file->Isfile()  && (substr( $filename,-4) == ".mp4")) {
						
						
						
			$tags = str_replace($scriptDir."/".$baseFolder,"",$currentFolder);
			$tags = str_replace("/"," ",$tags);
			// echo $tags."<br>";
			$imageURLJPG=$currentFolder.$title.$jpg;
			$imageURLPNG=$currentFolder.$title.$png;
			$imageURLdefaultJPG=$currentFolder.$defaultNavJPG;
			$imageURLdefaultPNG=$currentFolder.$defaultNavPNG;
			
			$thisFullImagePathJPG=$fullPathPrefix.$imageURLJPG;
			$thisFullImagePathPNG=$fullPathPrefix.$imageURLPNG;
			$thisFullImagePathDefaultJPG=$fullPathPrefix.$imageURLdefaultJPG;
			$thisFullImagePathDefaultPNG=$fullPathPrefix.$imageURLdefaultPNG;					
						
			// If there's no thumbnail for this movie use either the default one in this folder or if that doesn't exist the default one

				if(file_exists($thisFullImagePathJPG)) { 
					$imageURL=$imageURLJPG;
				}   else if(file_exists($thisFullImagePathPNG)){
					$imageURL=$imageURLPNG;
				} else if(file_exists($thisFullImagePathDefaultJPG)){ 
					$imageURL=$imageURLdefaultJPG;
					
				} else if(file_exists($thisFullImagePathDefaultPNG)){
					$imageURL=$imageURLdefaultPNG;
				} else {
					$imageURL=$defaultNav;
				} // END thumbs image exists test
				
			$iconID=$title."_icon";		
		    echo '<div class="myfig'.$tags.'"><img onClick="playvid('.$itemID.');" class="videoicon" id="'.$iconID.'" width="320" height="240" src="'.$imageURL.'" /><p class="imgtitle">'.$displayTitle.'</p>';
			
		    echo '<video onClick="playvid('.$itemID.');" class="videoclip" id="'.$title.'" width="1" height="1" controls preload="none" onended="videoEnded('.$itemID.')">
			  <source src="'.$itemUrl.'" type="video/mp4"> 
				  Your browser does not support the video tag.
			  </video> </div>
		  ' ;
		} 
		} // END if is not apple
    } // END foreach
echo "<hr>";
// } // end "Movies" foldername check 
?>
</div>
    
	<div id="overlay" class="hideMe" onClick="doBack()" onTouchStart="doBack()"><i class="videoBack fa fa-arrow-circle-left fa-5x"></i></div>
<div id="update"><center><a href="index.php">Update</a></center><br><br></div>	  	
</body>
</html>
<?php
file_put_contents('index.html', ob_get_contents());
// end buffering and displaying page
ob_end_flush();

?>