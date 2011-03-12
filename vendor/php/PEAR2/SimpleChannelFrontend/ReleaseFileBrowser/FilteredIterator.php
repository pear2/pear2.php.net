<?php
namespace PEAR2\SimpleChannelFrontend\ReleaseFileBrowser;

class FilteredIterator extends \RecursiveFilterIterator
{
    function accept()
    {
        return !($this->getInnerIterator()->getBasename() == '.xmlregistry');
    }
}