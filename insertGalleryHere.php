<?php
/*
	insertGalleryHere (IGH)
	This is Free.  If you like it, say thanks.

	The purpose of this is to have a pluggable or standalone gallery
	with thumbnails and some light browsing.

	Portions by Niv Shah, reworked by Darryl Clarke
	http://niv.elscorcho.org/	http://darrylclarke.com/

	requires: php5, apache's mod_rewrite, php's mime-magic module

 	insertGalleryHere.php is the _only_ entry point for this 
	script all other files will just die.
*/

/* Required sources */
require_once "src/ighVariables.php";
require_once "src/ighFunctions.php";
/* My Classes */
require_once "src/class-ighFolder.php";
require_once "src/class-ighImage.php";

/* Process $_GET['ighRequest'] */
if ($_GET['ighRequest'] == "") {
	$action = "browse"; 
	$param = "_";
} else  {
	list ($action, $param, $fullfilepath) = explode ("/", $_GET['ighRequest'], 3);
}

if ($param == "")
	$param = "_";
	
if ($action == "thumbnail" || $action == "image") {
	$headers = apache_request_headers();
	if ($headers['If-Modified-Since'] == "") // set this date in the past to force reloads properly
		$headers['If-Modified-Since'] = gmdate("D, d M Y H:i:s", 0) . " GMT";

	$filename = $ighLocalImages . $fullfilepath;
	$thumb = $ighCacheThumbs . md5($filename);
	$resize = $ighCacheResize . md5($filename);
	$filetype = mime_content_type($filename);

	$Image = new Image($ighLocalImages, $fullfilepath, $param);
}

/* 4 output modes */
switch ($action) {
/* browser */
	/* uri: browse/[PAGE#|_]/dir/ */
	default:
	case "browse":
		$Folders = new Folders($fullfilepath, $ighLocalImages, $param);

		$ighFolders = $Folders->listFolders();
		$ighThumbs = $Folders->listThumbs();
		$ighCrumbs = $Folders->listCrumbs();

		/* browse wants $ighFolders, $ighThumbs */
		require_once "template/ighBrowse.tpl";
		$ighBody .= $browse;
	break;

/* single image */
	/* uri: view/[_|fullsize]/imagename/ */
	case "view":
		$Image = new Image($ighLocalImages, $fullfilepath, $param);

		$ighImage_next = $Image->getNextImageHTML();
		$ighImage_full = $Image->getImageHTML();
		$ighImage_prev = $Image->getPrevImageHTML();
		$ighFolders = $Image->listFolders();
		$ighCrumbs = $Image->listCrumbs();
		require_once "template/ighView.tpl";
		$ighBody .= $view;
	break;

/* thumbnail image */
	/* uri: thumbnail/_/imagename/ */
	case "thumbnail":
		if (dateCompare(strtotime($headers['If-Modified-Since']), filemtime($thumb))) {
			header("Last-Modified: " . gmdate("D, d M Y H:i:s", filemtime($thumb)) . " GMT");
			header("Content-Type: image/png");
			header("Content-Length: " . filesize($thumb));
			$fp = fopen($thumb, "rb");
			fpassthru($fp);
			fclose($fp);
		} else {
			header("HTTP/1.0 304 Not Modified");
		}
		exit();
	break;

/* the actual image */
	/* uri: image/[_|fullsize]/filename.jpg/gif/png */
	case "image":
		if (dateCompare(strtotime($headers['If-Modified-Since']), filemtime($filename))) {
			// Check for Resizing
			if ($Image->imageWidth > $ighMaxWidth || $Image->imageHeight > $ighMaxHeight)
			{ // change the filename to the resized version
				$filename = $resize;
			}
			header("Last-Modified: " . gmdate("D, d M Y H:i:s", filemtime($filename)) . " GMT");
			header("Content-Type: " . $filetype);
			header("Content-Length: " . filesize($filename));
			$fp = fopen($filename, "rb");
			fpassthru($fp);
			fclose($fp);
		} else {
			header("HTTP/1.0 304 Not Modified");
		}
		exit();
	break;

}
/* Final output */
if ($insertGalleryHereEmbed) { // wrap up the output if we're not embedded
	$ighOutput = $ighBody;
} else { // not embedded, standalone output.
	require_once "template/ighWrapper.tpl";
	$ighOutput = $body;
}

/* Spew! Thats it. */
print $ighOutput;
/* end */
?>
