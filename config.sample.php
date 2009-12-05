<?php
ini_set('display_errors', true);
error_reporting(E_ALL);
// set up basics
require_once dirname(__FILE__).'/includes/autoload.php';

pear2\SimpleChannelFrontend\Main::$url = 'http://pear2.php.net/';