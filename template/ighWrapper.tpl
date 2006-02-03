<?php
$body = <<< EOT
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<style type="text/css" title="Colours" media="all">
	{$ighCSS}
</style>
<title>{$ighPageTitle}</title>
</head>
<body>
<div id="masthead">
	<p>{$ighPageHeader}</p>
</div>
<div id="container">
	<div id="rightbox">
		{$ighBody}
	</div>
</div>
<div id="footer">
<p>{$ighPageFooter}</p>
</div>
</body>
</html>

EOT;
?>
