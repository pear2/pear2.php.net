<?php

// Set the page title
$parent->context->page_title = 'Categories | ' . PEAR2\SimpleChannelFrontend\Main::$channel->name;

$categoriesPerRow    = 3;
$packagesPerCategory = 4;

?>
        <div id="packages" class="pearbox">
            <div class="pearbox-header">
                <h2>Packages</h2>
                <?php echo $savant->render(null, 'SearchForm.tpl.php'); ?>
            </div>
            <div class="pearbox-content clearfix">

                <ul class="categories">
<?php

$categoryCount = 0;
foreach ($context as $category) {
    $class = ($categoryCount % $categoriesPerRow === 0) ?
        'category category-clear' : 'category';

    $packageCount = count($category);

    echo '<li class="' . $class . '">';

    echo '<h3>';
    echo '<a href="#">';
    echo '<span class="category-title">' . $category->name . '</span> ';
    echo '<span class="category-count">' . $packageCount . '</span>';
    echo '</a>';
    echo '</h3>';

    if ($packageCount > 0) {
        echo '<ul>';

        $packageCount = 0;
        foreach ($category as $package) {
            echo '<li>';

            if ($packageCount > 0) {
                echo ', ';
            }

            if ($packageCount >= $packagesPerCategory) {
                echo '…';
                break;
            } else {
                $packageHref = PEAR2\SimpleChannelFrontend\Main::getURL()
                    . $package->name;

                echo '<a href="' . $packageHref . '">' . $package->name . '</a>';
            }

            echo '</li>';
            $packageCount++;
        }

        echo '</ul>';
    }

    echo '</li>';
    $categoryCount++;
}

?>
                </ul>

            </div>
        </div>
        <div class="pear-message">
            <div class="pear-message-content">
                <h3>Don’t see what you need?</h3>
                <p>Many of the PEAR packages you know and love are still available on <a href="http://pear.php.net/packages.php">pear.php.net</a> or <a href="http://pear.php.net/channels/">other PEAR compatible channels</a>.</p>
            </div>
        </div>
