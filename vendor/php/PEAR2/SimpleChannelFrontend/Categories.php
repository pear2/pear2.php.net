<?php
namespace PEAR2\SimpleChannelFrontend;
class Categories extends \PEAR2\Pyrus\Channel\RemoteCategories
{
    
    function __construct($options = array())
    {
        parent::__construct($options['frontend']::$channel);
    }
}