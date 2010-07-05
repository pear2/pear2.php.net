<?php

// Set the page title
$parent->context->page_title = 'File Content - '
    . PEAR2\SimpleChannelFrontend\Main::$title;

?>
<div class="file-list pearbox">
<div class="pearbox-header">
<h3>Files</h3>
</div>
<div class="pearbox-content">
<?php

$traverseFiles = function(\RecursiveIterator $node) use (&$traverseFiles, $context)
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
                strpos($file, $context->options['release'])
                + strlen($context->options['release']) + 1
            );
            echo '<a href="?view=filebrowser&amp;release='.$context->options['release'].'&amp;internal=' . $filePath . '">';
            echo $filename;
            echo '</a>';
        }

        echo '</li>';
    }
    echo '</ul>';
};

$node = $context->getRaw('release');
$traverseFiles($node);

?>
</div>
</div>
<div class="file-content">
<?php

if (isset($context->internal_file)) {
    echo '<div class="file-line-numbers">';
    $count = 0;
    foreach ($context->internal_file as $line) {
        $count++;
        $class = ($count % 2 === 0) ? 'even' : 'odd';
        $line = str_replace(' ', '&nbsp;', $line);
        echo '<div class=' . $class . '>' . $count . '</div>';
    }
    echo '</div>';
}

if (isset($context->internal_file)) {
    echo '<div class="file-lines">';
    $count = 0;
    foreach ($context->internal_file as $line) {
        $count++;
        $class = ($count % 2 === 0) ? 'even' : 'odd';
        $line = str_replace(' ', '&nbsp;', $line);
        $line = str_replace("\t", '&nbsp;&nbsp;&nbsp;&nbsp;', $line);
        if (preg_match('/^\s+$/', $line) === 1) {
            $line = '&nbsp;';
        }
        echo '<div class=' . $class . '>' . $line . '</div>';
    }
    echo '</div>';
}

echo '<div class="file-end">EOF</div>';

?>
</div>
