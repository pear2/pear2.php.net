<?php

namespace PEAR2Web;

class Router
{
    public static function getRoute($baseURI, $requestURI)
    {
        $options = array();

        if (!empty($_SERVER['QUERY_STRING'])) {
            $requestURI = substr(
                $requestURI,
                0,
                -strlen($_SERVER['QUERY_STRING']) - 1
            );
        }

        // Trim the base part of the URL, leaving just the path
        $requestURI = substr(
            $requestURI,
            strlen(
                parse_url(
                    $baseURI,
                    PHP_URL_PATH
                )
            )
        );

        $packageExp = "/"
            . "^\n"
            . "(?<package>[0-9a-z_]+)     # package name\n"
            . "(-                         # dash separator\n"
            . "    (?<version>[0-9ab.]+)  # version\n"
            . ")?                         # ... is optional\n"
            . "$\n"
            . "/xi";

        $categoryExp = "/"
            . "^\n"
            . "categories\/               # base\n"
            . "(?<category>[0-9a-z_\ -]+) # category name\n"
            . "$\n"
            . "/xi";

        $fileExp = "/"
            . "^\n"
            . "(?<package>[0-9a-z_]+)     # package name\n"
            . "(-                         # dash separator\n"
            . "    (?<version>[0-9ab.]+)  # version\n"
            . ")?                         # ... is optional\n"
            . "\/files                    # file view\n"
            . "(\/                        # file path separator\n"
            . "    (?<file>.*)            # file path\n"
            . ")?                         # file path is optional\n"
            . "$\n"
            . "/xi";

        if (empty($requestURI)) {
            $options['view'] = 'news';
        } elseif ($requestURI === 'search/'
            || $requestURI === 'search'
        ) {
            $options['view'] = 'search';
        } elseif ($requestURI === 'categories/') {
            $options['view'] = 'categories';
        } elseif ($requestURI === 'support/') {
            $options['view'] = 'support';
        } elseif (preg_match($categoryExp, $requestURI, $matches) === 1) {

            // Viewing an individual category
            $options['view']     = 'category';
            $options['category'] = $matches['category'];

        } elseif (preg_match($packageExp, $requestURI, $matches) === 1) {

            // Viewing an individual package
            $options['view']    = 'package';
            $options['package'] = $matches['package'];

            // Release selected
            if (isset($matches['version'])) {
                $options['view']           = 'release';
                $options['packageVersion'] = $matches['version'];
            }

        } elseif (preg_match($fileExp, $requestURI, $matches) === 1) {

            // Viewing release files
            $options['view']    = 'filebrowser';
            $options['package'] = $matches['package'];

            // Release selected
            if (isset($matches['version']) && $matches['version'] != '') {
                $options['packageVersion'] = $matches['version'];
            }

            // File browser selected
            if (isset($matches['file']) && $matches['file'] != '') {
                $options['file'] = $matches['file'];
            }

        } else {
            $options['view'] = '404';
        }

        return $options;
    }
}
