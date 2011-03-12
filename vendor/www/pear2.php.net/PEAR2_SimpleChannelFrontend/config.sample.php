<?php
/**
 * This is a sample configuration file for PEAR2_SimpleChannelFrontend
 * 
 * Be sure to set up the $channel object to the appropriate channel.
 */
ini_set('display_errors', true);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../php/PEAR2/Autoload.php';

$config = PEAR2\Pyrus\Config::singleton('/tmp');

/**
 * An example of setting up the channel object.
 */
$channel = new \PEAR2\Pyrus\ChannelFile(__DIR__ . '/channel.xml');

PEAR2\SimpleChannelFrontend\Main::$url = 'http://channel.com/';
