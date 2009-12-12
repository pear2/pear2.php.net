<?php
// Set the title for the main template
$parent->context->page_title = $context->name.' | pear2.php.net';
?>
<div class="package">
    <div class="grid_8 left">
        <h2>Package :: <?php echo $context->name; ?></h2>
        <p><em><?php echo $context->summary; ?></em></p>
        <p>
            <?php
            echo nl2br(trim($context->description));
            ?>
        </p>
        <?php echo $savant->render($context->name . '-' . $context->version['release'], 'InstallInstructions.tpl.php'); ?>
    </div>
    <div class="grid_4 right releases">
        <h3>Releases</h3>
        <ul>
            <?php
             foreach ($context as $version => $release): ?>
            <li>
                <a href="<?php echo pear2\SimpleChannelFrontend\Main::getURL() . $context->name . '-' . $version; ?>"><?php echo $version; ?></a>
                <span class="stability"><?php echo $release['stability']; ?></span> 
                <abbr class="releasedate" title="<?php echo $context->date.' '.$context->time; ?>"><?php echo $context->date; ?></abbr>
                <a class="download" href="<?php echo $context->getDownloadURL('.tgz'); ?>">Download</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
