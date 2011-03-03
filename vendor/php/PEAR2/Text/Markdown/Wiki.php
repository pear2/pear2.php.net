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
 * @package Markdown_Wiki Plugin-based system to implement a 
 * Solar-specific wiki form of the Markdown syntax.
 * 
 * @author Paul M. Jones <pmjones@solarphp.com>
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @version $Id: Wiki.php 4380 2010-02-14 16:06:52Z pmjones $
 * 
 * @todo Implement the markdown-in-html portion of Markdown-Extra.
 * 
 */
namespace PEAR2\Text;

class Markdown_Wiki extends Markdown_Main
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
    protected $_Markdown_Wiki = array(
        'plugins' => array(
            
            // highest-priority prepare and cleanup
            'Markdown_Wiki_Filter',
            
            // for Markdown images and links
            'Markdown_Plugin_StripLinkDefs',
            
            // blocks
            'Markdown_Wiki_MethodSynopsis',
            'Markdown_Wiki_Header',
            'Markdown_Extra_Table',
            'Markdown_Plugin_HorizRule',
            'Markdown_Plugin_List',
            'Markdown_Extra_DefList',
            'Markdown_Wiki_ColorCodeBlock',
            'Markdown_Plugin_CodeBlock',
            'Markdown_Plugin_BlockQuote',
            'Markdown_Plugin_Paragraph',
            
            // spans
            'Markdown_Plugin_CodeSpan',
            'Markdown_Wiki_Link',
            'Markdown_Plugin_Image',
            'Markdown_Plugin_Link',
            'Markdown_Plugin_Uri',
            'Markdown_Plugin_Encode',
            'Markdown_Extra_EmStrong',
            'Markdown_Plugin_Break',
            'Markdown_Wiki_Escape',
        ),
    );
    
    function __construct()
    {
        $this->_config = $this->_config + $this->_Markdown_Wiki + $this->_Markdown;
        $this->_postConstruct();
    }
}
