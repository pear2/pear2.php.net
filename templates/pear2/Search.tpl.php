<?php
// Set the title for the main template
$parent->context->page_title = 'Search | '.PEAR2\SimpleChannelFrontend\Main::$channel->name;
?>
<div id="packages" class="packagelist pearbox">
    <div class="pearbox-header">
        <h2>Package Search</h2>
        <?php echo $savant->render(null, 'SearchForm.tpl.php'); ?>
    </div>
    <div class="pearbox-content">
        <h2>Results for <?php echo $context->query; ?></h2>
        <ul>
        <?php
        foreach ($context as $package) {
            echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
        }
        ?>
        </ul>
    </div>
</div>