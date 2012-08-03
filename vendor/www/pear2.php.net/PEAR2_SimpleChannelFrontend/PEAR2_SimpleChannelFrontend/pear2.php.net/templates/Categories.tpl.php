<?php
$parent->context->page_title = 'Categories | '.pear2\SimpleChannelFrontend\Main::$channel->name; ?>

<div class="grid_8 left">
<div class="packages-header">
 <h2 class="category-title">Categories</h2>
</div>
<?php
if (count($context)) : ?>
<ul class="categories">
<?php
    foreach ($context as $category) : ?>
    <li id="category-1" class="category category-clear">
        <h3><a href=""><span class="category-title"><?php echo $category->name; ?></span></a><span class="category-count"> (<?php echo count($category); ?>)</span></h3>
        <div><?php
        if (count($category)) {
            echo '<ul>';
            foreach ($category as $package) {
                echo '<li><a href="'.pear2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
            }
            echo '</ul>';
        }
        ?></div>
    </li>
    <?php
    endforeach; ?>
</ul>
<?php
endif;
?>
</div>
