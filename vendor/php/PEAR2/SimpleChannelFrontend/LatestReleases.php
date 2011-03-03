<?php
namespace PEAR2\SimpleChannelFrontend;
use PEAR2\Pyrus\Channel;

class LatestReleases extends \ArrayIterator
{
    public $options = array(
                        'limit'  => 10,
                        'offset' => 0);

    function __construct($options = array())
    {

        $this->options = $options + $this->options;

        $packages = array();

        foreach (new \PEAR2\Pyrus\Channel\RemotePackages($options['frontend']::$channel) as $package)
        {
            foreach ($package as $version=>$info) {
                $packages[$package->date.' '.$package->time] = array('packageVersion'=>$version, 'package'=>$package->name);
            }
        }

        krsort($packages);

        if (isset($this->options['limit'])) {
            $packages = array_slice($packages, $this->options['offset'], $this->options['limit']);
        }

        parent::__construct($packages);
    }

    function current()
    {
        return new PackageRelease(parent::current() + array('frontend'=>$this->options['frontend']));
    }
}
