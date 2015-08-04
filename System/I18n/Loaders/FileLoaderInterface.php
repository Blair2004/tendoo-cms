<?php
namespace System\I18n\Loaders;

use Exception;
use InvalidArgumentException;
use System\I18n\TextDomain;

interface FileLoaderInterface
{
	/**
	 * @param string $filename file path we will load
	 * @throws InvalidArgumentException if file not exist
	 * @throws InvalidArgumentException if file cant load with file loader
	 */
	public function __construct($filename);

	/**
	 * Load translations from a file.
	 *
	 * @return TextDomain
	 * @throws Exception
	 */
	public function load();
}
