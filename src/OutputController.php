<?php

class OutputController
{
    static $output_template       = array();
    
    static $template_path         = '';
    
    static $directory_separator   = '_';
    
    static $classname_replacement = '';
    
    static protected $cache;
    
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
    
    static public function setCacheInterface(CacheInterface $cache)
    {
        self::$cache = $cache;
    }
    
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
    
    static protected function sendObjectOutput(&$object, $return = false)
    {
        $savant = new \pear2\Templates\Savant\Main();
        if (!empty(self::$template_path)) {
            $savant->addPath('template', self::$template_path);
        }
        foreach (get_object_vars($object) as $key=>$var) {
            $savant->$key = $var;
        }
        if (in_array('ArrayAccess', class_implements($object))) {
            foreach ($object->toArray() as $key=>$var) {
                $savant->$key = $var;
            }
        }
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
    
    static function getTemplateFilename($class)
    {
        if (isset(self::$output_template[$class])) {
            $class = self::$output_template[$class];
        }
        
        $class = str_replace(array(self::$classname_replacement,
                                   self::$directory_separator),
                             array('',
                                   DIRECTORY_SEPARATOR),
                             $class);
        
        $templatefile = $class . '.tpl.php';
        
        return $templatefile;
    }
    
    static public function setOutputTemplate($class_name, $template_name)
    {
        if (isset($template_name)) {
            self::$output_template[$class_name] = $template_name;
        }
        return self::getTemplateFilename($class_name);
    }
    
    static public function setDirectorySeparator($separator)
    {
        self::$directory_separator = $separator;
    }
    
    static public function setClassNameReplacement($replacement)
    {
        self::$classname_replacement = $replacement;
    }
}

