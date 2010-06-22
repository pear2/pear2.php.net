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

    $package->figureOutBestVersion(
        new \PEAR2\Pyrus\PackageFile\v2\Dependencies\Package(
            'required',
            'package',
            null,
            array(
                'name'              => $package->name,
                'channel'           => 'pear2.php.net',
                'uri'               => null,
                'min'               => null,
                'max'               => null,
                'recommended'       => null,
                'exclude'           => null,
                'providesextension' => null,
                'conflicts'         => null
            ),
            0
        )
    );

    $packageTitle = str_replace('PEAR2_', '', $package->name);
    $packageHref  = PEAR2\SimpleChannelFrontend\Main::getURL()
        . $package->name;

    echo '<div class="package">';

    echo '<div class="package-info">';

    echo '<div class="package-title">';
    echo '<a href="' . $packageHref . '">' . $packageTitle . '</a>';
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

<?php echo $savant->render(null, 'OtherChannelsNote.tpl.php'); ?>
