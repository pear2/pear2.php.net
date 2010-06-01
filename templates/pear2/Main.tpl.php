<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?php echo $context->page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/reset-fonts/reset-fonts.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>templates/pear2/css/main.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>templates/pear2/css/packages.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>templates/pear2/css/package-details.css" />

    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>templates/pear2/css/signin.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>templates/pear2/css/account-request.css" />
    
    <link rel="alternate" title="PEAR2 Latest Releases" type="application/rss+xml" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>?view=latest&amp;format=rss" />
</head>

<body>

<div id="header">

    <div id="top">
        <div class="content">
            <h1><img src="templates/pear2/css/img/logo.png" alt="Pear" /><span>PHP Extension and Application Repository</span></h1>
            <div id="nav">
                <ul id="navbar">
                    <li><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\News'); ?>">Home</a></li>
                    <li><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\PackageList'); ?>">Packages</a></li>
                    <li><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\Categories'); ?>">Categories</a></li>
                    <li><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\Support'); ?>">Support</a></li>
                </ul>
            </div>

        </div>
    </div>
<?php
if ($context->options['view'] == 'news'):
?>
    <div id="mid">
        <div class="content">
            <div class="left">
            <h2>What is Pear?</h2>
            Pear is a packaging and distribution system for reusable PHP components. You can find more information about using Pear in the <a href="#">online manual</a>.
            </div>

            <div class="right">
                <h2>Download Pyrus <span>New!</span></h2>
                Pyrus is a tool to manage Pear packages. Pyrus simplifies and improves the Pear experience.
                <div id="download">
                    <a class="button" href="#">Download Pyrus ↴</a>
                </div>
            </div>

        </div>
    </div>
    <div id="bottom">
        <div class="content">
        <h2>Who’s Using Pear?</h2>
        ...
            <a href="#">Digg</a>,
            <a href="#">Twitter</a>,
            <a href="#">Facebook</a>,
            <a href="#">silverorange</a>,
            <a href="#">Ning</a>,
            <a href="#">Roundcube</a>,
            <a href="#">Zend Framework</a>,
            <a href="#">Symfony</a>

        ...
        </div>
    </div>
</div>
<?php endif; ?>
<div id="content">
    <div class="content">
        <?php echo $savant->render($context->page_content); ?>
    </div>
</div>

<div id="footer">
    <div class="content">

        <div id="footer-left">
            <ul class="footer-menu">
                <li class="header"><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\News'); ?>">Home</a></li>
            </ul>
            <ul class="footer-menu">
                <li class="header"><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\PackageList'); ?>">Packages</a></li>
            </ul>
            <ul class="footer-menu">
                <li class="header"><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\Categories'); ?>">Categories</a></li>
            </ul>
            <ul class="footer-menu footer-menu-last">
                <li class="header"><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL('PEAR2\SimpleChannelFrontend\Support'); ?>">Support</a></li>
            </ul>
            <p class="note">
            Copyright © 2001-2010 The PHP Group, all rights reserved. Bandwidth and
            hardware provided by Pair Networks. Pear is a framework and distribution
            system for reusable PHP components. You can find out more information
            about Pear in the <a href="#">online manual</a>.
            </p>

        </div>
    </div>
</div>

</body>

</html>

