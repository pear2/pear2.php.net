<?php

// Set the page title
$parent->context->page_title = 'Categories - '
    . PEAR2\SimpleChannelFrontend\Main::$title;

$categoriesPerRow    = 3;
$packagesPerCategory = 4;

?>
        <div id="categories" class="package-list pearbox">
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
    echo '<a href="' . PEAR2\SimpleChannelFrontend\Main::getURL() . 'categories/' . $category->name . '">';
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
                $packageTitle = str_replace('PEAR2_', '', $package->name);
                $packageHref  = PEAR2\SimpleChannelFrontend\Main::getURL()
                    . $package->name;

                echo '<a href="' . $packageHref . '">' . $packageTitle . '</a>';
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

<?php echo $savant->render(null, 'OtherChannelsNote.tpl.php'); ?>
