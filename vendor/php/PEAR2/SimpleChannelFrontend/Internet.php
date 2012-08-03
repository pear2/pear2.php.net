<?php
/**
 * Simulate the Internet
 */
namespace PEAR2\SimpleChannelFrontend;
class Internet extends \PEAR2\HTTP\Request
{

    /**
     * sets up the adapter
     */
    public function __construct($url = null)
    {
        $this->adapter = new \PEAR2\HTTP\Request\Adapter\Filesystem($this);
        if ($url) {
            $this->url = $url;
        }
    }

    static function addDirectory($dir, $urlbase)
    {
        \PEAR2\HTTP\Request\Adapter\Filesystem::addDirectory($dir, $urlbase);
    }
}