<?php
namespace PEAR2\SimpleChannelFrontend;
class Package implements \IteratorAggregate
{
    /**
     * The actual package object.
     * @var \PEAR2\Pyrus\Package\Remote
     */
    public $_package;
    
    function __construct($options = array())
    {
        $this->_package = $options['frontend']::$channel->remotepackage[$options['package']];
        $this->rewind();
        $this->_package->setRawVersion(null, array('release'=>$this->key()));
    }
    
    function __get($var)
    {
        return $this->_package->$var;
    }
    
    function __call($method, $args)
    {
        return call_user_func_array(array($this->_package, $method), $args);
    }
    
    function getIterator()
    {
        return $this->_package;
    }
}
