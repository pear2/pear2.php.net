<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title><?php echo $context->page_title; ?></title>
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.8.0r4/build/reset-fonts/reset-fonts.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/main.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/news.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/search-form.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/categories.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/category.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/package.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/package-list.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/search.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/file-browser.css" />
    <link rel="stylesheet" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>css/highlight-idea.css" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script src="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>js/pearweb.js"></script>
    <script src="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>js/highlight.pack.js"></script>

    <link rel="alternate" title="PEAR2 Latest Releases" type="application/rss+xml" href="<?php echo PEAR2\SimpleChannelFrontend\Main::getURL(); ?>?view=latest&amp;format=rss" />
</head>

<body>

<div id="header">

    <div id="top">
        <div class="content clearfix">
<?php

echo $savant->render(new PEAR2Web\Menu(), 'MenuHead.tpl.php');

?>
        </div>
    </div>

    <?php if ($context->options['view'] == 'news'): ?>

    <div id="mid">
        <div class="content clearfix">

            <div class="left">
                <h2>What is PEAR?</h2>
                PEAR is a packaging and distribution system for reusable PHP components. You can find more information about using PEAR in the <a href="http://pear.php.net/manual/">online manual</a>.
            </div>

            <div class="right">
                <h2>Download Pyrus <span>New for PHP 5.3.1+!</span></h2>
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
        …
            <a href="http://digg.com/api/docs/toolkits">Digg</a>,
            <a href="http://www.doctrine-project.org/">Doctrine</a>,
            <a href="http://ezcomponents.org/">eZ Components</a>,
            <a href="http://roundcube.net/">Roundcube</a>,
            <a href="http://code.google.com/p/sabredav/wiki/Installation">SabreDAV</a>,
            <a href="http://code.silverorange.com/">silverorange</a>,
            <a href="http://www.symfony-project.org/">Symfony</a>,
            <a href="http://framework.zend.com/">Zend Framework</a>
        …
        </div>
    </div>

    <?php endif; ?>

</div>

<div id="content">
    <div class="content clearfix view-<?php echo $context->options['view']; ?>">
        <?php echo $savant->render($context->page_content); ?>
    </div>
</div>

<div id="footer">
    <div class="content">

        <div id="footer-left">

<?php

echo $savant->render(new PEAR2Web\Menu(), 'MenuFoot.tpl.php');

?>

            <p class="note">
            Copyright © 2001-2010 The PEAR Group, all rights reserved. Bandwidth and
            hardware provided by <a href="http://www.pair.com/">pair Networks</a>.
            Site design provided by <a href="http://www.silverorange.com">silverorange</a>.
            PEAR is a framework and distribution system for reusable PHP components. You
            can find out more information about PEAR in the
            <a href="http://pear.php.net/manual/">online manual</a>.
            </p>

        </div>
    </div>
</div>

</body>

</html>

