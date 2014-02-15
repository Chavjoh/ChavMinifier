<?php
/**
 * Minifier execution
 *
 * @package ChavMinifier
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */

// It could take a lot of time
set_time_limit(0);

// Define directories path
define("ROOT", dirname(__FILE__).'/');
define("PATH_APP", ROOT.'app/');
define("PATH_TOOLS", PATH_APP.'tools/');
define('PATH_PARSER', PATH_APP.'parser/');

require_once(PATH_PARSER.'exclude.php');
require_once(PATH_TOOLS.'configuration.php');
require_once(PATH_TOOLS.'functions.php');
require_once(PATH_PARSER.'parser.php');
require_once(PATH_PARSER.'parser_php.php');
require_once(PATH_PARSER.'parser_css.php');
require_once(PATH_PARSER.'parser_tpl.php');
require_once(PATH_PARSER.'parser_js.php');
require_once(PATH_PARSER.'functions.php');

// Delete minified folder if already exists
if (is_dir(PATH_MINIFIED))
	remove_directory(PATH_MINIFIED);

// Make a copy of original folder to minified folder
recursive_copy(PATH_ORIGINAL, PATH_MINIFIED);

// Minify the copied folder
parse(substr(PATH_MINIFIED, 0, -1));

?>