<?php
if (file_exists('config.inc.php')) {
    require_once 'config.inc.php';
} elseif (file_exists('channel.xml')) {
    $channel = new \PEAR2\Pyrus\ChannelFile('channel.xml');
} else {
    echo 'You must place this file in your channel server, or provide a config.inc.php file.';
    exit();
}

$options = $_GET;

preg_match('/\/(?<package>[0-9a-z_]+)(-(?<version>[0-9ab.]+))?$/i',
    $_SERVER['REQUEST_URI'], $matches);
if (isset($matches['package'])) {
    $options['view'] = 'package';
    $options['package'] = $matches['package'];

    if (isset($matches['version'])) {
        $options['packageVersion'] = $matches['version'];
        $options['view']           = 'release';
    }
}

$frontend = new PEAR2\SimpleChannelFrontend\Main($channel, $options);
$frontend->setURLBase('http://'.$channel->name.'/');
$frontend->init();

$savant = new PEAR2\Templates\Savant\Main();
$savant->setClassToTemplateMapper(new PEAR2\SimpleChannelFrontend\TemplateMapper);
$savant->setTemplatePath(array(__DIR__ . '/templates/html'));
$savant->addGlobal('frontend', $frontend);

switch($frontend->options['format']) {
case 'rss':
    $savant->addTemplatePath(__DIR__.'/templates/'.$frontend->options['format']);
    break;
}


$savant->setEscape('htmlspecialchars');
$savant->addFilters(array($frontend, 'postRender'));
echo $savant->render($frontend);
?>
