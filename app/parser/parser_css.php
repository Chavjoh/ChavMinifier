<?php

/**
 * Parser for *.css files (Stylesheets)
 *
 * @package ChavMinifier
 * @subpackage Parser
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */
class ParserCSS implements Parser
{
	/**
	 * Minify CSS content
	 * From http://code.seebz.net/p/minify-css/
	 */
	public function parse($content)
	{
		$content = str_replace(array("\r","\n"), '', $content);
		$content = preg_replace('`([^*/])\/\*([^*]|[*](?!/)){5,}\*\/([^*/])`Us', '$1$3', $content);
		$content = preg_replace('`\s*({|}|,|:|;)\s*`', '$1', $content);
		$content = str_replace(';}', '}', $content);
		$content = preg_replace('`(?=|})[^{}]+{}`', '', $content);
		$content = preg_replace('`[\s]+`', ' ', $content);
		
		return $content;
	}
}
