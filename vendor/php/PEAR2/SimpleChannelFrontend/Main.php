<?php
/**
 * PEAR2\SimpleChannelFrontend\Main
 *
 * PHP version 5
 *
 * @category  Yourcategory
 * @package   PEAR2_SimpleChannelFrontend
 * @author    Your Name <handle@php.net>
 * @copyright 2009 Your Name
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://svn.php.net/repository/pear2/PEAR2_SimpleChannelFrontend
 */

/**
 * Main class for PEAR2_SimpleChannelFrontend
 *
 * @category  Yourcategory
 * @package   PEAR2_SimpleChannelFrontend
 * @author    Your Name <handle@php.net>
 * @copyright 2009 Your Name
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://svn.php.net/repository/pear2/PEAR2_SimpleChannelFrontend
 */
namespace PEAR2\SimpleChannelFrontend;
class Main
{
    /**
     * The channel object
     * @var Channel
     */
    public static $channel;
    
    static public $channel_path;
    
    public $page_title = '{page_title}';
    
    public $page_content;
    
    public $options = array('view'   => 'news',
                            'format' => 'html');
    
    protected static $view_map = array('news'        => 'PEAR2\SimpleChannelFrontend\News',
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

    public static $url = '';

    /**
     * Application title
     *
     * @var string
     */
    public static $title = 'Simple Channel Frontend';

    /**
     * Constructor
     *
     * @param \PEAR2\Pyrus\ChannelFile $channel The channel object
     * @param array                    $options Associative array of options
     */
    function __construct(\PEAR2\Pyrus\ChannelFileInterface $channel, $options = array())
    {
        static::setChannel($channel);
        $this->options = array_merge($this->options, $options);
        $this->preRun();
        try {
            $this->run();
        } catch(Exception $e) {
            $this->page_content = $e;
        }
    }

    function preRun()
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
     * Set the channel file for this frontend.
     * 
     * @param \PEAR2\Pyrus\IChanelFile $channel The channel object
     * 
     * @return void
     */
    public static function setChannel(\PEAR2\Pyrus\ChannelFileInterface $channel)
    {
        \PEAR2\Pyrus\Main::$downloadClass = __NAMESPACE__ . '\\Internet';
        \PEAR2\Pyrus\Config::current()->cache_dir = '/tmp';
        
        static::$channel = \PEAR2\Pyrus\Config::current()->channelregistry['pear2.php.net'];
        static::$channel_path = dirname($channel->path);

        $rest = str_replace('http://' . $channel->name,
                            '',
                            $channel->protocols->rest['REST1.0']->baseurl);
        
        Internet::addDirectory(static::$channel_path . '/get',
                               'http://' . $channel->name . '/get/');
        Internet::addDirectory(static::$channel_path . $rest,
                               $channel->protocols->rest['REST1.0']->baseurl);
        
        static::$channel->fromArray($channel->getArray());
    }
    
    /**
     * Determine which view to instantiate and set as the page content
     * 
     * @return mixed
     */
    function run()
    {
        if (!array_key_exists($this->options['view'], static::$view_map)) {
            throw new UnregisteredViewException('No view, or incorrect view specified.');
        }
        $class = static::$view_map[$this->options['view']];
        $options = array_merge($this->options, array('frontend'=>$this));
        $this->page_content = new $class($options);
    }
    
    /**
     * Register a new view for the channel.
     * 
     * @param string $route The route used to identify this model and view
     * @param string $class Class to instantiate when this view is requested.
     * 
     * @return Main
     */
    function registerView($route, $classname)
    {
        static::$view_map[$route] = $classname;
        return $this;
    }
    
    /**
     * Get the URL to a specific view
     * 
     * @param mixed $class What class to return a route for
     * 
     * @return string The url
     */
    public static function getURL($class = null)
    {
        static $default_view;
        
        if (empty($default_view)) {
            $main = new \ReflectionClass(__CLASS__);
            $properties = $main->getDefaultProperties();
            $default_view = $properties['options']['view'];
        }
        
        $url = static::$url;
        if ($class) {
            if (is_object($class)) {
                $class = get_class($class);
            }
            $route = array_keys(static::$view_map, $class);
            if (!count($route)) {
                throw new UnregisteredViewException('The view for that object is not registered');
            }

            if ($route[0] != $default_view) {
                $url .= '?view=' . $route[0];
            }

        }
        return $url;
    }
    
    /**
     * Called after the page is rendered to perform any necessary replacements.
     *
     * @param string $html The rendered template.
     *
     * @return string Filtered html
     */
    public function postRender($html)
    {
        $html = str_replace('{page_title}',
                            $this->page_title,
                            $html);
        return $html;
    }
}
