<?php
// Set the title for the main template
$parent->context->page_title = 'Packages | '.PEAR2\SimpleChannelFrontend\Main::$channel->name;
?>
<div class="packagelist grid_8">
    <h1>Available Packages</h1>
    <ul>
    <?php
    foreach ($context as $package) {
        echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
    }
    ?>
    </ul>
</div>