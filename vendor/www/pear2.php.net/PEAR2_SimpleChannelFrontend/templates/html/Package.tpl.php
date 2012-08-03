<?php
// Set the title for the main template
$parent->context->page_title = $context->name . ' | ' . $frontend->getChannel()->name;
?>
<div class="package">
    <div class="grid_8 left">
        <h2>Package :: <?php echo $context->name; ?></h2>
        <p><em><?php echo $context->summary; ?></em></p>
        <p>
            <?php
            $description = preg_replace("|\&lt\;\?php(.*)\?\&gt\;|Use", "highlight_string('<?php'.html_entity_decode('\\1').'?>', true)", $context->description);
            echo nl2br($description);
            ?>
        </p>
        <?php echo $savant->render($context->channel . '/' . $context->name . '-' . $context->version['release'], 'InstallInstructions.tpl.php'); ?>
    <?php

    $filesURL = $frontend->getURL() . $context->name . '/files';

    ?>
    <div class="package-files">
        <h3><a class="button" href="<?php echo $filesURL; ?>">Browse Files</a></h3>
        <span class="package-files-info"><?php echo $savant->render($context, 'PackageFileInfo.tpl.php'); ?>
    </div>
    </div>
    <div class="grid_4 right releases">
        <h3>Releases</h3>
        <ul>
            <?php
             foreach ($context as $version => $release): ?>
            <li>
                <a href="<?php echo $frontend->getURL() . $context->name . '-' . $version; ?>"><?php echo $version; ?></a>
                <span class="stability"><?php echo $release['stability']; ?></span>
                <abbr class="releasedate" title="<?php echo $context->date.' '.$context->time; ?>"><?php echo $context->date; ?></abbr>
                <a class="download" href="<?php echo $context->getDownloadURL('.tgz'); ?>">Download</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
