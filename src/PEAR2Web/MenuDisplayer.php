<?php

namespace PEAR2Web;

class MenuDisplayer
{
    public static function display($base, array $menu, $selected = null)
    {
        echo "\t" . '<h1>';

        if ($selected !== 'news') {
            echo '<a href="' . $base . '">';
        }

        echo '<img src="' . $base . 'img/logo.png" alt="Pear" />';
        echo '<span>PHP Extension and Application Repository</span>';

        if ($selected) {
            echo '</a>';
        }

        echo '</h1>' ."\n";

        echo "\t\t\t" . '<div id="nav">' ."\n";
        echo "\t\t\t" . '<ul id="navbar">' ."\n";

        foreach ($menu as $id => $item) {
            echo "\t\t\t\t";

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

        echo "\t\t\t" . '</ul>' . "\n";

        if (   $selected
            && isset($menu[$selected])
            && isset($menu[$selected]['menu'])
            && is_array($menu[$selected]['menu'])
            && count($menu[$selected]['menu']) > 0
        ) {
            echo "\t\t\t" . '<div id="subnav">' . "\n";
            echo "\t\t\t\t" . '<div id="subnavcontainer">' . "\n";
            echo "\t\t\t\t\t" . '<ul id="subnavbar">' . "\n";

            foreach ($menu[$selected]['menu'] as $id => $item) {
                echo "\t\t\t\t\t\t" . '<li>';

                echo '<a href="' . $base . $item['link'] . '">';
                echo $item['title'];
                echo '</a>';

                echo '</li>' . "\n";
            }

            echo "\t\t\t\t\t" . '</ul>' . "\n";
            echo "\t\t\t\t" . '</div>' . "\n";
            echo "\t\t\t" . '</div>' . "\n";
        }

        echo "\t\t\t" . '</div>' . "\n";
        echo "\t\t\t" . '<div class="clearfix"></div>' . "\n";
    }

    public static function displayFooter($base, array $menu)
    {
        $last = end(array_keys($menu));

        foreach ($menu as $id => $item) {
            echo "\t\t\t";

            if ($id == $last) {
                echo '<ul class="footer-menu footer-menu-last">' . "\n";
            } else {
                echo '<ul class="footer-menu">' . "\n";
            }

            echo "\t\t\t\t" . '<li class="header">';
            echo '<a href="' . $base . $item['link'] . '">';
            echo $item['title'];
            echo '</a>';
            echo '</li>' . "\n";

            if (isset($item['menu']) && is_array($item['menu'])) {
                foreach ($item['menu'] as $subId => $subItem) {
                    echo "\t\t\t\t";
                    echo '<li><a href="' . $subItem['link'] . '">';
                    echo $subItem['title'];
                    echo '</a></li>' . "\n";
                }
            }

            echo "\t\t\t" . '</ul>' . "\n";
        }

        echo "\t\t\t" . '<div class="clearfix"></div>' . "\n";
    }
}
