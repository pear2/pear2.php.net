--TEST--
\PEAR2\Templates\Savant\Main::render() string with addEscape() test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';
chdir(__DIR__);
$savant = new \PEAR2\Templates\Savant\Main();
$savant->setEscape('htmlspecialchars');

$string = 'test';
$test->assertEquals($string, $savant->escape($string), 'render');

$string = '<p></p>';
$test->assertEquals(htmlspecialchars($string), $savant->escape($string), 'render string with special chars');

?>
===DONE===
--EXPECT--
===DONE===