        <div id="packages" class="pearbox">
            <div class="pearbox-header">
                <h2>Packages</h2>
                <?php echo $savant->render(null, 'SearchForm.tpl.php'); ?>
            </div>
            <div class="pearbox-content">
                <ul class="categories">
                    <?php
                    $num = 0; foreach ($context as $category) : ?>
                    <li id="category-<?php echo ++$num; ?>" class="category <?php echo (($num % 3) === 1) ? 'category-clear' : ''; ?>">
                        <h3><a href=""><span class="category-title"><?php echo $category->name; ?></span> <span class="category-count"><?php echo count($category); ?></span></a></h3>
                        <div><?php
                        if (count($category)) {
                            echo '<ul>';
                            foreach ($category as $package) {
                                echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
                            }
                            echo '</ul>';
                        }
                        ?></div>
                    </li>
                    <?php
                    endforeach; ?>
                </ul>
            </div>
        </div>
        <h3>Don't see what you need?</h3>
        <p>Many of the PEAR packages you know and love are still available on <a href="http://pear.php.net/packages.php">pear.php.net</a> or <a href="http://pear.php.net/channels/">other PEAR compatible channels</a>.</p>
