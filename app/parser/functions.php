<?php
/**
 * Parser functions
 *
 * @package ChavMinifier
 * @subpackage Parser
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */

/**
 * Minify a directory
 *
 * @param String $parseDirectory Path to the directory to minify
 */
function parse($parseDirectory)
{
	$directory = opendir($parseDirectory);
	
	while ($file = readdir($directory))
	{
		if (($file != '.') && ($file != '..'))
		{
			$filePath = $parseDirectory.'/'.$file;
			
			if (is_dir($filePath))
			{
				if (DEBUG) echo 'Directory '.$filePath.' <br />';
				
				if (!in_array($filePath, Exclude::getExcludedDirectories()))
				{
					if (DEBUG) echo 'ENTER <br />';
					
					parse($filePath);
				}
			}
			else
			{
				$extension = pathinfo($filePath, PATHINFO_EXTENSION);
				$parser = null;
				
				switch ($extension)
				{
					case 'php':
						$parser = new ParserPHP();
						break;
						
					case 'css':
						$parser = new ParserCSS();
						break;
						
					case 'tpl':
						$parser = new ParserTPL();
						break;
						
					case 'js':
						$parser = new ParserJS();
						break;
				}
				
				if (DEBUG) echo $filePath.'->'.$extension;
				
				if ($parser != null)
				{
					if (DEBUG) echo '->Minified';
					
					$content = file_get_contents($filePath);
					$content = $parser->parse($content);
					file_put_contents($filePath, $content);
				}
				
				if (DEBUG) echo '<br />';
			}
		}
	}
	
	closedir($directory);
}

?>