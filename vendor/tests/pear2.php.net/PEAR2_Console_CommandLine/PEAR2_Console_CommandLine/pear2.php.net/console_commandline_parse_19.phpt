--TEST--
Test for PEAR2\Console\CommandLine::parse() method (subcommand help 1).
--STDIN--
some_package
--SKIPIF--
<?php if(php_sapi_name()!='cli') echo 'skip'; ?>
--ARGS--
-v instbis -f -
--FILE--
<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'tests.inc.php';

$parser = buildParser2();
try {
    $result = $parser->parse();
    print_r($result);
} catch (PEAR2\Console\CommandLine\Exception $exc) {
    echo $exc->getMessage();
}

?>
--EXPECT--
PEAR2\Console\CommandLine\Result Object
(
    [options] => Array
        (
            [verbose] => 1
            [logfile] =>
            [help] =>
            [version] =>
        )

    [args] => Array
        (
        )

    [command_name] => install
    [command] => PEAR2\Console\CommandLine\Result Object
        (
            [options] => Array
                (
                    [force] => 1
                    [help] =>
                )

            [args] => Array
                (
                    [package] => some_package

                )

            [command_name] =>
            [command] =>
        )

)
