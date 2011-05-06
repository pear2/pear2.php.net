<?php
namespace PEAR2\SimpleChannelFrontend;
class TemplateMapper extends \PEAR2\Templates\Savant\ClassToTemplateMapper
{
    static protected $templatePath = '@www_dir@';

    function __construct()
    {
        if (self::$templatePath === '@'.'www_dir@') {
            // running from svn, or extracted from archive
            if (strpos(__FILE__, 'trunk/src/SimpleChannelFrontend')) {
                // running from svn
                self::$templatePath = __DIR__ . '/../../www/templates/html';
            } else {
                // running from extracted archive
                self::$templatePath = __DIR__ . '/../../../www/PEAR2_SimpleChannelFrontend/pear2.php.net/templates/html';
            }
        }
        static::$classname_replacement = 'PEAR2\\SimpleChannelFrontend\\';
    }
}
