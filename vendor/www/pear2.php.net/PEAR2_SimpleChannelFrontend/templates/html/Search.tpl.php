<?php
// Set the title for the main template
$parent->context->page_title = 'Search | '.PEAR2\SimpleChannelFrontend\Main::$channel->name;
?>
<div class="packagelist grid_8">
    <h1>Package Search</h1>
    <form method="get">
        <input type="hidden" name="view" value="search" />
        <label>Search:</label><input type="text" name="q" value="<?php echo htmlentities($context->getRaw('query'), ENT_QUOTES); ?>" />
        <input type="submit" value="Go" />
    </form>
    <h2>Results for <?php echo $context->query; ?></h2>
    <ul>
    <?php
    foreach ($context as $package) {
        echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
    }
    ?>
    </ul>
</div>