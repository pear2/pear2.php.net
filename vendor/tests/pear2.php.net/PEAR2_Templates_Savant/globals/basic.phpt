--TEST--
\PEAR2\Templates\Savant\Main::addGlobal() basic test
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';
chdir(__DIR__);
$savvy = new \PEAR2\Templates\Savant\Main();

$savvy->addGlobal('foo', true);

echo $savvy->render(null, 'basic.tpl.php');

?>
--EXPECT--
===DONE===