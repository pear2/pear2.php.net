<?php
$parent->context->page_title = $context->name . ' | Categories | ' . PEAR2\SimpleChannelFrontend\Main::$channel->name; ?>

<div class="grid_8 left">
 <div class="packages-header">
  <h2 class="category-title"><?php echo $context->name; ?></h2>
 </div>
 <?php
 if (count($context)) {
    echo '<ul>';
    foreach ($context as $package) {
        echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
    }
    echo '</ul>';
 }
 ?>
</div>
