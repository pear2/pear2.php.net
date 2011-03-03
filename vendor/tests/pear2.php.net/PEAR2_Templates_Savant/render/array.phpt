--TEST--
\PEAR2\Templates\Savant\Main::render() array test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';
chdir(__DIR__);
$savant = new \PEAR2\Templates\Savant\Main();

$array = array(1,2,3);
$test->assertEquals('123', $savant->render($array), 'render array');

$array = array(1,2,3);
$test->assertEquals('123', $savant->render($array, 'echostring.tpl.php'), 'render array through custom template');

?>
===DONE===
--EXPECT--
===DONE===