<?php
namespace PEAR2\SimpleChannelFrontend;
class Category implements \IteratorAggregate, \ArrayAccess, \Countable
{
    /**
     * @var \PEAR2\Pyrus\Channel\RemoteCategory
     */
    protected $_category;

    public function __construct($options = array())
    {
        $channel = $options['frontend']->getChannel();
        $this->_category = $channel->remotecategories[$options['category']];
        $this->rewind();
    }

    public function __get($var)
    {
        return $this->_category->$var;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->_category, $method), $args);
    }

    public function getIterator()
    {
        return $this->_category;
    }

    public function offsetExists($key)
    {
        return $this->_category->offsetExists($key);
    }

    public function offsetGet($key)
    {
        return $this->_category->offsetGet($key);
    }

    public function offsetSet($key, $value)
    {
        return $this->_category->offsetSet($key, $value);
    }

    public function offsetUnset($key)
    {
        return $this->_category->offsetUnset($key);
    }

    public function count()
    {
        return $this->_category->count();
    }
}
