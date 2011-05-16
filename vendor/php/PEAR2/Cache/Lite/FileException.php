<?php

namespace PEAR2\Cache\Lite;

class FileException extends \Exception implements Exception
{
    protected $filePath;

    public function __construct($message, $code = 0, $filePath = '')
    {
        parent::__construct($message, $code);
        $this->filePath = $filePath;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }
}
