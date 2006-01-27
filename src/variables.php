<?php
/*
	variables.php
	a list of variables, sheesh.
*/

/* funcationality variables */
$ighVersion = "0.1";

// Where's the images (include trailing / on all paths)?
$ighLocalImages = "/var/www/x/igh/photos/";
$ighWebUrl = "images/";
// This must be writable by your web server.
$ighCacheThumbs = "/var/www/x/igh/cache/thumb/";
$ighCacheResize = "/var/www/x/igh/cache/resize/";

// Thumbnail stuff
$ighThumbWidth 	= "120";
$ighThumbHeight	= "90";

// Resize stuff
$ighMaxWidth 	= "600";
$ighMaxHeight 	= "400";

// this can be any url; if you are embedding set it to where it's embedded.
$ighHome = "/"; 
/* this is where everything is processed (embedded or not)
	if you do not have mod_rewrite in use set it to the full location. */
if ($insertGalleryHereEmbed) {
	// no mod_rewrite if we're embeded! (yet)
	// TODO: preserve an existing QUERY_STRING
	$ighBrowse 	= "?ighRequest=browse/";
	$ighView 	= "?ighRequest=view/";
	$ighImage 	= "/insertGalleryHere.php?ighRequest=image/";
	$ighThumb 	= "/insertGalleryHere.php?ighRequest=thumbnail/";
} else {  // standalone operation...
	/* not using mod_rewrite: */
	/* -- copy from above -- :) */
	/* using mod_rewrite: */
	$ighBrowse	= "/gallery/browse/";
	$ighView 	= "/gallery/view/";
	$ighImage 	= "/gallery/image/";
	$ighThumb 	= "/gallery/thumbnail/";
}

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
