<?php
/**
 * This is a sample configuration file for PEAR2_SimpleChannelFrontend
 * 
 * Be sure to set up the $channel object to the appropriate channel.
 */
require_once __DIR__ . '/../../PEAR2/autoload.php';

ini_set('display_errors', true);
error_reporting(E_ALL);

set_include_path(dirname(__DIR__).'/src');

function pyrus_autoload($class)
{
    $class = str_replace(array('pear2\\', '_'), array('', '\\'), $class);
    include implode('/', explode('\\', $class)) . '.php';
    
}
spl_autoload_register("pyrus_autoload");

/**
 * An example of setting up the channel object.
 */
$channel = new \pear2\Pyrus\ChannelFile(__DIR__ . '/channel.xml');

pear2\SimpleChannelFrontend\Main::$url = 'http://channel.com/';
