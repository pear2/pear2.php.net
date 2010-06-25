<?php

// Set the page title
$parent->context->page_title = $context->name . ' - '
    . PEAR2\SimpleChannelFrontend\Main::$title;

?>

<div class="left">

    <div class="pearbox package-description">

        <div class="pearbox-header navbar">
            <h2><?php echo $context->name; ?></h2>
        </div>

        <div class="pearbox-content">

            <?php echo $savant->render($context, 'PackageDescription.tpl.php'); ?>

            <div class="package-categories">
                <h3>Categories</h3>
            </div>
        </div>
    </div>

</div>

<div class="right">

<?php

echo $savant->render(
    $context->name . '-' . $context->version['release'],
    'InstallInstructions.tpl.php'
);

?>

<?php

echo $savant->render($context, 'PackageDetails.tpl.php');

?>

    <div class="package-releases">
        <h3>Release History</h3>
        <table>
            <tbody>

<?php

$count = 0;

foreach ($context as $version => $release) {

    $releaseURL = PEAR2\SimpleChannelFrontend\Main::getURL()
        . $context->name . '-' . $version;

    $class = ($count % 2 === 0) ? 'odd' : 'even';

    switch ($release['stability']) {
    case 'alpha':
        $statusClass = 'package-alpha';
        break;
    case 'beta':
        $statusClass = 'package-beta';
        break;
    default:
        $statusClass = 'package-stable';
        break;
    }

    $releaseDateISO = $context->date . 'T' . $context->time;
    $releaseDate    = date('F j, Y', strtotime($releaseDateISO));

    echo '                ';
    echo '<tr id="release-' . $version . '" class="' . $class . '">' ." \n";
    echo '                    ';
    echo '<td class="package-releases-release">';
    echo '<a href="' . $releaseURL . '">' . $version . '</a>';
    echo '</td>' . "\n";
    echo '                    ';
    echo '<td class="package-releases-status">';
    echo '<span class="' . $statusClass . '">' . $release['stability'] . '</span>';
    echo '</td>' . "\n";
    echo '                    ';
    echo '<td class="package-releases-date">';
    echo '<abbr class="date" title="' . $releaseDateISO . '">' . $releaseDate . '</abbr>';
    echo '</td>' . "\n";
    echo '                ';
    echo '</tr>' . "\n";

    $count++;
}

?>
            </tbody>
        </table>
    </div>

<?php
if (count($context->dependencies['required']->package) > 0):
?>
    <div class="package-dependencies">
        <h3>Dependencies for <?php echo $context->name; ?></h3>
        <ul>

<?php

// php dependencies
foreach ($context->dependencies['required']->php as $php) {

    if ($php->min && $php->max) {
        $phpTitle = 'PHP ≥ ' . $php->min . ' ≤ '. $php->max;
    } else if ($php->min) {
        $phpTitle = 'PHP ≥ ' . $php->min;
    } else if ($php->max) {
        $phpTitle = 'PHP ≤ ' . $php->max;
    }

    echo '<li>' . $phpTitle. '</li>';
}


// package dependencies
foreach ($context->dependencies['required']->package as $name => $package) {
    echo '<li><a href="http://'.$name.'">' . $name . '</a></li>';
}

// extension dependencies
foreach ($context->dependencies['required']->extension as $name => $extension) {

    $extensionTitle = $name . ' extension';

    if ($extension->min && $extension->max) {
        $extensionTitle .= ' ≥ ' . $extension->min . ' ≤ '. $extension->max;
    } else if ($extension->min) {
        $extensionTitle .= ' ≥ ' . $extension->min;
    } else if ($extension->max) {
        $extensionTitle .= ' ≤ ' . $extension->max;
    }

    echo '<li>' . $extensionTitle . '</li>';
}

// os dependencies
foreach ($context->dependencies['required']->os as $name => $supported) {

    if ($supported) {
        $osTitle = 'only works on ' . $name;
    } else {
        $osTitle = 'does not works on ' . $name;
    }

    echo '<li>' . $osTitle . '</li>';
}

?>
        </ul>
    </div>

<?php endif; ?>

</div>
