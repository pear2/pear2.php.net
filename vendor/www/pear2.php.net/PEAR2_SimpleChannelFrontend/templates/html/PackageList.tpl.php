<?php
// Set the title for the main template
$parent->context->page_title = 'Packages | ' . $frontend->getChannel()->name;
?>
<div class="packagelist grid_8">
    <h1>Available Packages</h1>
    <ul>
    <?php
    foreach ($context as $package) {
        echo '<li><a href="' . $frontend->getURL() . $package->name . '">' . $package->name . '</a></li>';
    }
    ?>
    </ul>
</div>
