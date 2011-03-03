--TEST--
\PEAR2\Templates\Savant\Main::render() object test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';
chdir(__DIR__);
$savant = new \PEAR2\Templates\Savant\Main();

class Foo
{
    public $var1;
    function __toString()
    {
        return 'test';
    }
}

$object = new Foo();
$object->var1  = ' is my class';

$savant->setEscape();

$test->assertEquals('Foo is my class', $savant->render($object), 'render object');

$test->assertEquals('test', $savant->render($object, 'echostring.tpl.php'), 'render object with custom template');

?>
===DONE===
--EXPECT--
===DONE===