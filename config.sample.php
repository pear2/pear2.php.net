<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
// set up basics
require_once dirname(__FILE__).'/vendor/php/PEAR2/Autoload.php';

PEAR2\SimpleChannelFrontend\Main::$url   = 'http://pear2.php.net/';
PEAR2\SimpleChannelFrontend\Main::$title = 'PEAR2';

$config = PEAR2\Pyrus\Config::singleton('/tmp/pear2web');
