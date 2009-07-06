<?php 
require_once 'config.inc.php';
require_once 'WebFrontend.php';
require_once 'Channel.php';
require_once 'OutputController.php';

OutputController::$template_path = dirname(__FILE__).'/www';
$channel = new Channel('channel.xml');
$webfrontend = new WebFrontend($channel, $_GET);

OutputController::display($webfrontend);

?>