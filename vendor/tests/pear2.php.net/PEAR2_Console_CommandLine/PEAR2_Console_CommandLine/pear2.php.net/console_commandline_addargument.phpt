--TEST--
Test for PEAR2\Console\CommandLine::addArgument() method.
--FILE--
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'tests.inc.php';

$parser = new PEAR2\Console\CommandLine();
$parser->addArgument('arg1');
$parser->addArgument('arg2', array(
    'multiple' => true,
    'description' => 'description of arg2'
));
$arg3 = new PEAR2\Console\CommandLine\Argument('arg3', array(
    'multiple' => true,
    'description' => 'description of arg3'
));
$parser->addArgument($arg3);
$parser->addArgument('arg4', array('optional' => true));

var_dump($parser->args);

// a bad argument
$parser->addArgument('Some invalid name');

?>
--EXPECTF--
array(4) {
  ["arg1"]=>
  object(PEAR2\Console\CommandLine\Argument)#6 (6) {
    ["multiple"]=>
    bool(false)
    ["optional"]=>
    bool(false)
    ["name"]=>
    string(4) "arg1"
    ["help_name"]=>
    string(4) "arg1"
    ["description"]=>
    NULL
    ["messages"]=>
    array(0) {
    }
  }
  ["arg2"]=>
  object(PEAR2\Console\CommandLine\Argument)#7 (6) {
    ["multiple"]=>
    bool(true)
    ["optional"]=>
    bool(false)
    ["name"]=>
    string(4) "arg2"
    ["help_name"]=>
    string(4) "arg2"
    ["description"]=>
    string(19) "description of arg2"
    ["messages"]=>
    array(0) {
    }
  }
  ["arg3"]=>
  object(PEAR2\Console\CommandLine\Argument)#8 (6) {
    ["multiple"]=>
    bool(true)
    ["optional"]=>
    bool(false)
    ["name"]=>
    string(4) "arg3"
    ["help_name"]=>
    string(4) "arg3"
    ["description"]=>
    string(19) "description of arg3"
    ["messages"]=>
    array(0) {
    }
  }
  ["arg4"]=>
  object(PEAR2\Console\CommandLine\Argument)#9 (6) {
    ["multiple"]=>
    bool(false)
    ["optional"]=>
    bool(true)
    ["name"]=>
    string(4) "arg4"
    ["help_name"]=>
    string(4) "arg4"
    ["description"]=>
    NULL
    ["messages"]=>
    array(0) {
    }
  }
}

Fatal error: argument name must be a valid php variable name (got: Some invalid name) in %sCommandLine.php on line %d