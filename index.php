<?php
require_once 'config.inc.php';

$options = $_GET;

if (isset($_SERVER['REDIRECT_URL'])) {
    $options['view']    = 'package';
    $options['package'] = substr($_SERVER['REDIRECT_URL'],
                                 strrpos($_SERVER['REDIRECT_URL'], '/'));
}

$channel = new \pear2\Pyrus\ChannelFile(__DIR__ . '/channel.xml');

$frontend = new pear2\SimpleChannelFrontend\Main($channel, $options);

$savant = new pear2\Templates\Savant\Main();
$savant->setClassToTemplateMapper(new pear2\SimpleChannelFrontend\TemplateMapper);
$savant->setTemplatePath(array(__DIR__ . '/templates/default', __DIR__ . '/templates/pear2'));
$savant->setEscape('htmlspecialchars');
$savant->addFilters(array($frontend, 'postRender'));
echo $savant->render($frontend);
?>
