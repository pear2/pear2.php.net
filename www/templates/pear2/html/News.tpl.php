<?php

// Set the page title
$parent->context->page_title = PEAR2\SimpleChannelFrontend\Main::$title;

$rss_feed = '/var/tmp/pear/rss_cache/pear-news.xml';
if (file_exists($rss_feed)) {
    $blog = simplexml_load_file($rss_feed);
}
?>

<div id="recent">
    <h2>Recent Packages</h2>

<?php

echo $savant->render(
    new \PEAR2\SimpleChannelFrontend\LatestReleases(
        array(
            'frontend' => $parent->context->getRawObject(),
            'limit'    => 10,
        )
    )
);

?>

</div>

<div id="news">
    <h2>News</h2>
    <?php if (!empty($blog)) { ?>
        <?php $n = 0; ?>
        <ul>
        <?php foreach ($blog->xpath('//item') as $node) { ?>
            <?php if ($n++ >= 3) { continue; } ?>
                <li><a href="<?php echo (string)$node->link; ?>"><?php echo (string)$node->title; ?><span> – <?php echo date('F j, Y', strtotime($node->pubDate)); ?></span></a></li>
        <?php } ?>
        </ul>
    <?php } else { ?>

    <p>Looks like we don't have an RSS feed. Try adding a cron job to fetch <a href="http://blog.pear.php.net/feed/">http://blog.pear.php.net/feed/</a> and put it in <?php print $rss_feed; ?></p>
    <p><code>wget --output-document=/var/tmp/pear/rss_cache/pear-news.xml http://blog.pear.php.net/feed/</code></p>
    <?php } ?>

</div>

<?php

echo $savant->render(
    new \PEAR2\SimpleChannelFrontend\Categories(
        array(
            'frontend' => $parent->context->getRawObject()
        )
    )
);

?>
