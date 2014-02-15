<?php
/**
 * Functions for Minifier
 *
 * @package ChavMinifier
 * @subpackage Tools
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */

/**
 * Recursively copy a directory to another
 *
 * @param String $source Path for source folder
 * @param String $destination Path for destination folder
 */
function recursive_copy($source, $destination) 
{ 
	$directory = opendir($source);
	@mkdir($destination);

	while ($file = readdir($directory))
	{
		if (($file != '.') && ($file != '..'))
		{
			if (is_dir($source.'/'.$file))
			{
				recursive_copy($source.'/'.$file, $destination.'/'.$file);
			}
			else
			{
				copy($source.'/'.$file, $destination.'/'.$file);
			}
		}
	}

	closedir($directory);
}

/**
 * Recursively delete all files in a directory
 *
 * @param String $directory Path to the folder to delete
 */
function remove_directory($directory)
{
    if (!file_exists($directory)) 
		return true;
	
    if (!is_dir($directory)) 
		return unlink($directory);
	
    foreach (scandir($directory) as $item)
	{
        if ($item == '.' || $item == '..') 
			continue;
			
        if (!remove_directory($directory.DIRECTORY_SEPARATOR.$item))
			return false;
    }
	
    return rmdir($directory);
}