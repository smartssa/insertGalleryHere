<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<style type="text/css" title="Colours" media="all">
	@import "master.css";
</style>
<title>IGH Embedded Sample</title>
</head>
<body>
<div id="masthead">
	<p>Super Duper Header</p>
</div>
<div id="container">
	<div id="leftbox">
		<p class="center">
			Menu Stuff<br/>
		</p>
	</div>
	<div id="rightbox">
		<h1>My Uber Gallery (<a href="/gallery/">Standalone</a>)</h1>
<?php
/* Demo for Wrapper/3rd Party include */

$insertGalleryHereEmbed = TRUE;
require_once "insertGalleryHere.php";

?>

	</div>
</div>
<div id="footer">
	<p>Footer... Hosted by <a href="http://www.flatlinesystems.net/">Flatline 
Systems</a></p> 
</div>
</body>
</html>
