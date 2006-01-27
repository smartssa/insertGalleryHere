<?php
/*
	variables.php
	a list of variables, sheesh.
*/

/* funcationality variables */
$ighVersion = "0.1";
$ighCache = "cache/";
$ighWebUrl = "images/";

// this can be any url; if you are embedding set it to where it's embedded.
$ighHome = "/"; 
// this is where everything is processed (embedded or not)
// if you do not have mod_rewrite in use set it to the full location
// $ighLanding = "/insertGalleryHere.php?request="
$ighLanding = "/gallery/";

/* output variables (for standalone) */
$ighPageTitle = "My insertGalleryHere!";
$ighPageFooter = "&copy; copyright " . date("Y") . " unconfigured ighOwner. Powered by insertGalleryHere ". $ighVersion ."! ";
$ighPageHeader = "myStandAloneIGH";

?>
