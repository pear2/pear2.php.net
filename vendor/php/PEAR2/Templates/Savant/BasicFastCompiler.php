<?php

namespace PEAR2\Templates\Savant;

class BasicFastCompiler implements FastCompilerInterface
{
    /**
     * Directory where compiled templates will be stored
     * 
     * @var string
     */
    protected $compiledtemplatedir;

    /**
     * Constructor for the BasicFastCompiler
     * 
     * @param string $compiledtemplatedir Where to store compiled templates
     * 
     * @throws UnexpectedValueException
     */
    function __construct($compiledtemplatedir)
    {
        $this->compiledtemplatedir = realpath($compiledtemplatedir);
        if (!$this->compiledtemplatedir && !is_writable($this->compiledtemplatedir)) {
            throw new UnexpectedValueException('Unable to compile templates into ' .
                                               $compiledtemplatedir . ', directory does not exist ' .
                                               'or is unwritable');
        }
        $this->compiledtemplatedir .= DIRECTORY_SEPARATOR;
    }

    /**
     * Compile a template.
     * 
     * @param string $name   Template to compile
     * @param Main   $savant Savant main object
     *
     * @return string Name of the compiled template file.
     */
    function compile($name, $savant)
    {
        $cname = $this->compiledtemplatedir . md5($name);
        if (file_exists($cname)) {
            if (filemtime($name) == filemtime($cname)) {
                return $cname;
            }
        }
        $a = file_get_contents($name);
        $a = "<?php return '" . str_replace(array('<?php echo', '?>'), array('\' . ', ' . \''), $a) . "';";
        file_put_contents($cname, $a);
        touch($cname, filemtime($name));
        return $cname;
    }
}