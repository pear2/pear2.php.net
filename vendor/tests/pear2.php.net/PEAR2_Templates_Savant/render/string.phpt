--TEST--
\PEAR2\Templates\Savant\Main::render() string test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';
chdir(__DIR__);
$savant = new \PEAR2\Templates\Savant\Main();
$savant->setEscape('htmlspecialchars');

$string = 'test';
$test->assertEquals($string, $savant->render($string), 'render');

$string = '<p></p>';
$test->assertEquals(htmlspecialchars($string), $savant->render($string), 'render string with special chars');

$string = 'test';
$test->assertEquals($string, $savant->render($string, 'echostring.tpl.php'), 'render string through template');

$string = '<p></p>';
$test->assertEquals(htmlspecialchars($string), $savant->render($string, 'echostring.tpl.php'), 'render string with special chars through template');
?>
===DONE===
--EXPECT--
===DONE===