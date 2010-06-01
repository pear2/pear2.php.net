 <div id="packages" class="pearbox">
            <div class="pearbox-header">
                <h2>Packages</h2>
                <form method="get" action="." id="find-packages">
                    <div>
                        <input type="search" placeholder="Package name or description …" size="30" name="q" /><input class="button" value="Search" type="submit" />
                        <input type="hidden" name="view" value="search" />
                    </div>
                </form>
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

                <div class="clearfix"></div>
            </div>
        </div>
