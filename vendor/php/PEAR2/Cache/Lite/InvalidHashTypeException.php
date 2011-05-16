<?php

namespace PEAR2\Cache\Lite;

class InvalidHashTypeException
    extends \InvalidArgumentException
    implements Exception
{
    protected $hashType;

    public function __construct($message, $code = 0, $hashType = '')
    {
        parent::__construct($message, $code);
        $this->hashType = $hashType;
    }

    public function getHashType()
    {
        return $this->hashType;
    }
}
