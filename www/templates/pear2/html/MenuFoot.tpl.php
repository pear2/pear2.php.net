<?php

$base = $frontend->getURL();
$keys = array_keys($context->getRaw('data'));
$last = end($keys);

echo '            <div class="footer-menu-container clearfix">' . "\n";

foreach ($context->data as $id => $item) {
    echo '                ';

    if ($id == $last) {
        echo '<ul class="footer-menu footer-menu-last">' . "\n";
    } else {
        echo '<ul class="footer-menu">' . "\n";
    }

    echo '                    <li class="header">';
    echo '<a href="' . $base . $item['link'] . '">';
    echo $item['title'];
    echo '</a>';
    echo '</li>' . "\n";

    if (isset($item['menu']) && is_array($item['menu'])) {
        foreach ($item['menu'] as $subId => $subItem) {
            echo '                    ';
            echo '<li><a href="' . $subItem['link'] . '">';
            echo $subItem['title'];
            echo '</a></li>' . "\n";
        }
    }

    echo '                </ul>' . "\n";
}

echo '            </div>' . "\n";

?>
