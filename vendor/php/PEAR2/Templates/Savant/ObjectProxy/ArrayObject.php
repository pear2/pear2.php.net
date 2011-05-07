<?php

/**
 * PEAR2\Templates\Savant\ObjectProxy\ArrayObject
 *
 * PHP version 5
 *
 * @category  Templates
 * @package   PEAR2_Templates_Savant
 * @author    Brett Bieber <saltybeagle@php.net>
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2009 Brett Bieber, 2011 Michael Gauthier
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://svn.php.net/repository/pear2/PEAR2_Templates_Savant
 */

/**
 * Proxies ArrayObject objects
 *
 * Filters on array access or on traversal.
 *
 * @category  Templates
 * @package   PEAR2_Templates_Savant
 * @author    Brett Bieber <saltybeagle@php.net>
 * @author    Michael Gauthier <mike@silverorange.com>
 * @copyright 2009 Brett Bieber, 2011 Michael Gauthier
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://svn.php.net/repository/pear2/PEAR2_Templates_Savant
 */
namespace PEAR2\Templates\Savant\ObjectProxy;
use PEAR2\Templates\Savant\ObjectProxy;
class ArrayObject
    extends ArrayAccess
    implements \ArrayAccess, \Countable, \Serializable, \IteratorAggregate
{
    public function getIterator()
    {
        return $this->object->getIterator();
    }

    public function next()
    {
        $this->object->next();
    }

    public function key()
    {
        return $this->object->key();
    }

    public function valid()
    {
        return $this->object->valid();
    }

    public function rewind()
    {
        $this->object->rewind();
    }

    public function current()
    {
        return $this->filterVar($this->object->current());
    }

    public function count()
    {
        return count($this->object);
    }

    public function serialize()
    {
        return serialize($this->object);
    }

    public function unserialize($string)
    {
        $object = unserialize($string);
        if ($object !== false) {
            $this->object = $object;
        }
    }
}
