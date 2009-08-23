<?php
/**
 * Simulate the Internet
 */
class Internet extends PEAR2_HTTP_Request
{

    /**
     * sets up the adapter
     */
    public function __construct($url = null) 
    {
        $this->adapter = new PEAR2_HTTP_Request_Adapter_Filesystem($this);
        if ($url) {
            $this->url = $url;
        }
    }

    static function addDirectory($dir, $urlbase)
    {
        PEAR2_HTTP_Request_Adapter_Filesystem::addDirectory($dir, $urlbase);
    }
}