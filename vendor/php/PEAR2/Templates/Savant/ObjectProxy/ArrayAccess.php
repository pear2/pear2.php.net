<?php
namespace PEAR2\Templates\Savant\ObjectProxy;
use PEAR2\Templates\Savant\ObjectProxy;
class ArrayAccess extends ObjectProxy implements \ArrayAccess
{
    function offsetExists($offset)
    {
        return $this->object->offsetExists($offset);
    }
    
    function offsetGet($offset)
    {
        return $this->filterVar($this->object->offsetGet($offset));
    }
    
    function offsetSet($offset, $value)
    {
        $this->object->offsetSet($offset, $value);
    }
    
    function offsetUnset($offset)
    {
        $this->object->offsetUnset($offset);
    }
}