<?php

echo '    <ul id="recent-left">' . "\n";

$count = 0;

foreach ($context as $date => $package) {

    if ($count === 5) {
        echo '    </ul>' . "\n";
        echo '    <ul id="recent-right">' . "\n";
    }

    $packageURL = PEAR2\SimpleChannelFrontend\Main::getURL()
        . $package->name;

    $packageTitle = htmlspecialchars(
        str_replace('PEAR2_', '', $package->name)
    );

    $packageTitle .= '-' . $package->version['release'];

    $releaseDate = date('F j', strtotime($date));

    echo '        <li>';
    echo '<a href="' . $packageURL . '">';
    echo $packageTitle;
    echo '<span> — ' . $releaseDate .'</span>';
    echo '</a>';
    echo '</li>' . "\n";

    $count++;

}

echo '    </ul>' . "\n";

?>
