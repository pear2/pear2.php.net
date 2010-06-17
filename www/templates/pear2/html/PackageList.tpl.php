<?php
// Set the title for the main template
$parent->context->page_title = 'Packages | '.PEAR2\SimpleChannelFrontend\Main::$channel->name;
?>
<div class="packagelist pearbox">
    <div class="pearbox-header">
        <h2>Available Packages</h2>
        <?php echo $savant->render(null, 'SearchForm.tpl.php'); ?>
    </div>
    <div class="pearbox-content">
        <ul>
        <?php
        foreach ($context as $package) {
            echo '<li><a href="'.PEAR2\SimpleChannelFrontend\Main::getURL().$package->name.'">'.$package->name.'</a></li>';
        }
        ?>
        </ul>
    </div>
</div>
<div class="pear-message">
    <div class="pear-message-content">
        <h3>Don't see what you need?</h3>
        <p>Many of the PEAR packages you know and love are still available on <a href="http://pear.php.net/packages.php">pear.php.net</a> or <a href="http://pear.php.net/channels/">other PEAR compatible channels</a>.</p>
    </div>
</div>
