<?php
/*
	variables.php
	a list of variables, sheesh.
*/

/* funcationality variables */
$ighVersion = "0.2";

// Where's the images (include trailing / on all paths)?
$ighLocalImages = "/var/www/x/igh/photos/";

// page limit, # of images per page in browse mode
$ighPageLimit = "36";

// This must be writable by your web server.
$ighCacheThumbs = "/var/www/x/igh/cache/thumbs/";
$ighCacheResize = "/var/www/x/igh/cache/resize/";

// Thumbnail stuff -- these are boundaries
$ighThumbWidth 	= "120";
$ighThumbHeight	= "120";

// Resize stuff -- these are boundaries, they will be resized/scalled according to their original aspect.
$ighMaxWidth 	= "600";
$ighMaxHeight 	= "800";

// this can be any url; if you are embedding set it to where it's embedded.
$ighHome = "/"; 
/* this is where everything is processed (embedded or not)
	if you do not have mod_rewrite in use set it to the full location. */
// no mod_rewrite if we're embeded! (yet)
// TODO: preserve an existing QUERY_STRING
$ighBrowse 	= "?ighRequest=browse/";
$ighView 	= "?ighRequest=view/";
$ighImage 	= "/insertGalleryHere.php?ighRequest=image/";
$ighThumb 	= "/insertGalleryHere.php?ighRequest=thumbnail/";
/* not using mod_rewrite: */
/* -- copy from above -- :) */
/* using mod_rewrite:
	$ighBrowse	= "/gallery/browse/";
	$ighView 	= "/gallery/view/";
	$ighImage 	= "/gallery/image/";
	$ighThumb 	= "/gallery/thumbnail/";
*/

/* output variables (for standalone) */
$ighPageTitle = "My insertGalleryHere!";
$ighPageFooter = "&copy; copyright " . date("Y") . " unconfigured ighOwner. Powered by insertGalleryHere ". $ighVersion ."! ";
$ighPageHeader = "myStandAloneIGH";

/* custom css file:
	this file must contain the following classes:
	ighThumb 	- thumbnails
	ighImage	- full images
	ighDirectory	- directory listing */
$ighCSS = "@import \"/ighCSS.css\";";

?>
