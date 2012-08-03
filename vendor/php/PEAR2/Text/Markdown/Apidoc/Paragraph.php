<?php
/**
 *
 * Block plugin to form paragraphs of text with 2 newlines around it.
 *
 * @category Solar
 *
 * @package Markdown_Apidoc
 *
 * @author Paul M. Jones <pmjones@solarphp.com>
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 * @version $Id: Paragraph.php 4600 2010-06-16 03:27:55Z pmjones $
 *
 */
namespace PEAR2\Text;

class Markdown_Apidoc_Paragraph extends Markdown_Plugin_Paragraph
{
    /**
     *
     * Forms paragraphs from source text.
     *
     * @param string $text Portion of the Markdown source text.
     *
     * @return string The transformed XHTML.
     *
     */
    public function parse($text)
    {
        // // Strip leading and trailing lines:
        // $text = preg_replace(array('/\A\n+/', '/\n+\z/'), '', $text);

        // split into possible paragraphs
        $grafs = preg_split('/\n{2,}/', $text, -1, PREG_SPLIT_NO_EMPTY);

        // Wrap <p> tags around apparent paragraphs.
        foreach ($grafs as $key => $value) {
            if (! $this->_isHtmlToken($value)) {
                // not an HTML token, looks like a paragraph.
                $value = $this->_processSpans($value);
                $value = preg_replace('/^([ \t]*)/', '<para>', $value);
                $value .= "</para>";
                $grafs[$key] = $this->_toHtmlToken($value);
            }
        }

        // done!
        return implode("\n\n", $grafs);
    }
}
