<?php 
require_once 'config.inc.php';

function pyrus_autoload($class)
{
    $class = str_replace('_', '\\', $class);
    include implode('/', explode('\\', $class)) . '.php';
    
}
spl_autoload_register("pyrus_autoload");
require_once 'PEAR2/Autoload.php';
require_once 'WebFrontend.php';
require_once 'Internet.php';
require_once 'Channel.php';
require_once 'OutputController.php';

OutputController::$template_path = dirname(__FILE__).'/www';
$channel = new Channel('channel.xml');
$webfrontend = new WebFrontend($channel, $_GET);

OutputController::display($webfrontend);

?>