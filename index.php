<?php 
require_once 'config.inc.php';

$channel = new Channel('channel.xml');
$webfrontend = new WebFrontend($channel, $_GET);

$savant = new \pear2\Templates\Savant\Main();
$savant->setTemplatePath(array(__DIR__ . '/www'));
echo $savant->render($webfrontend);


?>