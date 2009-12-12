<?php
// Set the title for the main template
$parent->context->page_title = $context->name.' | pear2.php.net';
?>
<div class="package">
    <div class="grid_8 left">
        <h2>
            <a href="<?php echo pear2\SimpleChannelFrontend\Main::getURL() . $context->name; ?>"><?php echo $context->name; ?></a> ::
                <?php echo $context->version['release']; ?>
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
        <?php echo $savant->render($context->name . '-' . $context->version['release'], 'InstallInstructions.tpl.php'); ?>
    </div>
    <div class="grid_4 right releases">
        <h3>Release Notes</h3>
        <?php echo nl2br($context->notes); ?>
    </div>
</div>
