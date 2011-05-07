<?php

namespace PEAR2Web\Models;

class Package extends \PEAR2\SimpleChannelFrontend\Package
{
    public function getBugs()
    {
        return 'no bugs';
    }
}
