<?php
/*
	insertGalleryHere (IGH)
	This is Free.

	The purpose of this is to have a pluggable or standalone gallery
	with thumbnails and some light browsing.

	Portions by Niv Shah, reworked by Darryl Clarke
	http://niv.elscorcho.org/	http://darrylclarke.com/

	requires: apache's mod_rewrite, php's mime-magic module

 	insertGalleryHere.php is the _only_ entry point for this 
	script all other files will just die. 				
*/

require_once "src/variables.php";
require_once "src/functions.php";

/* Process $_GET['ighRequest'] */
if ($_GET['ighRequest'] == "browse") {
	$action = "browse"; 
	$param = "";
} else  {
	list ($action, $param, $extra) = explode ("/", $_GET['ighRequest'], 3);
}

/* 4 output modes */
switch ($action) {
/* browser */
	/* uri: browse/dir/ */
	default:
	case "browse":
		require_once "src/class-folder.php";
		$Folders = new Folders($param, $ighLocalImages);

		$ighFolders = $Folders->listFolders();
		$ighThumbs = $Folders->listThumbs();

		/* browse wants $ighFolders, $ighThumbs */
		require_once "template/browse.tpl";
		$ighBody .= $browse;
	break;

/* single image */
	/* uri: view/imagename/ */
	case "view":
		require_once "src/class-image.php";

		require_once "template/view.tpl";
		$ighBody .= $view;
	break;

/* thumbnail image */
	/* uri: thumbnail/imagename/ */
	case "thumbnail":
	break;

/* the actual image */
	/* uri: image/filename.jpg/gif/png */
	case "image":
	break;

}
/* Final output */
if ($insertGalleryHereEmbed) { // wrap up the output if we're not embedded
	$ighOutput = $ighBody;
} else { // not embedded, standalone output.
	require_once "template/wrapper.tpl";
	$ighOutput = $body;
}

/* Spew! Thats it. */
print $ighOutput;
/* end */
?>
