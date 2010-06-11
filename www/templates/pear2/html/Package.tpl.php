<?php
// Set the title for the main template
$parent->context->page_title = $context->name.' | pear2.php.net';
?>
<div class="package">
    <div class="left">
        <h2><?php echo $context->name; ?></h2>
        <p><em><?php echo $context->summary; ?></em></p>
        <p>
            <?php
            $description = preg_replace("|\&lt\;\?php(.*)\?\&gt\;|Use", "highlight_string('<?php'.html_entity_decode('\\1').'?>', true)", $context->description);
            echo nl2br($description);
            ?>
        </p>
    </div>
    <div class="right releases">
        <?php echo $savant->render($context->name . '-' . $context->version['release'], 'InstallInstructions.tpl.php'); ?>
        <div class="pearbox">
            <div class="pearbox-header">
                <h2>Releases</h2>
            </div>
            <div class="pearbox-content">
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
    </div>
</div>
