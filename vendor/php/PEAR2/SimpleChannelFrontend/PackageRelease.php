<?php
namespace PEAR2\SimpleChannelFrontend;
class PackageRelease
{
    public $_package;

    function __construct($options = array())
    {
        $this->_package = $options['frontend']::$channel->remotepackage[$options['package']];
        try {
            $this->_package->setRawVersion(
                null, array('release' => $options['packageVersion'])
            );
        } catch (\Exception $e) {
            throw new UnregisteredViewException($e->getMessage());
        }
    }

    function __get($var)
    {
        return $this->_package->$var;
    }

    function __call($method, $args)
    {
        return call_user_func_array(array($this->_package, $method), $args);
    }
}
