<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

if (!file_exists(__DIR__ . '/../config.inc.php')) {
    echo '<pre>';
    include __DIR__ . '/../README';
    echo '</pre>';
    exit(0);
}

require_once __DIR__ . '/../src/PEAR2Web/Config.php';
require_once __DIR__ . '/../config.inc.php';

require_once __DIR__ . '/../src/PEAR2Web/Router.php';
require_once __DIR__ . '/../src/PEAR2Web/License.php';
require_once __DIR__ . '/../src/PEAR2Web/Menu.php';
require_once __DIR__ . '/../src/PEAR2Web/TemplateMapper.php';
require_once __DIR__ . '/../src/PEAR2Web/Models/Package.php';

// Set preferred state to devel, so pyrus can get info on all releases
\PEAR2\Pyrus\Config::current()->preferred_state = 'devel';

// Set 'force' option so we can get info about packages we can't actually
// install on the Web server hosting PEAR2Web.
\PEAR2\Pyrus\Main::$options['force'] = true;

$channel = new \PEAR2\Pyrus\ChannelFile(__DIR__ . '/channel.xml');

$baseURI = \PEAR2Web\Config::$options['url'];
$options = $_GET + \PEAR2Web\Router::getRoute($baseURI, $_SERVER['REQUEST_URI']);

$frontend = new \PEAR2\SimpleChannelFrontend\Main($channel, $options);
$frontend->registerView('package', 'PEAR2Web\Models\Package');
$frontend->title = \PEAR2Web\Config::$options['title'];
$frontend->setURLBase(\PEAR2Web\Config::$options['url']);
$frontend->init();

$savant = new \PEAR2\Templates\Savant\Main();
$savant->addGlobal('frontend', $frontend);
$savant->setClassToTemplateMapper(new \PEAR2Web\TemplateMapper());
$savant->setTemplatePath(
    array(
        __DIR__ . '/../vendor/www/pear2.php.net/PEAR2_SimpleChannelFrontend/templates/html/',
        __DIR__ . '/templates/pear2/html',
    )
);

switch($frontend->options['format']) {
    case 'partial':
        \PEAR2Web\TemplateMapper::$output_template['PEAR2\\SimpleChannelFrontend\\Main'] = 'Main-partial';
        break;
    case 'rss':
	    $savant->addTemplatePath(
	        __DIR__ . '/../vendor/www/pear2.php.net/PEAR2_SimpleChannelFrontend/templates/rss/'
	    );
	    break;
}

$savant->setEscape('htmlspecialchars');
$savant->addFilters(array($frontend, 'postRender'));
echo $savant->render($frontend);

