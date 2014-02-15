<?php
/**
 * Application configuration
 *
 * @package ChavMinifier
 * @subpackage Tools
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */

// Define path for original scripts to minify
define("PATH_ORIGINAL", ROOT.'original/');

// Define path for minified scripts
define("PATH_MINIFIED", ROOT.'minified/');

// Configuration file
define("FILE_CONFIGURATION", ROOT.'configuration.xml');

if (!file_exists(FILE_CONFIGURATION)) {
	throw new Exception("Need XML configuration file (Path : ".FILE_CONFIGURATION.").");
}

// Get configuration content in XML
$configurationContentXML = file_get_contents(FILE_CONFIGURATION);

// Read XML file
$configurationXML = new SimpleXMLElement($configurationContentXML);

// Activation of the debug mode
define('DEBUG', (bool) $configurationXML->debug['active']->__toString());

// Activation of the obfuscation mode
define('OBFUSCATION', (bool) $configurationXML->obfuscation['active']->__toString());

// List all excluded directories
foreach ($configurationXML->exclude->children() as $directory) 
{
	Exclude::excludeDirectory(PATH_MINIFIED.$directory->__toString());
}

// Error reporting (Hard mode here :D)
error_reporting(E_ALL);

// PHP configuration
if (DEBUG == true) 
{
	ini_set('display_errors', 'On');
} 
else 
{
	ini_set('display_errors', 'Off');
	ini_set('log_errors', 'On');
	ini_set('error_log', PATH_LOG.'php.log');
}

?>