<?php
require_once '../config.inc.php';

$bugmanager = new \pear2\BugManager\Main();

OutputController::$template_path = dirname(dirname(__FILE__)).'/www';
OutputController::display($bugmanager);

?>