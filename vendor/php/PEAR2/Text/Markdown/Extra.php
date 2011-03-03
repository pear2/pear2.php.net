<?php
/**
 * 
 * Solar port of Markdown-Extra by Michel Fortin.
 * 
 * This class implements a plugin set for the Markdown-Extra syntax;
 * be sure to visit the [Markdown-Extra][] site for syntax examples.
 * 
 * [Markdown-Extra]: http://www.michelf.com/projects/php-markdown/extra/
 * 
 * @category Solar
 * 
 * @package Markdown_Extra Plugin-based system to implement the 
 * Markdown-Extra syntax.
 * 
 * @author Michel Fortin <http://www.michelf.com/projects/php-markdown/>
 * 
 * @author Paul M. Jones <pmjones@solarphp.com>
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @version $Id: Extra.php 4380 2010-02-14 16:06:52Z pmjones $
 * 
 * @todo Implement the markdown-in-html portion of Markdown-Extra.
 * 
 */
namespace PEAR2\Text;

class Markdown_Extra extends Markdown_Main
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
    protected $_Markdown_Extra = array(
        'plugins' => array(
            
            // pre-processing on the source as a whole
            'Markdown_Plugin_Prefilter',
            'Markdown_Plugin_StripLinkDefs',
            
            // blocks
            'Markdown_Extra_Header',
            'Markdown_Extra_Table',
            'Markdown_Plugin_HorizRule',
            'Markdown_Plugin_List',
            'Markdown_Extra_DefList',
            'Markdown_Plugin_CodeBlock',
            'Markdown_Plugin_BlockQuote',
            'Markdown_Plugin_Html', //'Markdown_Extra_Html',
            'Markdown_Plugin_Paragraph',
            
            // spans
            'Markdown_Plugin_CodeSpan',
            'Markdown_Plugin_Image',
            'Markdown_Plugin_Link',
            'Markdown_Plugin_Uri',
            'Markdown_Plugin_Encode',
            'Markdown_Plugin_AmpsAngles',
            'Markdown_Extra_EmStrong',
            'Markdown_Plugin_Break',
        ),
    );
    
    function __construct()
    {
        $this->_config = $this->_config + $this->_Markdown_Extra + $this->_Markdown;
        $this->_postConstruct();
    }
}
