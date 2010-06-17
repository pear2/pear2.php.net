<?php

// Set the page title
$parent->context->page_title = $context->name . ' | Categories | ' . PEAR2\SimpleChannelFrontend\Main::$channel->name;

?>

        <div id="categories" class="pearbox">
            <div class="pearbox-header">
                <h2>
                    <a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>categories/">Packages</a>
                    ›
                    <?php echo $context->name; ?> <span><?php echo count($context); ?></span>
                </h2>
            </div>
            <div class="pearbox-content clearfix">

<?php

foreach ($context as $key => $package) {
    echo '<div class="package">';

    echo '<div class="package-info">';

    echo '<div class="package-title">';
    echo '<a href="' . PEAR2\SimpleChannelFrontend\Main::getURL()
        . $package->name . '">' . $package->name . '</a>';

    echo '</div>';
    echo '<div class="package-description">';
    echo '<p>' . $package->summary . '</p>';
    echo '</div>';

    echo '</div>';
    echo '<div class="package-more-info">';

    echo $savant->render($package, 'PackageDetails.tpl.php');

    echo '</div>';

    echo '</div>';
}

?>

            </div>
        </div>
