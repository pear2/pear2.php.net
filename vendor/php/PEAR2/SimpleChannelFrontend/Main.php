<?php

/**
 * \PEAR2\SimpleChannelFrontend\Main
 *
 * PHP version 5
 *
 * @category  PEAR2
 * @package   PEAR2_SimpleChannelFrontend
 * @author    Brett Bieber <saltybeagle@php.net>
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2009 Brett Biever, 2011 Michael Gauthier
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear2.php.net/PEAR2_SimpleChannelFrontend
 */

/**
 * Main class for \PEAR2\SimpleChannelFrontend
 *
 * @category  PEAR2
 * @package   PEAR2_SimpleChannelFrontend
 * @author    Brett Bieber <saltybeagle@php.net>
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2009 Brett Biever, 2011 Michael Gauthier
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://pear2.php.net/PEAR2_SimpleChannelFrontend
 */
namespace PEAR2\SimpleChannelFrontend;
class Main
{
    /**
     * The title of the current page
     *
     * @var string
     */
    public $page_title = '{page_title}';

    /**
     * The content of the current page
     *
     * @var string
     */
    public $page_content;

    /**
     * Options passed to the view
     *
     * @var array
     */
    public $options = array(
        'view'   => 'news',
        'format' => 'html',
    );

    /**
     * Application title
     *
     * @var string
     */
    public $title = 'Simple Channel Frontend';

    /**
     * The channel object
     *
     * @var \PEAR2\Pyrus\ChannelInterface
     *
     * @see \PEAR2\SimpleChannelFrontend::setChannel()
     * @see \PEAR2\SimpleChannelFrontend::getChannel()
     */
    protected $channel;

    /**
     * The channel path
     *
     * @var string
     *
     * @see \PEAR2\SimpleChannelFrontend::setChannel()
     * @see \PEAR2\SimpleChannelFrontend::getChannelPath()
     */
    protected $channel_path;

    /**
     * Map of view routes to view classes
     *
     * @var array
     *
     * @see \PEAR2\SimpleChannelFrontend::registerView()
     */
    protected $view_map = array(
        'news'        => 'PEAR2\SimpleChannelFrontend\News',
        'packages'    => 'PEAR2\SimpleChannelFrontend\PackageList',
        'package'     => 'PEAR2\SimpleChannelFrontend\Package',
        'release'     => 'PEAR2\SimpleChannelFrontend\PackageRelease',
        'latest'      => 'PEAR2\SimpleChannelFrontend\LatestReleases',
        'categories'  => 'PEAR2\SimpleChannelFrontend\Categories',
        'category'    => 'PEAR2\SimpleChannelFrontend\Category',
        'support'     => 'PEAR2\SimpleChannelFrontend\Support',
        'search'      => 'PEAR2\SimpleChannelFrontend\Search',
        'filebrowser' => 'PEAR2\SimpleChannelFrontend\ReleaseFileBrowser',
    );

    /**
     * The base URL of the frontend
     *
     * @var string
     *
     * @see \PEAR2\SimpleChannelFrontend::getURL()
     */
    protected $url_base = '';

    /**
     * Creates a new simple channel frontend
     *
     * @param \PEAR2\Pyrus\ChannelFile $channel the channel object.
     * @param array                    $options an associative array of options.
     */
    public function __construct(
        \PEAR2\Pyrus\ChannelFileInterface $channel,
        $options = array()
    ) {
        $this->setChannel($channel);
        $this->options = array_merge($this->options, $options);
    }

    /**
     * Instantiates the appropriate page object for the current request
     *
     * @return void
     */
    public function init()
    {
        $this->preRun();
        try {
            $this->run();
        } catch(Exception $e) {
            $this->page_content = $e;
        }
    }

    /**
     * Registers a new view for the channel
     *
     * @param string $route     the route used to identify this model and view.
     * @param string $classname the class to instantiate when the specified
     *                          view is requested.
     *
     * @return \PEAR2\SimpleChannelFrontend\Main the current class for fluent
     *                                           interface.
     */
    public function registerView($route, $classname)
    {
        $this->view_map[$route] = $classname;
        return $this;
    }

    /**
     * Sets the channel file for this frontend
     *
     * @param \PEAR2\Pyrus\ChanelFileInterface $channel The channel object.
     *
     * @return \PEAR2\SimpleChannelFrontend\Main the current class for fluent
     *                                           interface.
     */
    public function setChannel(\PEAR2\Pyrus\ChannelFileInterface $channel)
    {
        \PEAR2\Pyrus\Main::$downloadClass = __NAMESPACE__ . '\\Internet';
        \PEAR2\Pyrus\Config::current()->cache_dir = '/tmp';

        $config = \PEAR2\Pyrus\Config::current();

        $this->channel      = $config->channelregistry['pear2.php.net'];
        $this->channel_path = dirname($channel->path);

        $rest = str_replace(
            'http://' . $channel->name,
            '',
            $channel->protocols->rest['REST1.0']->baseurl
        );

        Internet::addDirectory(
            $this->channel_path . '/get',
            'http://' . $channel->name . '/get/'
        );

        Internet::addDirectory(
            $this->channel_path . $rest,
            $channel->protocols->rest['REST1.0']->baseurl
        );

        $this->channel->fromArray($channel->getArray());

        return $this;
    }

    /**
     * Gets this frontend's PEAR channel
     *
     * @return \PEAR2\Pyrus\ChannelInterface this frontend's PEAR channel.
     *
     * @return \PEAR2\SimpleChannelFrontend\Main the current class for fluent
     *                                           interface.
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * Gets the path to this frontend's PEAR channel
     *
     * @return string the path to this frontend's channel
     *
     * @see \PEAR2\SimpleChannelFrontend\Main::setChannel()
     */
    public function getChannelPath()
    {
        return $this->channel_path;
    }

    /**
     * Sets appropriate HTTP headers before the page is rendered
     *
     * @return void
     */
    protected function preRun()
    {
        switch ($this->options['format']) {
        case 'rss':
            header('Content-type:text/xml');
            break;
        case 'html':
        default:
            header('Content-Type:text/html; charset=UTF-8');
            break;
        }
    }

    /**
     * Determines and instantiates the page class
     *
     * The instantiated page class is set as the page content.
     *
     * @return void
     */
    protected function run()
    {
        if (!array_key_exists($this->options['view'], $this->view_map)) {
            throw new UnregisteredViewException(
                'No view, or incorrect view specified.'
            );
        }

        $class = $this->view_map[$this->options['view']];
        $options = array_merge($this->options, array('frontend' => $this));
        $this->page_content = new $class($options);
    }

    /**
     * Gets the URL for a view
     *
     * @param mixed $class optional. The class for which to return a route. If
     *                     not specified, the current URL is returned.
     *
     * @return string the URL.
     */
    public function getURL($class = null)
    {
        static $default_view;

        if (empty($default_view)) {
            $main         = new \ReflectionClass(__CLASS__);
            $properties   = $main->getDefaultProperties();
            $default_view = $properties['options']['view'];
        }

        $url = $this->url_base;
        if ($class) {
            if (is_object($class)) {
                $class = get_class($class);
            }
            $route = array_keys($this->view_map, $class);
            if (!count($route)) {
                throw new UnregisteredViewException(
                    'The view for that object is not registered.'
                );
            }

            if ($route[0] != $default_view) {
                $url .= '?view=' . $route[0];
            }

        }
        return $url;
    }

    /**
     * Sets the base URL for this frontend
     *
     * @param string $url the base url for this frontend.
     *
     * @return \PEAR2\SimpleChannelFrontend\Main the current class for fluent
     *                                           interface.
     */
    public function setURLBase($url)
    {
        $this->url_base = $url;
    }

    /**
     * Performs necessary replacements after the page is rendered
     *
     * @param string $html The rendered template.
     *
     * @return string Filtered html.
     */
    public function postRender($html)
    {
        return str_replace(
            '{page_title}',
            $this->page_title,
            $html
        );
    }
}
