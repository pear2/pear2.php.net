<?php
// set up basics
require_once dirname(__FILE__).'/../PEAR2/autoload.php';

set_include_path(dirname(__FILE__).'/src');
function pyrus_autoload($class)
{
    $class = str_replace('_', '\\', $class);
    include implode('/', explode('\\', $class)) . '.php';
    
}
spl_autoload_register("pyrus_autoload");

?>