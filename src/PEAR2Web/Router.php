<?php

namespace PEAR2Web;

class Router
{
    public static function getRoute($requestURI)
    {
        if (!empty($_SERVER['QUERY_STRING'])) {
            $requestURI = substr($requestURI, 0, strlen($_SERVER['QUERY_STRING'])*-1-1);
        }

        $base   = \PEAR2\SimpleChannelFrontend\Main::getURL();
        $q_base = preg_quote($base, '/');

        $options = array();

        switch(true) {
            case ($requestURI == $base):
                // Short circuit
                $options['view'] = 'news';
                break;
            case ($requestURI == $base . 'categories/'):
                $options['view'] = 'categories';
                break;
            case ($requestURI == $base . 'packages/'):
                $options['view'] = 'packages';
                break;
            case ($requestURI == $base . 'support/'):
                $options['view'] = 'support';
                break;

            case preg_match('/'.$q_base.'(?<package>[0-9a-z_]+)(-(?<version>[0-9ab.]+))?$/i',
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
