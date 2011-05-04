<?php
namespace PEAR2\SimpleChannelFrontend;
class PackageList extends \PEAR2\Pyrus\Channel\RemotePackages
{
    function __construct($options = array())
    {
        parent::__construct($options['frontend']::$channel);
    }
}
