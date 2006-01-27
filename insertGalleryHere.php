<?php
/*
	insertGalleryHere (IGH)
	This is Free.

	The purpose of this is to have a pluggable or standalone gallery
	with thumbnails and some light browsing.

	Portions by Niv Shah and Darryl Clarke
	http://darrylclarke.com/
	http://niv.elscorcho.org/

	requires: apache's mod_rewrite, php's mime-magic module
*/

/* insertGalleryHere.php is the _only_ entry point for this script 
	all other files will just die. */
require_once "src/variables.php";
require_once "src/functions.php";

/* Process $_GET['request'] */
list ($action, $param, $extra) = explode ("/", $_GET['request'], 3);

/* 4 output modes */
switch ($action) {
/* browser */
	/* uri: browse/dir/ */
	default:
	case "browse":
		require_once "src/class-folder.php";
	break;

/* single image */
	/* uri: view/imagename/ */
	case "view":
		require_once "src/class-image.php";
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
	print "<p>Embeded!</p>";
} else { // not embedded, standalone output.
	print "<p>Standalone!</p>";
}

/* end */
?>
