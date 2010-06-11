<?php
namespace pear2web;
class Router
{
    public static function getRoute($requestURI)
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            $requestURI = substr($requestURI, 0, strlen($_SERVER['QUERY_STRING'])*-1-1);
        }

        $base = preg_quote(\PEAR2\SimpleChannelFrontend\Main::getURL(), '/');

        $options = array();

        switch(true) {
            case ($requestURI == '/'):
                // Short circuit
                $options['view'] = 'News';
                break;

            case preg_match('/\/(?<package>[0-9a-z_]+)(-(?<version>[0-9ab.]+))?$/i',
                    $requestURI, $matches):

                // Viewing an individual package
                $options['view']    = 'package';
                $options['package'] = $matches['package'];

                // Release selected
                if (isset($matches['version'])) {
                    $options['view']           = 'release';
                    $options['packageVersion'] = $matches['version'];
                }
                break;
        }

        return $options;
    }
}