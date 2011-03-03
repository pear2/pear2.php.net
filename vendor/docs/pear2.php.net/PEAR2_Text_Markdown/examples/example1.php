<?php
function autoload($class)
{
    $class = str_replace(array('PEAR2\\Text\\', '_'), array('', '/'), $class);
    include $class . '.php';
}
    
spl_autoload_register("autoload");

set_include_path(dirname(dirname(__FILE__)).'/src/Text');

ini_set('display_errors', true);
error_reporting(E_ALL);

$markdown = new \PEAR2\Text\Markdown_Main();

echo $markdown->transform(file_get_contents('http://daringfireball.net/projects/markdown/basics.text'));