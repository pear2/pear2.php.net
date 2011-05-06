<?php
namespace PEAR2\SimpleChannelFrontend;
class Package implements \IteratorAggregate
{
    /**
     * The actual package object.
     * @var \PEAR2\Pyrus\Package\Remote
     */
    public $_package;

    public function __construct($options = array())
    {
        $channel = $options['frontend']->getChannel();
        $this->_package = $channel->remotepackage[$options['package']];
        $this->rewind();
        $this->_package->setRawVersion(null, array('release' => $this->key()));
    }

    public function __get($var)
    {
        return $this->_package->$var;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->_package, $method), $args);
    }

    public function getIterator()
    {
        return $this->_package;
    }
}
