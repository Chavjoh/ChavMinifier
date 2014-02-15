<?php

/**
 * Parser for *.tpl files (Smarty templates)
 *
 * @package ChavMinifier
 * @subpackage Parser
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */
class ParserTPL implements Parser
{
	/**
	 * Minify template content
	 */
	public function parse($content)
	{
		$content = str_replace(array("\r", "\n", "\t"), ' ', $content);
		$content = preg_replace('`[\s]+`', ' ', $content);
		
		return $content;
	}
}
