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
            <h1><a href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>"><img src="templates/pear2/css/img/logo.png" alt="PEAR" /><span>PHP Extension and Application Repository</span></a></h1>
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
            <h2>What is PEAR?</h2>
            PEAR is a packaging and distribution system for reusable PHP components. You can find more information about using PEAR in the <a href="#">online manual</a>.
            </div>

            <div class="right">
                <h2>Download Pyrus <span>New for PHP 5.3+!</span></h2>
                Pyrus is a tool to manage PEAR packages. Pyrus simplifies and improves the PEAR experience.
                <div id="download">
                    <a class="button" href="http://svn.php.net/viewvc/pear2/Pyrus/trunk/pyrus.phar?view=co">Download Pyrus ↴</a>
                </div>
            </div>

        </div>
    </div>
    <div id="bottom">
        <div class="content">
        <h2>Who’s Using PEAR?</h2>
        ...
            <a href="http://digg.com/">Digg</a>,
            <a href="http://twitter.com/">Twitter</a>,
            <a href="http://www.facebook.com/">Facebook</a>,
            <a href="http://www.silverorange.com/">silverorange</a>,
            <a href="http://www.ning.com/">Ning</a>,
            <a href="http://roundcube.net/">Roundcube</a>,
            <a href="http://framework.zend.com/">Zend Framework</a>,
            <a href="http://www.symfony-project.org/">Symfony</a>

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
            Copyright © 2001-2010 The PEAR Group, all rights reserved. Bandwidth and
            hardware provided by Pair Networks. PEAR is a framework and distribution
            system for reusable PHP components. You can find out more information
            about PEAR in the <a href="#">online manual</a>.
            </p>

        </div>
    </div>
</div>

</body>

</html>

