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
echo $savant->render($context, 'PackageDependencies.tpl.php');

?>

</div>
