<?php
function autoload($class)
{
    $class = str_replace(array('PEAR2\\Text\\', '_'), array('', '/'), $class);
    include $class . '.php';
}
    
spl_autoload_register("autoload");

set_include_path(dirname(dirname(dirname(dirname(__FILE__)))).'/src/Text');

ini_set('display_errors', true);
error_reporting(E_ALL);



function Markdown($text) {
    $markdown = new \PEAR2\Text\Markdown_Main();
    return $markdown->transform($text);
}