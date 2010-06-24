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

    // filter PEAR2 from package name
    $packageTitle = str_replace('PEAR2_', '', $package->name);

    // highlight search keywords
    if (isset($context->query)) {
        $packageTitle = preg_replace(
            '/(' . preg_quote($context->query, '/') . ')/i',
            '<span class="search-keyword-highlight">\1</span>',
            $packageTitle
        );
    }

    $packageHref = PEAR2\SimpleChannelFrontend\Main::getURL()
        . $package->name;

    echo '<div class="package-list-package">';

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
