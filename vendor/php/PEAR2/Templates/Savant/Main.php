<?php
/**
 * PEAR2\Templates\Savant\Main
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
 * Main class for PEAR2_Templates_Savant
 *
 * @category  Templates
 * @package   PEAR2_Templates_Savant
 * @author    Brett Bieber <saltybeagle@php.net>
 * @copyright 2009 Brett Bieber
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @link      http://svn.php.net/repository/pear2/PEAR2_Templates_Savant
 */
namespace PEAR2\Templates\Savant;
class Main
{
    /**
    * 
    * Array of configuration parameters.
    * 
    * @access protected
    * 
    * @var array
    * 
    */
    
    protected $__config = array(
        'compiler'      => null,
        'filters'       => array(),
        'escape'        => null,
    );
    
    /**
     * Parameters for escaping.
     * 
     * @var array
     */
    protected $_escape = array(
        'quotes'  => ENT_COMPAT,
        'charset' => 'UTF-8',
        );
    
    /**
     * The output template to render using
     * 
     * @var string
     */
    protected $template;

    /**
     * stack of templates, so we can access the parent template
     * 
     * @var array
     */
    protected $templateStack = array();

    /**
     * To avoid stats on locating templates, populate this array with
     * full path => 1 for any existing templates
     * 
     * @var array
     */
    protected $templateMap = array();
    
    /**
     * An array of paths to look for template files in.
     * 
     * @var array
     */
    protected $template_path = array('./');

    /**
     * A list of output controllers.  One does no filtering, another does.  This
     * makes non-filtering controllers faster.
     * 
     * @var array
     */
    protected $output_controllers = array();

    /**
     * The current controller to use
     * 
     * @var string
     */
    protected $selected_controller;
    
    /**
     * How class names are translated to templates
     * 
     * @var MapperInterface
     */
    protected $class_to_template;

    /**
     * Array of globals available within every template
     * 
     * @var array
     */
    protected $globals = array();
    // -----------------------------------------------------------------
    //
    // Constructor and magic methods
    //
    // -----------------------------------------------------------------
    
    
    /**
    * 
    * Constructor.
    * 
    * @access public
    * 
    * @param array $config An associative array of configuration keys for
    * the Main object.  Any, or none, of the keys may be set.
    * 
    * @return PEAR2\Templates\Savant\Main A PEAR2\Templates\Savant\Main instance.
    * 
    */
    
    public function __construct($config = null)
    {
        $savant = $this;
        $this->output_controllers['basic'] = function($context, $parent, $file) use ($savant) {
                foreach ($savant->getGlobals() as $__name => $__value) {
                    $$__name = $__value;
                }
                unset($__name, $__value);
                ob_start();
                include $file;
                return ob_get_clean();
            };
        $this->output_controllers['filter'] = function($context, $parent, $file) use ($savant) {
                foreach ($savant->getGlobals() as $__name => $__value) {
                    $$__name = $__value;
                }
                unset($__name, $__value);
                ob_start();
                include $file;
                return $savant->applyFilters(ob_get_clean());
            };
        $this->output_controllers['basiccompiled'] = function($context, $parent, $file) use ($savant) {
                foreach ($savant->getGlobals() as $__name => $__value) {
                    $$__name = $__value;
                }
                unset($__name, $__value);
                ob_start();
                include $savant->template($file);
                return ob_get_clean();
            };
        $this->output_controllers['filtercompiled'] = function($context, $parent, $file) use ($savant) {
                foreach ($savant->getGlobals() as $__name => $__value) {
                    $$__name = $__value;
                }
                unset($__name, $__value);
                ob_start();
                include $savant->template($file);
                return $savant->applyFilters(ob_get_clean());
            };
        $this->output_controllers['basicfastcompiled'] = function($context, $parent, $file) use ($savant) {
                foreach ($savant->getGlobals() as $__name => $__value) {
                    $$__name = $__value;
                }
                unset($__name, $__value);
                return include $savant->template($file);
            };
        $this->output_controllers['filterfastcompiled'] = function($context, $parent, $file) use ($savant) {
                foreach ($savant->getGlobals() as $__name => $__value) {
                    $$__name = $__value;
                }
                unset($__name, $__value);
                return $savant->applyFilters(include $savant->template($file));
            };
        $this->selected_controller = 'basic';
        
        // set the default template search path
        if (isset($config['template_path'])) {
            // user-defined dirs
            $this->setTemplatePath($config['template_path']);
        }
        
        // set the output escaping callbacks
        if (isset($config['escape'])) {
            $this->setEscape($config['escape']);
        }
        
        // set the default filter callbacks
        if (isset($config['filters'])) {
            $this->addFilters($config['filters']);
        }
    }

    /**
     * Add a global variable which will be available inside every template
     * 
     * @param string $var   The global variable name
     * @param mixed  $value The value
     * 
     * @return void
     */
    function addGlobal($name, $value)
    {
        switch ($name) {
            case 'context':
            case 'parent':
            case 'template':
            case 'file':
            case 'savant':
            case 'this':
                throw new BadMethodCallException('Invalid global variable name');
        }

        if ($this->__config['escape']) {
            switch (gettype($value)) {
                case 'object':
                    if (!$value instanceof ObjectProxy) {
                        $value = ObjectProxy::factory($value, $this);
                    }
                    break;
                case 'string':
                case 'int':
                case 'double':
                    $value = $this->escape($value);
                    break;
                case 'array':
                    $value = new ObjectProxy\ArrayAccess(new \ArrayIterator($value), $this);
                    break;
            }
        }

        $this->globals[$name] = $value;
    }

    /**
     * Get the array of assigned globals
     * 
     * @return array
     */
    function getGlobals()
    {
        return $this->globals;
    }

    /**
     * Return the current template set (if any)
     * 
     * @return string
     */
    function getTemplate()
    {
        return $this->template;
    }
    
    
    // -----------------------------------------------------------------
    //
    // Public configuration management (getters and setters).
    // 
    // -----------------------------------------------------------------
    
    
    /**
    *
    * Returns a copy of the Savant3 configuration parameters.
    *
    * @access public
    * 
    * @param string $key The specific configuration key to return.  If null,
    * returns the entire configuration array.
    * 
    * @return mixed A copy of the $this->__config array.
    * 
    */
    
    public function getConfig($key = null)
    {
        if (is_null($key)) {
            // no key requested, return the entire config array
            return $this->__config;
        } elseif (empty($this->__config[$key])) {
            // no such key
            return null;
        } else {
            // return the requested key
            return $this->__config[$key];
        }
    }
    
    
    /**
    * 
    * Sets a custom compiler/pre-processor callback for template sources.
    * 
    * By default, Savant3 does not use a compiler; use this to set your
    * own custom compiler (pre-processor) for template sources.
    * 
    * @access public
    * 
    * @param mixed $compiler A compiler callback value suitable for the
    * first parameter of call_user_func().  Set to null/false/empty to
    * use PHP itself as the template markup (i.e., no compiling).
    * 
    * @return void
    * 
    */
    
    public function setCompiler(CompilerInterface $compiler)
    {
        $this->__config['compiler'] = $compiler;
        if ($compiler instanceof FastCompilerInterface) {
            switch ($this->selected_controller) {
                case 'basic' :
                case 'basiccompiled';
                    $this->selected_controller = 'basicfastcompiled';
                    break;
                case 'filter' :
                case 'filtercompiled' :
                    $this->selected_controller = 'filterfastcompiled';
                    break;
            }
            return;
        }
        if (!strpos($this->selected_controller, 'compiled')) {
            $this->selected_controller .= 'compiled';
        }
    }
    
    /**
     * Set the class to template mapper.
     * 
     * @see MapperInterface
     * 
     * @param MapperInterface $mapper The mapper interface to use 
     * 
     * @return Main
     */
    function setClassToTemplateMapper(MapperInterface $mapper)
    {
        $this->class_to_template = $mapper;
        return $this;
    }
    
    /**
     * Get the class to template mapper.
     * 
     * @return MapperInterface
     */
    function getClassToTemplateMapper()
    {
        if (!isset($this->class_to_template)) {
            $this->setClassToTemplateMapper(new ClassToTemplateMapper());
        }
        return $this->class_to_template;
    }
    
    
    // -----------------------------------------------------------------
    //
    // Output escaping and management.
    //
    // -----------------------------------------------------------------
    
    
    /**
    * 
    * Clears then sets the callbacks to use when calling $this->escape().
    * 
    * Each parameter passed to this function is treated as a separate
    * callback.  For example:
    * 
    * <code>
    * $savant->setEscape(
    *     'stripslashes',
    *     'htmlspecialchars',
    *     array('StaticClass', 'method'),
    *     array($object, $method)
    * );
    * </code>
    * 
    * @access public
    *
    * @return Main
    *
    */
    
    public function setEscape()
    {
        $this->__config['escape'] = @func_get_args();
        return $this;
    }
    
    
    /**
    *
    * Gets the array of output-escaping callbacks.
    *
    * @access public
    *
    * @return array The array of output-escaping callbacks.
    *
    */
    
    public function getEscape()
    {
        return $this->__config['escape'];
    }
    
    
    /**
     * Escapes a value for output in a view script.
     *
     * If escaping mechanism is one of htmlspecialchars or htmlentities, uses
     * {@link $_encoding} setting.
     *
     * @param mixed $var The output to escape.
     * 
     * @return mixed The escaped value.
     */
    public function escape($var)
    {
        foreach ($this->__config['escape'] as $escape) {
            if (in_array($escape,
                    array('htmlspecialchars', 'htmlentities'), true)) {
                $var = call_user_func($escape,
                                      $var,
                                      $this->_escape['quotes'],
                                      $this->_escape['charset']);
            } else {
                $var = call_user_func($escape, $var);
            }
        }
        return $var;
    }
    
    
    // -----------------------------------------------------------------
    //
    // File management
    //
    // -----------------------------------------------------------------
    
    /**
     * Get the template path.
     * 
     * @return array
     */
    function getTemplatePath()
    {
        return $this->template_path;
    }
    
    /**
    *
    * Sets an entire array of search paths for templates or resources.
    *
    * @access public
    * 
    * @param string|array $path The new set of search paths.  If null or
    * false, resets to the current directory only.
    *
    * @return Main
    *
    */
    
    public function setTemplatePath($path = null)
    {
        // clear out the prior search dirs, add default
        $this->template_path = array('./');
        
        // actually add the user-specified directories
        $this->addTemplatePath($path);
        return $this;
    }
    
    
    /**
    *
    * Adds to the search path for templates and resources.
    *
    * @access public
    *
    * @param string|array $path The directory or stream to search.
    *
    * @return Main
    *
    */
    
    public function addTemplatePath($path)
    {
        // convert from path string to array of directories
        if (is_string($path) && !strpos($path, '://')) {
        
            // the path config is a string, and it's not a stream
            // identifier (the "://" piece). add it as a path string.
            $path = explode(PATH_SEPARATOR, $path);
            
            // typically in path strings, the first one is expected
            // to be searched first. however, Savant3 uses a stack,
            // so the first would be last.  reverse the path string
            // so that it behaves as expected with path strings.
            $path = array_reverse($path);
            
        } else {
        
            // just force to array
            settype($path, 'array');
            
        }
        
        // loop through the path directories
        foreach ($path as $dir) {
        
            // no surrounding spaces allowed!
            $dir = trim($dir);
            
            // add trailing separators as needed
            if (strpos($dir, '://')) {
                if (substr($dir, -1) != '/') {
                    // stream
                    $dir .= '/';
                }
            } elseif (substr($dir, -1) != DIRECTORY_SEPARATOR) {
                if (false !== strpos($dir, '..')) {
                    // checking for weird paths here removes directory traversal threat
                    throw new UnexpectedValueException('upper directory reference .. cannot be used in template path');
                }
                // directory
                $dir .= DIRECTORY_SEPARATOR;
            }

            // add to the top of the search dirs
            array_unshift(
                $this->template_path,
                $dir
            );
        }
    }
    
    
    /**
    * 
    * Searches the directory paths for a given file.
    * 
    * @param string $file The file name to look for.
    * 
    * @return string|bool The full path and file name for the target file,
    * or boolean false if the file is not found in any of the paths.
    *
    */
    
    public function findTemplateFile($file)
    {
        if (false !== strpos($file, '..')) {
            // checking for weird path here removes directory traversal threat
            throw new UnexpectedValueException('upper directory reference .. cannot be used in template filename');
        }
        
        // start looping through the path set
        foreach ($this->template_path as $path) {
            // get the path to the file
            $fullname = $path . $file;

            if (isset($this->templateMap[$fullname])) {
                return $fullname;
            }

            if (!@is_readable($fullname)) {
                continue;
            }

            return $fullname;
        }

        // could not find the file in the set of paths
        throw new TemplateException('Could not find the template ' . $file);
    }
    
    
    // -----------------------------------------------------------------
    //
    // Template processing
    //
    // -----------------------------------------------------------------
    
    /**
     * Render context data through a template.
     * 
     * This method allows you to render data through a template. Typically one
     * will pass the model they wish to display through an optional template.
     * If no template is specified, the ClassToTemplateMapper::map() method
     * will be called which should return the name of a template to render.
     * 
     * Arrays will be looped over and rendered through the template specified.
     * 
     * Strings, ints, and doubles will returned if no template parameter is 
     * present.
     * 
     * Within templates, two variables will be available, $context and $savant.
     * The $context variable will contain the data passed to the render method,
     * the $savant object will be an instance of the Main class with which you
     * can render nested data through partial templates.
     * 
     * @param mixed $mixed     Data to display through the template.
     * @param string $template A template to display data in.
     * 
     * @return string The template output
     */
    function render($mixed = null, $template = null)
    {
        $method = 'render'.gettype($mixed);
        return $this->$method($mixed, $template);
    }
    
    /**
     * Called when a resource is rendered
     * 
     * @param resource $resouce  The resources
     * @param string   $template Template
     * 
     * @return void
     * 
     * @throws UnexpectedValueException
     */
    protected function renderResource($resouce, $template = null)
    {
        throw new UnexpectedValueException('No way to render a resource!');
    }
    
    protected function renderBoolean($bool, $template = null)
    {
        return $this->renderString((string)$bool, $template);
    }
    
    protected function renderDouble($double, $template = null)
    {
        return $this->renderString($double, $template);
    }
    
    protected function renderInteger($int, $template = null)
    {
        return $this->renderString($int, $template);
    }
    
    /**
     * Render string of data
     * 
     * @param string $string   String of data
     * @param string $template A template to display the string in
     * 
     * @return string
     */
    protected function renderString($string, $template = null)
    {
        if ($this->__config['escape']) {
            $string = $this->escape($string);
        }
        
        if ($template) {
            return $this->fetch($string, $template);
        }

        if (!$this->__config['filters']) {
            return $string;
        }
        return $this->applyFilters($string);
    }
    
    /**
     * Used to render context array
     * 
     * @param array  $array    Data to render
     * @param string $template Template to render
     * 
     * @return string Rendered output
     */
    protected function renderArray(array $array, $template = null)
    {
        $savant = $this;
        $render = function($output, $mixed) use ($savant, $template) {
            return $output . $savant->render($mixed, $template);
        };
        return array_reduce($array, $render, '');
    }

    /**
     * Render an associative array of data through a template.
     * 
     * Three parameters will be passed to the closure, the array key, value,
     * and selective third parameter.
     * 
     * @param array   $array    Associative array of data
     * @param mixed   $selected Optional parameter to pass
     * @param Closure $template A closure that will be called
     * 
     * @return string
     */
    public function renderAssocArray(array $array, $selected = false, Closure $template)
    {
        $ret = '';
        foreach ($array as $key => $element) {
            $ret .= $template($key, $element, $selected);
        }
        return $ret;
    }

    /**
     * Render an if else conditional template output.
     * 
     * @param mixed  $condition      The conditional to evaluate
     * @param mixed  $render         Context data to render if condition is true
     * @param mixed  $else           Context data to render if condition is false
     * @param string $rendertemplate If true, render using this template
     * @param string $elsetemplate   If false, render using this template
     * 
     * @return string
     */
    public function renderElse($condition, $render, $else, $rendertemplate = null, $elsetemplate = null)
    {
        if ($condition) {
            $this->render($render, $rendertemplate);
        } else {
            $this->render($else, $elsetemplate);
        }
    }
    
    /**
     * Used to render an object through a template.
     * 
     * @param object $object   Model containing data
     * @param string $template Template to render data through
     * 
     * @return string Rendered output
     */
    protected function renderObject($object, $template = null)
    {
        if ($this->__config['escape']
            && !$object instanceof ObjectProxy) {
            $object = ObjectProxy::factory($object, $this);
        }
        return $this->fetch($object, $template);
    }
    
    /**
     * Used to render null through an optional template
     * 
     * @param null   $null     The null var
     * @param string $template Template to render null through
     * 
     * @return string Rendered output
     */
    protected function renderNULL($null, $template = null)
    {
        if ($template) {
            return $this->fetch(null, $template);
        }
    }
    
    protected function fetch($mixed, $template = null)
    {
        if ($template) {
            $this->template = $template;
        } else {
            if ($mixed instanceof ObjectProxy) {
                $class = $mixed->__getClass();
            } else {
                $class = get_class($mixed);
            }
            $this->template = $this->getClassToTemplateMapper()->map($class);
        }
        $current          = new \stdClass;
        $current->file    = $this->findTemplateFile($this->template);
        $current->context = $mixed;
        $current->parent  = null;
        $outputcontroller = $this->output_controllers[$this->selected_controller];
        if (count($this->templateStack)) {
            $current->parent = $this->templateStack[count($this->templateStack)-1];
        }
        $this->templateStack[] = $current;
        $ret = $outputcontroller($current->context, $current->parent, $current->file);
        array_pop($this->templateStack);
        return $ret;
    }
    
    /**
    *
    * Compiles a template and returns path to compiled script.
    * 
    * By default, Savant does not compile templates, it uses PHP as the
    * markup language, so the "compiled" template is the same as the source
    * template.
    *
    * If a compiler is specific, this method is used to look up the compiled
    * template script name
    *
    * @param string $tpl The template source name to look for.
    * 
    * @return string The full path to the compiled template script.
    * 
    * @throws PEAR2\Templates\Savant\UnexpectedValueException
    * @throws PEAR2\Templates\Savant\Exception
    * 
    */
    
    public function template($tpl = null)
    {
        // find the template source.
        $file = $this->findTemplateFile($tpl);
        
        // are we compiling source into a script?
        if ($this->__config['compiler']) {
            // compile the template source and get the path to the
            // compiled script (will be returned instead of the
            // source path)
            $result = $this->__config['compiler']->compile($file, $this);
        } else {
            // no compiling requested, use the source path
            $result = $file;
        }
        
        // is there a script from the compiler?
        if (!$result) {
            // return an error, along with any error info
            // generated by the compiler.
            throw new Exception('Compiler error for template '.$tpl.'. '.$result );
            
        } else {
            // no errors, the result is a path to a script
            return $result;
        }
    }
    
    
    // -----------------------------------------------------------------
    //
    // Filter management and processing
    //
    // -----------------------------------------------------------------
    
    
    /**
    * 
    * Resets the filter stack to the provided list of callbacks.
    * 
    * @access protected
    * 
    * @param array An array of filter callbacks.
    * 
    * @return void
    * 
    */
    
    public function setFilters()
    {
        $this->__config['filters'] = (array) @func_get_args();
        if (!$this->__config['filters']) {
            $this->selected_controller = 'basic';
        } else {
            $this->selected_controller = 'filter';
        }
    }
    
    
    /**
    * 
    * Adds filter callbacks to the stack of filters.
    * 
    * @access protected
    * 
    * @param array An array of filter callbacks.
    * 
    * @return void
    * 
    */
    
    public function addFilters()
    {
        // add the new filters to the static config variable
        // via the reference
        foreach ((array) @func_get_args() as $callback) {
            $this->__config['filters'][] = $callback;
            $this->selected_controller = 'filter';
        }
    }
    
    
    /**
    * 
    * Runs all filter callbacks on buffered output.
    * 
    * @access protected
    * 
    * @param string The template output.
    * 
    * @return void
    * 
    */
    
    public function applyFilters($buffer)
    {
        foreach ($this->__config['filters'] as $callback) {
            $buffer = call_user_func($callback, $buffer);
        }
        
        return $buffer;
    }
    
}
