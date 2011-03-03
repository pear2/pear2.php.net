<?php
if (file_exists('config.inc.php')) {
    require_once 'config.inc.php';
} elseif (file_exists('channel.xml')) {
    $channel = new \pear2\Pyrus\ChannelFile('channel.xml');
    pear2\SimpleChannelFrontend\Main::$url = 'http://'.$channel->name.'/';
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

$frontend = new pear2\SimpleChannelFrontend\Main($channel, $options);

$savant = new pear2\Templates\Savant\Main();
$savant->setClassToTemplateMapper(new pear2\SimpleChannelFrontend\TemplateMapper);
$savant->setTemplatePath(array(__DIR__ . '/templates'));
$savant->setEscape('htmlspecialchars');
$savant->addFilters(array($frontend, 'postRender'));
echo $savant->render($frontend);
?>
