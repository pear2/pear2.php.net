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
                <h2>Who’s Using PEAR?</h2>
                <div>
                    <a href="http://digg.com/api/docs/toolkits">Digg</a> •
                    <a href="http://www.easybib.com/">EasyBib</a> •
                    <a href="http://www.echolibre.com/">echolibre</a> •
                    <a href="http://www.netresearch.de/">Netresearch</a> •
                    <a href="http://orchestra.io/">Orchestra</a> •
                    <a href="http://code.silverorange.com/">silverorange</a> •
                    <a href="http://www.symfony-project.org/">Symfony</a> •
                    <a href="http://pear.unl.edu/">University of Nebraska-Lincoln</a>
                </div>
            </div>

        </div>
    </div>

    <div id="bottom">
        <div class="content clearfix">

            <div class="left">
                <h2>Get Started With Pyrus</h2>
                <a href="http://pear.php.net/manual/en/pyrus.php">Pyrus</a> is a tool to manage PEAR packages. Pyrus simplifies and improves the PEAR experience.
                <div id="download">
                    <a class="button" href="http://pear2.php.net/pyrus.phar">Download Pyrus ↴</a>
                </div>
                After downloading, try out Pyrus using the commands on the right. You can learn more in the <a href="http://pear.php.net/manual/en/pyrus.php">Pyrus manual</a>.
            </div>

            <div class="right">
                <div class="package-install-instructions">
                    <div class="package-install-instructions-section">
                        <div># Set your repository location:</div>
                        <div>
                            <span class="package-install-prompt">$</span>
                            <strong>php pyrus.phar mypear</strong> ~/src/my-project/pear
                        </div>
                    </div>
                    <div class="package-install-instructions-section">
                        <div># Install a package:</div>
                        <div>
                            <span class="package-install-prompt">$</span>
                            <strong>php pyrus.phar install</strong> PEAR2_HTTP_Request
                        </div>
                    </div>
                    <div class="package-install-instructions-section">
                        <div># List installed packages:</div>
                        <div>
                            <span class="package-install-prompt">$</span>
                            <strong>php pyrus.phar list-packages</strong>
                        </div>
                    </div>
                </div>
            </div>

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

