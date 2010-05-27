<?php
// Set the title for the main template
$parent->context->page_title = 'News | pear2.php.net';
?>

<div id="recent">
    <h2>Recent Packages</h2>
    <ul>
        <?php echo $savant->render(new \PEAR2\SimpleChannelFrontend\LatestReleases(array('frontend'=>$parent->context->getRawObject(),
            'limit'=>5, 'id'=>'recent-left'))); ?>
        <?php echo $savant->render(new \PEAR2\SimpleChannelFrontend\LatestReleases(array('frontend'=>$parent->context->getRawObject(),
            'limit'=>5, 'offset'=>5, 'id'=>'recent-right'))); ?>
    </ul>
</div>
<div id="news">
    <h2>News</h2>
    <ul>
        <li><a href="#">PEAR channels on google code currently broken<span> – March 23, 2010</span></a></li>
        <li><a href="#">PEAR in March 2010<span> – March 19, 2010</span></a></li>

        <li><a href="#">Net_Traceroute and Net_Ping security advisory<span> – March 14, 2010</span></a></li>
    </ul>
</div>
<?php echo $savant->render(new \PEAR2\SimpleChannelFrontend\Categories(array('frontend'=>$parent->context->getRawObject()))); ?>
