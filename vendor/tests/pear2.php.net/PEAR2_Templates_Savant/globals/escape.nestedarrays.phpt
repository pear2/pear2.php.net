--TEST--
\PEAR2\Templates\Savant\Main::addGlobal() Escape added global array
--FILE--
<?php
require dirname(__FILE__) . '/../test_framework.php.inc';
chdir(__DIR__);
$savvy = new \PEAR2\Templates\Savant\Main();

$savvy->setEscape('htmlspecialchars');

$unescaped = array(
    '<a href="Blah">Blah</a>'
);

$savvy->addGlobal('foo', array($unescaped));

$escaped = $savvy->getGlobals();

echo $escaped['foo'][0][0];

?>
--EXPECT--
&lt;a href=&quot;Blah&quot;&gt;Blah&lt;/a&gt;