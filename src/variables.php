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
$ighCache = "cache/";

// this can be any url; if you are embedding set it to where it's embedded.
$ighHome = "/"; 
/* this is where everything is processed (embedded or not)
	if you do not have mod_rewrite in use set it to the full location. */
/* using mod_rewrite: */
$ighLanding = "/gallery/";
/* not using mod_rewrite: */
// $ighLanding = "/insertGalleryHere.php?request="

/* output variables (for standalone) */
$ighPageTitle = "My insertGalleryHere!";
$ighPageFooter = "&copy; copyright " . date("Y") . " unconfigured ighOwner. Powered by insertGalleryHere ". $ighVersion ."! ";
$ighPageHeader = "myStandAloneIGH";

/* custom css file:
	this file must contain the following classes:
	ighThumb 	- thumbnails
	ighImage	- full images
	ighDirectory	- directory listing */
// $ighCustomCSS = "myCSS.css";

?>
