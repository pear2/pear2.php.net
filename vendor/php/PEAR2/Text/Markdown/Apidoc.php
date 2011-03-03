<?php
/**
 * 
 * Markdown engine rules for wiki markup.
 * 
 * This class implements a plugin set for the Markdown-Extra syntax;
 * be sure to visit the [Markdown-Extra][] site for syntax examples.
 * 
 * [Markdown-Extra]: http://www.michelf.com/projects/php-markdown/extra/
 * 
 * @category Solar
 * 
 * @package Markdown_Apidoc Plugin-based system to implement a 
 * Solar-specific wiki form of the Markdown syntax.
 * 
 * @author Paul M. Jones <pmjones@solarphp.com>
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @version $Id: Apidoc.php 4600 2010-06-16 03:27:55Z pmjones $
 * 
 * @todo Implement the markdown-in-html portion of Markdown-Extra.
 * 
 */
namespace PEAR2\Text;

class Markdown_Apidoc extends Markdown_Main
{
    /**
     * 
     * Default configuration values.
     * 
     * This sets the plugins and their processing order for the engine.
     * 
     * @var array
     * 
     */
    protected $_Markdown_Apidoc = array(
        'plugins' => array(
            
            // highest-priority prepare and cleanup
            'Markdown_Plugin_Prefilter',
            
            // for Markdown images and links
            'Markdown_Plugin_StripLinkDefs',
            
            // blocks
            'Markdown_Apidoc_MethodSynopsis',
            'Markdown_Apidoc_Table',
            'Markdown_Apidoc_Section',
            'Markdown_Apidoc_List',
            'Markdown_Apidoc_VariableList',
            'Markdown_Apidoc_ProgramListing',
            'Markdown_Apidoc_Screen',
            'Markdown_Plugin_BlockQuote', // should add Wiki_BlockQuote with "cite/attribution"
            'Markdown_Apidoc_Paragraph',
            
            // spans
            'Markdown_Apidoc_Literal',
            'Markdown_Apidoc_ClassPage',
            'Markdown_Apidoc_Link',
            'Markdown_Apidoc_Uri',
            'Markdown_Plugin_Encode',
            'Markdown_Apidoc_EmStrong',
            'Markdown_Wiki_Escape',
        ),
    );
    
    function __construct()
    {
        $this->_config = $this->_config + $this->_Markdown_Apidoc + $this->_Markdown;
        $this->_postConstruct();
    }
}
