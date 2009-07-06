<!DOCTYPE HTML>
<html>
<head>
<title>PEAR2</title>
<link rel="stylesheet" href="www/css/all.css" type="text/css">
</head>
<body>
<div id="header">
	<a href="." class="logo"><img alt="pear2/pyrus" src="www/images/logo.png"></a>
	<h1>PEAR2</h1>
	<ul>
		<li><a href=".">Home</a></li>
		<li><a href="?view=packages">Packages</a></li>
		<li><a href="./bugs/">Bugs</a></li>
	</ul>
</div>
<div id="maincontent">
	<?php
	OutputController::display($this->page_content);
	?>
</div>
</body>
</html>