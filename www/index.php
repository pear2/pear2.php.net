<?php
require_once dirname(__FILE__).'/../config.inc.php';

$options = $_GET;

if (isset($_SERVER['REDIRECT_URL'])) {
    $options['view'] = 'package';
    preg_match('/\/(?<package>[0-9a-z_]+)(-(?<version>[0-9ab.]+))?$/i',
        $_SERVER['REDIRECT_URL'], $matches);
    $options['package'] = $matches['package'];

    if (isset($matches['version'])) {
        $options['packageVersion'] = $matches['version'];
        $options['view']           = 'release';
    }
}

$channel = new \PEAR2\Pyrus\ChannelFile(__DIR__ . '/channel.xml');

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
?>
