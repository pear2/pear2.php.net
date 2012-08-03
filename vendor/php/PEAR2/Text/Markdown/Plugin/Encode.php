<?php
/**
 *
 * Span plugin to encode backslashed Markdown characters.
 *
 * For example, `\*foo\*` will not be parsed as an emphasis span;
 * instead, it will show up as a literal `*foo*` in the text.
 *
 * @category Solar
 *
 * @package Markdown
 *
 * @author John Gruber <http://daringfireball.net/projects/markdown/>
 *
 * @author Michel Fortin <http://www.michelf.com/projects/php-markdown/>
 *
 * @author Paul M. Jones <pmjones@solarphp.com>
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 * @version $Id: Encode.php 3153 2008-05-05 23:14:16Z pmjones $
 *
 */
namespace PEAR2\Text;

class Markdown_Plugin_Encode extends Markdown_Plugin
{
    /**
     *
     * This is a span plugin.
     *
     * @var bool
     *
     */
    protected $_is_span = true;

    /**
     *
     * Encodes backslashed Markdown characters.
     *
     * @param string $text The source text.
     *
     * @return string The transformed XHTML.
     *
     */
    public function parse($text)
    {
        // encode backslash-escaped characters
        return $this->_encode($text, true);
    }
}
