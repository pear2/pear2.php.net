<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="search" title="search packages" type="application/opensearchdescription+xml" href="?view=searchdefinition">
    <link rel="alternate" title="My Channel Latest Releases" type="application/rss+xml" href="?view=latest&amp;format=rss" />
    <link rel="stylesheet" href="<?php echo $frontend->getURL(); ?>css/all.css" />
    <title><?php echo $context->page_title; ?></title>
  </head>
  <body>
    <div class="container_12">
        <div class="header">
            <h1><?php echo $frontend->getChannel()->summary; ?></h1>
            <ul class="navigation">
                <li><a href="<?php echo $frontend->getURL('PEAR2\SimpleChannelFrontend\News'); ?>">Home</a></li>
                <li><a href="<?php echo $frontend->getURL('PEAR2\SimpleChannelFrontend\PackageList'); ?>">Packages</a></li>
                <li><a href="<?php echo $frontend->getURL('PEAR2\SimpleChannelFrontend\Categories'); ?>">Categories</a></li>
                <li><a href="<?php echo $frontend->getURL('PEAR2\SimpleChannelFrontend\Support'); ?>">Support</a></li>
            </ul>
        </div>
        <div class="content">
            <?php echo $savant->render($context->page_content); ?>
        </div>
        <div class="footer">This is a PEAR channel running <a href="http://pear2.php.net/PEAR2_SimpleChannelFrontend">PEAR2_SimpleChannelFrontend</a></div>
    </div>
  </body>
</html>
