<?php

namespace PEAR2\SimpleChannelFrontend;

class ReleaseFileBrowser
{
    public $package;

    public $options;

    public $releaseFile;

    public $file;

    public function __construct($options = array())
    {
        $channel       = $options['frontend']->getChannel();
        $this->package = $channel->remotepackage[$options['package']];

        if (   isset($options['packageVersion'])
            && $options['packageVersion'] != ''
        ) {
            // try to set specified version
            try {
                $this->package->setRawVersion(
                    null,
                    array('release' => $options['packageVersion'])
                );
            } catch (\Exception $e) {
                throw new UnregisteredViewException($e->getMessage());
            }
        } else {
            // set lastest release version
            $this->package->rewind();
            $this->package->setRawVersion(
                null,
                array('release' => $this->package->key())
            );
        }

        $releaseFile = $this->package->name . '-'
            . $this->package->version['release'] . '.tgz';


        $root = rtrim(
            $options['frontend']->getChannelPath(),
            DIRECTORY_SEPARATOR
        );
        $root = $root . DIRECTORY_SEPARATOR . 'get';
        $file = $root . DIRECTORY_SEPARATOR . $releaseFile;

        if (!file_exists($file) || dirname($file) != $root) {
            throw new \Exception('Cannot find the package ' . $file . '.');
        }

        $this->releaseFile = new ReleaseFileBrowser\FilteredIterator(new \PharData($file));

        if (isset($options['file'])) {
            $file = 'phar://' . $file . '/' . $options['file'];
            if (file_exists($file)) {
                $this->file = new \SplFileObject($file);
            }
        }

        $this->options = $options;

    }

}
