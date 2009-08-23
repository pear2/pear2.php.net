<?php
/**
 * This class controls the output of the site.
 * 
 * Objects are mapped to templates:
 * My_Class => My/Class.tpl.php
 * 
 * @author bbieber
 *
 */
class OutputController
{
    /**
     * Default template mapping can be temporarily overridden by 
     * assigning a direct template name.
     * 
     * OutputController::$output_template['My_Class'] = 'My/Class_rss.tpl.php';
     * 
     * @var array
     */
    static $output_template       = array();
    
    /**
     * Path to look for templates in.
     * 
     * Using path separator multiple paths can be set.
     * 
     * @var string
     */
    static $template_path         = '';
    
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
     * A caching service.
     * 
     * @var object
     */
    static protected $cache;
    
    /**
     * Simple function that displays output.
     * 
     * Arrays will be output recursively, objects will be mapped to templates,
     * any other data will simply be echoed.
     * 
     * @param mixed $mixed  The output to be displayed.
     * @param bool  $return Whether to return the output or not.
     * 
     * @return mixed
     */
    static function display($mixed, $return = false)
    {
        if (is_array($mixed)) {
            return self::displayArray($mixed, $return);
        }
        
        if (is_object($mixed)) {
            return self::displayObject($mixed, $return);
        }
        
        if ($return) {
            return $mixed;
        }
        
        echo $mixed;
        return true;
    }
    
    /**
     * Set the interface used for caching output.
     * 
     * @param object $cache The CacheInterface to use for caching.
     * 
     * @return void
     */
    static public function setCacheInterface(CacheInterface $cache)
    {
        self::$cache = $cache;
    }
    
    /**
     * Sends an array of output. 
     * 
     * @param array $mixed  The array of data to be displayed.
     * @param bool  $return Whether to return the output or not.
     * 
     * @return mixed
     */
    static function displayArray($mixed, $return = false)
    {
        $output = '';
        foreach ($mixed as $m) {
            if ($return) {
                $output .= self::display($m, true);
            } else {
                self::display($m, true);
            }
        }
        
        if ($return) {
            return $output;
        }
        
        return true;
    }
    
    /**
     * Display an object.
     * 
     * Objects are first checked if they are cacheable (implement the Cacheable
     * interface). If they are, cached output is sent if the cache is valid.
     * 
     * Once output has been prepared, if the object implements
     * PostRunReplacements, the object will be allowed to see the output and
     * make any necessary modifications before output is sent.
     * 
     * @param object $object The object to display.
     * @param bool   $return Whether to return the output.
     * 
     * @return mixed
     */
    static function displayObject($object, $return = false)
    {
        if ($object instanceof Cacheable) {
            $key = $object->getCacheKey();
            
            // We have a valid key to store the output of this object.
            if ($key !== false && $data = self::$cache->get($key)) {
                // Tell the object we have cached data and will output that.
                $object->preRun(true);
            } else {
                // Content should be cached, but none could be found.
                //flush();
                ob_start();
                $object->preRun(false);
                $object->run();
                
                if ($return) {
                    $data = self::sendObjectOutput($object, $return);
                } else {
                    self::sendObjectOutput($object, $return);
                    $data = ob_get_contents();
                }
                
                if ($key !== false) {
                    self::$cache->save($data);
                }
                ob_end_clean();
            }
            
            if ($object instanceof PostRunReplacements) {
                $data = $object->postRun($data);
            }
            
            if ($return) {
                return $data;
            }
            
            echo $data;
            return true;
        }
        
        return self::sendObjectOutput($object, $return);

    }
    
    /**
     * Display an object using a template file.
     * 
     * Public member variables are assigned to the template, as well as 
     * ArrayAccess keys. If the object is an array, relevant information will
     * be populated for the template to use.
     * 
     * @param object $object The object to send out using a template.
     * @param bool   $return Whether to return the output or not.
     * 
     * @return mixed
     */
    static protected function sendObjectOutput(&$object, $return = false)
    {
        $savant = new \pear2\Templates\Savant\Main();
        if (!empty(self::$template_path)) {
            $savant->addPath('template', self::$template_path);
        }
        $savant->assign($object);
        if ($object instanceof Exception) {
            $savant->code    = $object->getCode();
            $savant->line    = $object->getLine();
            $savant->file    = $object->getFile();
            $savant->message = $object->getMessage();
            $savant->trace   = $object->getTrace();
        }
        $templatefile = self::getTemplateFilename(get_class($object));
        if ($return) {
            return $savant->fetch($templatefile);
        }
        $savant->display($templatefile);
        return true;
    }
    
    /**
     * This function maps a class name to a template filename.
     * 
     * My_Class => My/Class.tpl.php
     * 
     * @see OutputController::$classname_replacment
     * @see OutputController::$directory_separator
     * @see OutputController::$output_template
     * 
     * @param string $class The class to get template filename for.
     * 
     * @return string
     */
    static function getTemplateFilename($class)
    {
        if (isset(self::$output_template[$class])) {
            $class = self::$output_template[$class];
        }
        
        $class = str_replace(array(self::$classname_replacement,
                                   self::$directory_separator,
                                   '\\'),
                             array('',
                                   DIRECTORY_SEPARATOR,
                                   DIRECTORY_SEPARATOR),
                             $class);
        
        $templatefile = $class . '.tpl.php';
        
        return $templatefile;
    }
    
    /**
     * Set a custom template for a class, which will be used instead of the
     * default class to template file mapping.
     * 
     * @param string $class_name    Name of the class.
     * @param string $template_name The template filename to use.
     * 
     * @return string the template filename
     */
    static public function setOutputTemplate($class_name, $template_name)
    {
        if (isset($template_name)) {
            self::$output_template[$class_name] = $template_name;
        }
        return self::getTemplateFilename($class_name);
    }
    
    /**
     * Set the directory separator used in class to template mapping.
     * 
     * @param string $separator The separator
     * 
     * @return void
     */
    static public function setDirectorySeparator($separator)
    {
        self::$directory_separator = $separator;
    }
    
    /**
     * Set the classname replacement used in class to template mapping.
     * 
     * @param string $replacement What to replace.
     * 
     * @return void
     */
    static public function setClassNameReplacement($replacement)
    {
        self::$classname_replacement = $replacement;
    }
}

