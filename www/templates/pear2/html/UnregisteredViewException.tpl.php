<?php

// Send 404 header
header('HTTP/1.0 404 Not Found');

// Set the page title
$parent->context->page_title = 'Page Not Found - '
    . PEAR2\SimpleChannelFrontend\Main::$title;

?>
<h1>WHOAH, Nelly.</h1>
<p>That view doesn't exist!</p>
