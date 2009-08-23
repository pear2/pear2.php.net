<?php 
class WebFrontend_Package
{
    public $package;
    
    public $releases = array();
    
    function __construct($channel, $package)
    {
        Internet::addDirectory($channel->file->getPath(),
                       'http://pear2.php.net/');
        \pear2\Pyrus\Main::$downloadClass = 'Internet';
        \pear2\Pyrus\Config::current()->cache_dir = '/tmp';
        $chan = \pear2\Pyrus\Config::current()->channelregistry['pear2.php.net'];
        $this->package = $chan->remotepackage[$package];
        foreach ($chan->remotepackage[$package] as $version => $release) {
            $this->releases[$version] = $release;
        }
    }
}
?>