<?php
require_once dirname(__FILE__).'/../config.inc.php';
require_once dirname(__FILE__).'/../src/PEAR2Web/Router.php';

$channel = new \PEAR2\Pyrus\ChannelFile(__DIR__ . '/channel.xml');

$options = $_GET + PEAR2Web\Router::getRoute($_SERVER['REQUEST_URI']);

$frontend = new PEAR2\SimpleChannelFrontend\Main($channel, $options);

$savant = new PEAR2\Templates\Savant\Main();
$savant->setClassToTemplateMapper(new PEAR2\SimpleChannelFrontend\TemplateMapper);
$savant->setTemplatePath(array(__DIR__ . '/templates/default/html', __DIR__ . '/templates/pear2/html'));

switch($frontend->options['format']) {
case 'rss':
    $savant->addTemplatePath(__DIR__.'/templates/default/'.$frontend->options['format']);
    break;
}

$savant->setEscape('htmlspecialchars');
$savant->addFilters(array($frontend, 'postRender'));
echo $savant->render($frontend);

