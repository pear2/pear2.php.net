<?php
if (file_exists('config.inc.php')) {
    require_once 'config.inc.php';
} elseif (file_exists('channel.xml')) {
    $config = PEAR2\Pyrus\Config::singleton('/tmp');
    $config->cache_dir = '/tmp';
    $channel = new \PEAR2\Pyrus\ChannelFile('channel.xml');
} else {
    echo 'You must place this file in your channel server, or provide a config.inc.php file.';
    exit();
}

if (!isset($url)) {
    $url = 'http://'.$channel->name.'/';
}

$options = $_GET + \PEAR2\SimpleChannelFrontend\Router::getRoute($url, $_SERVER['REQUEST_URI']);

$frontend = new PEAR2\SimpleChannelFrontend\Main($channel, $options);
$frontend->setURLBase($url);
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

