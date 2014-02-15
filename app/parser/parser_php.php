<?php

/**
 * Parser for *.php files
 *
 * @package ChavMinifier
 * @subpackage Parser
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */
class ParserPHP implements Parser
{
	/**
	 * Minify PHP content
	 */
	public function parse($content)
	{
		// Replace name for variable
		$letter = 'a';
		
		// Variable list for replacement
		$vars = array();
		
		// Ask tokens list to PHP compiler
		$tokens = token_get_all($content);
		
		// PHP variables
		$protectedVars = array(
			'$this',
			'$GLOBALS',
			'$_SERVER',
			'$_GET',
			'$_POST',
			'$_FILES', 
			'$_REQUEST',
			'$_SESSION',
			'$_ENV$_COOKIE',
			'$php_errormsg',
			'$HTTP_RAW_POST_DATA',
			'$http_response_header',
			'$argc',
			'$argv'
		);
		
		// Store minified code
		$codeMinified = "";
		
		foreach ($tokens as $index => $token)
		{
			// If token is identified
			if (is_array($token))
			{
				// Switch by token type
				switch($token[0])
				{
					/**
					 * Delete comments
					 */
					case T_COMMENT:
					case T_DOC_COMMENT:
						$token[1] = '';
					break;
					
					/**
					 * Delete whitespaces (\r\n\t)
					 */
					case T_WHITESPACE:
						$token[1] = ' ';
					break;
					
					/**
					 * Function or variable call
					 */
					case 307:
					
						if (isset($tokens[$index-1]) 
							AND is_array($tokens[$index-1]) 
							AND isset($tokens[$index-2]) 
							AND is_array($tokens[$index-2]))
						{
							// Class variable or class function
							if ($tokens[$index-1][1] == '->' AND $tokens[$index-2][1] == '$this')
							{
								if (isset($vars['$'.$token[1]]))
								{
									$token[1] = $vars['$'.$token[1]];
								}
							}
						}
						
					break;
					
					/**
					 * Minify variable name
					 * Obfuscation at the same time.
					 */
					case T_VARIABLE:
						if (!in_array($token[1], $protectedVars))
						{
							if(!isset($vars[$token[1]])) 
							{
								$vars[$token[1]] = $letter++;
							}
							$token[1] = '$' . $vars[$token[1]];
						}
					break;
					
					/**
					 * Encode string
					 * Obfuscation only
					 * /!\	Increases the size of strings (+33%)
					 *		Can be reversed
					 */
					case T_CONSTANT_ENCAPSED_STRING:
					case T_CONSTANT_ENCAPSED_STRING:
						if (OBFUSCATION)
						{ 
							// Check if not class constant
							if (	!isset($tokens[$index-2]) 
								OR !is_array($tokens[$index-2]) 
								OR (
										isset($tokens[$index-2]) 
									AND is_array($tokens[$index-2]) 
									AND $tokens[$index-2][1] != 'const')
								)
							{
								$token[1] = "base64_decode('".base64_encode(substr($token[1], 1, -1))."')";
							}
						}
					break;
				}
				
				// Save modified token
				$token = $token[1];
			}
			
			// Add to minfied code
			$codeMinified .= $token;
		}
		
		// Return entire code minified
		return $codeMinified;
	}
}
