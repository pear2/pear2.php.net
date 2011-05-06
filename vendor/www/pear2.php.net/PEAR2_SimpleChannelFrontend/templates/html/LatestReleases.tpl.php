<?php
// Set the title for the main template
$parent->context->page_title = 'Latest Releases | '.$frontend->getChannel()->name;
?>
<div class="packagelist grid_8">
    <h1>Latest Releases</h1>
    <ul>
    <?php
    foreach ($context as $date=>$package) {
        echo '<li>' . $date . ' <a href="' . $frontend->getURL() . $package->name . '-' . $package->version['release'].'">'.$package->name . '-' . $package->version['release'] . '</a></li>';
    }?>
    </ul>
</div>
