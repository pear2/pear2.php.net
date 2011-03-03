--TEST--
\PEAR2\Templates\Savant\Main::render() fast compiler test
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
mkdir(__DIR__ . '/compiled');
$compiler = new PEAR2\Templates\Savant\BasicFastCompiler(__DIR__ . DIRECTORY_SEPARATOR . 'compiled');
$savant->setCompiler($compiler);

$test->assertEquals(__DIR__ . DIRECTORY_SEPARATOR . 'compiled' . DIRECTORY_SEPARATOR .
                    md5('.' . DIRECTORY_SEPARATOR . 'Foo.tpl.php'), $savant->template('Foo.tpl.php'),
                    'verify compiler is called');
$test->assertEquals("<?php return '' .  get_class(\$context)  . '
' .  \$context->var1  . '';", file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'compiled' . DIRECTORY_SEPARATOR .
                    md5('.' . DIRECTORY_SEPARATOR . 'Foo.tpl.php')), 'compiled template');

$test->assertEquals('Foo is my class', $savant->render($object), 'render object');

$test->assertEquals('test', $savant->render($object, 'echostring.tpl.php'), 'render object with custom template');

?>
===DONE===
--CLEAN--
<?php
$a = opendir(__DIR__ . '/compiled');
while (false !== ($b = readdir($a))) {
    if (is_dir(__DIR__ . '/compiled/' . $b)) continue;
    unlink(__DIR__ . '/compiled/' . $b);
}
rmdir(__DIR__ . '/compiled');
?>
--EXPECT--
===DONE===