<?php

/**
 * Parser for *.js files (Javascript)
 *
 * @package ChavMinifier
 * @subpackage Parser
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */
class ParserJS implements Parser
{
	/**
	 * Minify JS content
	 * From http://code.seebz.net/p/minify-js/
	 */
	public function parse($content)
	{
		$output = '';
		
		$inQuotes = array();
		$noSpacesAround = '{}()[]<>|&!?:;,+-*/="\'';
		
		$input = preg_replace("`(\r\n|\r)`", "\n", $content);
		$inputs = str_split($input);
		$inputs_count = count($inputs);
		$prevChr = null;
		
		for ($i = 0; $i < $inputs_count; $i++) 
		{
			$chr = $inputs[$i];
			$nextChr = $i+1 < $inputs_count ? $inputs[$i+1] : null;
			
			switch($chr) 
			{
				case '/':
					if (!count($inQuotes) && $nextChr == '*' && $inputs[$i+2] != '@') 
					{
						$i = 1 + strpos($input, '*/', $i);
						continue 2;
					} 
					elseif (!count($inQuotes) && $nextChr == '/') 
					{
						$i = strpos($input, "\n", $i);
						continue 2;
					} 
					elseif (!count($inQuotes)) 
					{
						$eolPos = strpos($input, "\n", $i);
						if($eolPos===false) $eolPos = $inputs_count;
						$eol = substr($input, $i, $eolPos-$i);
						
						if (!preg_match('`^(/.+(?<=\\\/)/(?!/)[gim]*)[^gim]`U', $eol, $m)) 
						{
							preg_match('`^(/.+(?<!/)/(?!/)[gim]*)[^gim]`U', $eol, $m);
						}
						if (isset($m[1])) 
						{
							$output .= $m[1];
							$i += strlen($m[1])-1;
							continue 2;
						}
					}
					break;
				
				case "'":
				case '"':
					if ($prevChr != '\\' || ($prevChr == '\\' && $inputs[$i-2] == '\\')) 
					{
						if (end($inQuotes) == $chr) 
						{
							array_pop($inQuotes);
						} 
						elseif (!count($inQuotes)) 
						{
							$inQuotes[] = $chr;
						}
					}
					break;
				
				case ' ':
				case "\t":
				case "\n":
					if (!count($inQuotes)) {
						if (   strstr("{$noSpacesAround} \t\n", $nextChr)
							|| strstr("{$noSpacesAround} \t\n", $prevChr)) 
						{
							continue 2;
						}
						$chr = ' ';
					}
					break;
				
				default:
					break;
			}
			
			$output .= $chr;
			$prevChr = $chr;
		}
		
		$output = trim($output);
		$output = str_replace(';}', '}', $output);
		
		return $output;
	}
}
