<ul style="width:250px; float:left;">
<?php
foreach ($context->release as $file) {
    $filename = substr($file, strpos($file, $context->options['release'])+strlen($context->options['release'])+1);
    echo '<li><a href="?view=filebrowser&amp;release='.$context->options['release'].'&amp;internal='.$filename.'">'.$filename.'</a></li>';
}
?>
</ul>
<div class="source_browser">
<?php
if (isset($context->internal_file)) {
    echo '<ol>';
    foreach ($context->internal_file as $line) {
        echo '<li>'.$line.'</li>';
    }
    echo '</ol>';
}
?>
</div>
