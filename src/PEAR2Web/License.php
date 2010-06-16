<?php

namespace PEAR2Web;

class License
{
    public static $data = array(

        'apache' => array(
            'title'    => 'Apache 2.0',
            'synonyms' => array(
                'apache',
                'apache 2.0',
                'apache license',
                'apache license 2.0',
                'apache license, version 2.0',
                'the apcahe 2.0 license',
            ),
            'valid'    => true,
            'link'     => 'http://www.opensource.org/licenses/apache2.0.php',
        ),

        'bsd' => array(
            'title'    => 'BSD',
            'synonyms' => array(
                'bsd',
                'bsd (3 clause)',
                'new bsd',
                'new bsd license',
                'the bsd license',
                'bsd license',
                'modified bsd license',
                'bsd style',
                'bsd-style',
                'bsd, revised',
            ),
            'valid'    => true,
            'link'     => 'http://www.opensource.org/licenses/bsd-license.php',
        ),

        'gpl' => array(
            'title'    => 'GPL',
            'synonyms' => array(
                'gpl',
            ),
            'valid'    => false,
            'link'     => 'http://www.gnu.org/copyleft/gpl.html',
        ),

        'lgpl' => array(
            'title'    => 'LGPL',
            'synonyms' => array(
                'lgpl',
                'lgpl license',
                'gnu lgpl',
            ),
            'valid'    => true,
            'link'     => 'http://www.gnu.org/copyleft/lesser.html',
        ),

        'lgpl-2' => array(
            'title'    => 'LGPL 2.1',
            'synonyms' => array(
                'lgpl2',
                'lgpl 2.1',
                'lgplv2.1',
                'lgpl version 2.1',
            ),
            'valid'    => true,
            'link'     => 'http://www.gnu.org/licenses/lgpl-2.1.html',
        ),

        'lgpl-3' => array(
            'title'    => 'LGPL 3.0',
            'synonyms' => array(
                'lgpl3',
                'lgpl 3.0',
                'lgplv3 license',
                'lgpl version 3.0',
            ),
            'valid'    => true,
            'link'     => 'http://www.gnu.org/licenses/lgpl-3.0.html',
        ),

        'mit' => array(
            'title'    => 'MIT',
            'synonyms' => array(
                'mit',
                'mit license',
                'mit / beerware',
            ),
            'valid'    => true,
            'link'     => 'http://www.opensource.org/licenses/mit-license.php',
        ),

        'php' => array(
            'title'    => 'PHP',
            'synonyms' => array(
                'php',
                'php license',
                'php license 4.0',
            ),
            'valid'    => false,
            'link'     => 'http://www.php.net/license',
        ),

        'php-2' => array(
            'title'    => 'PHP 2.02',
            'synonyms' => array(
                'php 2.02',
                'php license 2.02',
            ),
            'valid'    => false,
            'link'     => 'http://www.php.net/license/2_02.txt',
        ),

        'php-3' => array(
            'title'    => 'PHP 3.01',
            'synonyms' => array(
                'php 3.0',
                'php 3.01',
                'php license v3.0',
                'php license 3.0',
                'php license 3.01',
            ),
            'valid'    => false,
            'link'     => 'http://www.php.net/license/3_01.txt',
        ),

        'w3c' => array(
            'title'    => 'W3C',
            'synonyms' => array(
                'w3c',
            ),
            'valid'    => false,
            'link'     => 'http://www.w3.org/Consortium/Legal/2002/copyright-software-20021231',
        ),

    );

    public static function getLink($license)
    {
        $link  = null;
        $info  = self::find($license);

        if ($info !== null) {
            $link = $info['link'];
        }

        return $link;
    }

    public static function isValid($license)
    {
        $valid = false;
        $info  = self::find($license);

        if ($info !== null) {
            $valid = $info['valid'];
        }

        return $valid;
    }

    protected static function find($license)
    {
        static $map = null;

        if ($map === null) {
            $map = array();
            foreach (self::$data as $key => $info) {
                foreach ($info['synonyms'] as $synonym) {
                    $map[$synonym] = $key;
                }
            }
        }

        $info = null;
        $key  = strtolower($license);

        if (isset($map[$key])) {
            $info = self::$data[$map[$key]];
        }

        return $info;
    }
}
