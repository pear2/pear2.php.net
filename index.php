<?php 
require_once 'config.inc.php';

OutputController::$template_path = dirname(__FILE__).'/www';
$channel = new Channel('channel.xml');
$webfrontend = new WebFrontend($channel, $_GET);

OutputController::display($webfrontend);

?>