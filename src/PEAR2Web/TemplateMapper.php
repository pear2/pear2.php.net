<?php

namespace PEAR2Web;

class TemplateMapper extends \PEAR2\SimpleChannelFrontend\TemplateMapper
{
    public function map($class)
    {
        switch ($class) {
        case 'PEAR2Web\Models\Package':
            return parent::map('PEAR2\SimpleChannelFrontend\Package');
        default:
            return parent::map($class);
        }
    }
}
