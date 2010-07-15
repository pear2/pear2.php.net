<?php

// Set the page title
$parent->context->page_title = $context->name . '-'
    . $context->version['release'] . ' - '
    . PEAR2\SimpleChannelFrontend\Main::$title;

?>

<div class="left">

    <div class="pearbox package-description">

        <div class="pearbox-header navbar">
            <h2>
                <a href="<?php echo pear2\SimpleChannelFrontend\Main::getURL() . $context->name; ?>"><?php echo $context->name; ?></a>-<?php echo $context->version['release']; ?>
            </h2>
        </div>

        <div class="pearbox-content">

            <?php echo $savant->render($context, 'PackageDescription.tpl.php'); ?>

        </div>

    </div>

</div>
<div class="right">

<?php

echo $savant->render(
    $context->name . '-' . $context->version['release'],
    'InstallInstructions.tpl.php'
);

echo $savant->render($context, 'PackageDetails.tpl.php');

?>

<?php

// reset version, maintainer count resets version for some reason
$context->setRawVersion(
    null,
    array('release' => $parent->context->options['packageVersion'])
);

$filesURL = PEAR2\SimpleChannelFrontend\Main::getURL()
    . $context->name . '-' . $context->version['release']
    . '/files';

?>
    <div class="package-files">
        <h3><a class="button" href="<?php echo $filesURL; ?>">Browse Files</a></h3>
        <span class="package-files-info"><?php echo $savant->render($context, 'PackageFileInfo.tpl.php'); ?>
    </div>
<?php

echo $savant->render($context, 'PackageDependencies.tpl.php');

?>

</div>
