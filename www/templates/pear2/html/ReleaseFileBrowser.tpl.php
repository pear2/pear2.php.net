<?php

// Set the page title
$parent->context->page_title = 'File Content - '
    . PEAR2\SimpleChannelFrontend\Main::$title;

?>
<h2>File</h2>
<div class="file-list pearbox">
<div class="pearbox-header">
<h3>Files</h3>
</div>
<div class="pearbox-content">
<?php

if (isset($context->options['packageVersion'])) {
    $releaseRoot = $context->package->name . '-'
        . $context->package->version['release'];
} else {
    $releaseRoot = $context->package->name;
}

$releaseFile = $context->package->name . '-'
    . $context->package->version['release'] . '.tgz';

$traverseFiles = function(\RecursiveIterator $node) use (&$traverseFiles, $context, $releaseFile, $releaseRoot)
{
    echo '<ul>';
    foreach ($node as $file) {
        echo '<li>';

        $filename = basename($file);

        if ($node->hasChildren()) {
            echo $filename;
            echo '/';
            $traverseFiles($node->getChildren());
        } else {
            $filePath = substr(
                $file,
                strpos($file, $releaseFile) + strlen($releaseFile) + 1
            );

            $fileURL = PEAR2\SimpleChannelFrontend\Main::getURL()
                . $releaseRoot . '/files/' . $filePath;

            echo '<a href="' . htmlspecialchars($fileURL) . '">';
            echo $filename;
            echo '</a>';
        }

        echo '</li>';
    }
    echo '</ul>';
};

$node = $context->getRaw('releaseFile');
$traverseFiles($node);

?>
</div>
</div>
<div class="file-content">
<?php

if (isset($context->file)) {
    echo '<div class="file-line-numbers">';
    $count = 0;
    foreach ($context->file as $line) {
        $count++;
        $class = ($count % 2 === 0) ? 'even' : 'odd';
        $line = str_replace(' ', '&nbsp;', $line);
        echo '<div class=' . $class . '>' . $count . '</div>';
    }
    echo '</div>';
}

if (isset($context->file)) {
    echo '<pre class="file-lines">';
    echo '<code>';
    $count = 0;
    foreach ($context->file as $line) {
        $count++;
        $class = ($count % 2 === 0) ? 'even' : 'odd';
        $line = str_replace(' ', '&nbsp;', $line);
        $line = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $line);
/*        if (preg_match('/^\s+$/', $line) === 1) {
            $line = '&nbsp;';
        }*/
        echo $line;
    }
    echo '</code>';
    echo '</pre>';
}
?>

<div class="file-end">EOF</div>

<script>hljs.initHighlightingOnLoad();</script>

</div>
