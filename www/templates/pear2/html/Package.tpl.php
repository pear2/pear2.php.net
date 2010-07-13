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

echo $savant->render($context, 'PackageDependencies.tpl.php');

?>

</div>
