<?php
// Set the title for the main template
$parent->context->page_title = 'Search | ' . PEAR2\SimpleChannelFrontend\Main::$channel->name;
?>
<div id="search-packages" class="package-list pearbox">
    <div class="pearbox-header">
        <h2>Package Search</h2>
        <?php echo $savant->render(null, 'SearchForm.tpl.php'); ?>
    </div>
    <div class="pearbox-content">
<?php

if (count($context) === 0) {
    if ($context->query == '') {
        ?><p>No search keywords specified.</p><?php
    } else {
        ?>
        <p>No packages were found for the keywords <strong><?php echo $context->query; ?></strong>.</p>
        <ul>
            <li>try using less specific keywords</li>
        </ul>
        <?php
    }
} else {
    echo $savant->render($context, 'PackageList.tpl.php');
}

?>

    </div>
</div>
