<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

// set up basics
require_once __DIR__ . '/vendor/php/PEAR2/Autoload.php';

// \PEAR2Web\Config::$options['channel_path'] = '/home/my-user/my-channel';
// \PEAR2Web\Config::$options['url']          = 'http://pear2.php.net/';
// \PEAR2Web\Config::$options['title']        = 'PEAR2';

$config = PEAR2\Pyrus\Config::singleton('/tmp/pear2web');
