<?php

$releaseFile = $context->name . '-' . $context->version['release'] . '.tgz';

$root = rtrim(
    \PEAR2\SimpleChannelFrontend\Main::$channel_path,
    DIRECTORY_SEPARATOR
);
$root        = $root . DIRECTORY_SEPARATOR . 'get';
$releaseFile = $root . DIRECTORY_SEPARATOR . $releaseFile;

if (!file_exists($releaseFile) || dirname($releaseFile) != $root) {
    throw new \Exception('Cannot find the package ' . $releaseFile . '.');
}

$releaseFile = new \PharData($releaseFile);

$fileCount      = 0;
$directoryCount = 0;

$traverseFiles = function(
    \RecursiveIterator $node
) use (
    &$traverseFiles,
    &$fileCount,
    &$directoryCount
) {
    foreach ($node as $file) {
        if ($node->hasChildren()) {
            $directoryCount++;
            $traverseFiles($node->getChildren());
        } else {
            $fileCount++;
        }

    }
};

$traverseFiles($releaseFile);

?><strong><?php echo $fileCount; ?></strong> files in <strong><?php echo $directoryCount; ?></strong> directories.
