<?php
// Set the title for the main template
$parent->context->page_title = $context->name.' | '.$frontend->getChannel()->name;
?>
<div class="package">
    <div class="grid_8 left">
        <h2>
            <a href="<?php echo $frontend->getURL() . $context->name; ?>"><?php echo $context->name; ?></a>-<?php echo $context->version['release']; ?>
        </h2>
        <ul class="package-info">
            <li><strong>Version:</strong>
                <span><?php echo $context->version['release']; ?></span>
            </li>
            <li><strong>Stability:</strong>
                <span><?php echo $context->stability['release']; ?></span>
            </li>
            <li><strong>Released on:</strong>
                <span><abbr class="releasedate" title="<?php echo $context->date.' '.$context->time; ?>"><?php echo $context->date; ?></abbr></span>
            </li>
            <li><strong>License:</strong>
                <span><?php echo $context->license['name']; ?></span>
            </li>
        </ul>
        <?php echo $savant->render($context->channel . '/' . $context->name . '-' . $context->version['release'], 'InstallInstructions.tpl.php'); ?>
    <?php
    
    // reset version, maintainer count resets version for some reason
    $context->setRawVersion(
        null,
        array('release' => $parent->context->options['packageVersion'])
    );
    
    $filesURL = $frontend->getURL() . $context->name
        . '-' . $context->version['release']
        . '/files';
    
    ?>
    <div class="package-files">
        <h3><a class="button" href="<?php echo $filesURL; ?>">Browse Files</a></h3>
        <span class="package-files-info"><?php echo $savant->render($context, 'PackageFileInfo.tpl.php'); ?>
    </div>
    </div>
    <div class="grid_4 right releases">
        <h3>Release Notes</h3>
        <?php echo nl2br($context->notes); ?>
    </div>
</div>
