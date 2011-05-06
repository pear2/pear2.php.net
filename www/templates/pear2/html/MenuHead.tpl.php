<?php

$base     = $frontend->getURL();
$selected = ($parent->context->options['view'] === 'news') ?
            null : $parent->context->options['view'];

echo '            <h1>';

if ($selected) {
    echo '<a href="' . $base . '">';
}

echo '<img src="' . $base . 'img/logo.png" alt="PEAR" />';
echo '<span>PHP Extension and Application Repository</span>';

if ($selected) {
    echo '</a>';
}

echo '</h1>' . "\n";

echo '            <div id="nav">' . "\n";
echo '            <ul id="navbar">' . "\n";

foreach ($context->data as $id => $item) {
    echo '                ';

    if ($selected == $id) {
        echo '<li class="selected">';
    } else {
        echo '<li>';
    }

    if ($selected != $id) {
        echo '<a href="' . $base . $item['link'] . '">';
    }

    echo $item['title'];

    if ($selected != $id) {
        echo '</a>';
    }

    echo '</li>';
    echo "\n";
}

echo '            </ul>' . "\n";

if (   $selected
    && isset($context->data[$selected])
    && isset($context->data[$selected]['menu'])
    && is_array($context->data[$selected]['menu'])
    && count($context->data[$selected]['menu']) > 0
) {
    echo '            <div id="subnav">' . "\n";
    echo '                <div id="subnavcontainer">' . "\n";
    echo '                    <ul id="subnavbar">' . "\n";

    foreach ($context->data[$selected]['menu'] as $id => $item) {
        echo '                        <li>';

        echo '<a href="' . $base . $item['link'] . '">';
        echo $item['title'];
        echo '</a>';

        echo '</li>' . "\n";
    }

    echo '                    </ul>' . "\n";
    echo '                </div>' . "\n";
    echo '            </div>' . "\n";
}

echo '            </div>' . "\n";

?>
