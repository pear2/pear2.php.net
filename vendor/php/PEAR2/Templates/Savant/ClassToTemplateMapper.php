<?php
/**
 * PEAR2\Templates\Savant\ClassToTemplateMapper
 *
 * PHP version 5
 *
 * @category  Templates
 * @package   PEAR2_Templates_Savant
 * @author    Brett Bieber <saltybeagle@php.net>
 * @copyright 2009 Brett Bieber
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @version   SVN: $Id$
 * @link      http://svn.php.net/repository/pear2/PEAR2_Templates_Savant
 */

/**
 * ClassToTemplateMapper class for PEAR2_Templates_Savant
 * 
 * This class allows class names to be mapped to template names though a simple
 * scheme.
 *
 * @category  Templates
 * @package   PEAR2_Templates_Savant
 * @author    Brett Bieber <saltybeagle@php.net>
 * @copyright 2009 Brett Bieber
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://svn.php.net/repository/pear2/PEAR2_Templates_Savant
 */
namespace PEAR2\Templates\Savant;
class ClassToTemplateMapper implements MapperInterface
{
    /**
     * Default template mapping can be temporarily overridden by 
     * assigning a direct template name.
     * 
     * ClassToTemplateMapper::$output_template['My_Class'] = 'My/Class_rss.tpl.php';
     * 
     * @var array
     */
    static $output_template       = array();
    
    /**
     * What character to use as a directory separator when mapping class names
     * to templates.
     * 
     * @var string
     */
    static $directory_separator   = '_';
    
    /**
     * Strip something out of class names before mapping them to templates.
     * 
     * This can be useful if your class names are very long, and you don't
     * want empty subdirectories within your templates directory.
     * 
     * @var string
     */
    static $classname_replacement = '';
    
    /**
     * The file extension to use
     * 
     * @var string
     */
    static $template_extension = '.tpl.php';
    
    /**
     * Maps class names to template filenames.
     * 
     * Underscores and namespace separators in class names are replaced with 
     * directory separators.
     * 
     * Examples:
     * Class           => Class.tpl.php
     * Other_Class     => Other/Class.tpl.php
     * namespace\Class => namespace/Class.tpl.php
     *
     * @param string $class Class name to map to a template
     * 
     * @return string Template file name
     */
    function map($class)
    {
        if (isset(static::$output_template[$class])) {
            $class = static::$output_template[$class];
        }
        
        $class = str_replace(array(static::$classname_replacement,
                                   static::$directory_separator,
                                   '\\'),
                             array('',
                                   DIRECTORY_SEPARATOR,
                                   DIRECTORY_SEPARATOR),
                             $class);
        
        $templatefile = $class . static::$template_extension;
        
        return $templatefile;
    }
    
}
?>