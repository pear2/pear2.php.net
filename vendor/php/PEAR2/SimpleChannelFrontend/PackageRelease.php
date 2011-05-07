<?php
namespace PEAR2\SimpleChannelFrontend;
class PackageRelease
{
    public $_package;

    public function __construct($options = array())
    {
        $channel = $options['frontend']->getChannel();
        $this->_package = $channel->remotepackage[$options['package']];
        try {
            $this->_package->setRawVersion(
                null, array('release' => $options['packageVersion'])
            );
        } catch (\Exception $e) {
            throw new UnregisteredViewException($e->getMessage());
        }
    }

    public function __get($var)
    {
        return $this->_package->$var;
    }

    public function __call($method, $args)
    {
        return call_user_func_array(array($this->_package, $method), $args);
    }
}
