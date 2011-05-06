<?php

namespace PEAR2\SimpleChannelFrontend;
use PEAR2\Pyrus\Channel;

class Search extends \FilterIterator implements \Countable
{
    public $query;

    public function __construct($options = array())
    {
        if (isset($options['q'])) {
            $this->query = $options['q'];
        }

        $channel = $options['frontend']->getChannel();

        parent::__construct(new \PEAR2\Pyrus\Channel\RemotePackages($channel));
    }

    public function accept()
    {
        if ($this->query == '') {
            $accept = false;
        } else {
            $accept = (bool)stristr($this->current()->name, $this->query);
        }

        return $accept;
    }

    public function count()
    {
        $count = 0;
        foreach ($this as $package) {
            $count++;
        }
        return $count;
    }

}
