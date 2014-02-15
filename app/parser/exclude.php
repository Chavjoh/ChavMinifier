<?php

/**
 * Exclusion manager
 *
 * @package ChavMinifier
 * @subpackage Parser
 * @author Chavjoh
 * @since 1.0.0
 * @license CC BY-SA 3.0 Unported
 */
class Exclude
{
	/**
	 * Directory list
	 *
	 * @var Array
	 */
	protected static $directoryList = array();
	
	/**
	 * Exclude a directory of the process
	 *
	 * @param String $directoryName Directory to exclude
	 */
	public static function excludeDirectory($directoryName)
	{
		static::$directoryList[] = $directoryName;
	}
	
	/**
	 * Get all excluded directories
	 *
	 * @return Array List of all excluded directories
	 */
	public static function getExcludedDirectories()
	{
		return static::$directoryList;
	}
}
