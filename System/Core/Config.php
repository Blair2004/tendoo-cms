<?php
namespace System\Core;

use RuntimeException;
use System\Common\NamespacedFileLoaderTrait;
use System\Utility\Arr;

class Config
{
	use NamespacedFileLoaderTrait;

	/**
	 * Environment name.
	 *
	 * @var string
	 */
	protected $environment;

	/**
	 * loaded config files
	 *
	 * @var array
	 */
	protected $loaded = [];

	/**
	 * @param array|string $path
	 * @param string|null $environment
	 */
	public function __construct($path, $environment = null)
	{
		$this->environment = $environment;

		$this->setPath($path);
	}

	/**
	 * check config file loaded or not
	 *
	 * @param $filename
	 * @return bool
	 */
	public function loaded($filename)
	{
		return isset($this->loaded[$filename]);
	}

	/**
	 * Returns config value or entire config array from a file.
	 *
	 * @param   string  $key      Config key
	 * @param   mixed   $default  Default value to return if config value doesn't exist
	 * @return  mixed
	 */
	public function get($key, $default = null)
	{
		list($file, $path) = $this->parseKey($key);

		if (! isset($this->loaded[$file])) {
			$this->load($file);
		}

		return $path === null ? $this->loaded[$file] : Arr::get($this->loaded[$file], $path, $default);
	}

	/**
	 * Sets a config value.
	 *
	 * @param   string  $key    Config key
	 * @param   mixed   $value  Config value
	 */
	public function set($key, $value)
	{
		list($file,) = $this->parseKey($key);

		if (! isset($this->loaded[$file])) {
			$this->load($file);
		}

		Arr::set($this->loaded, $key, $value);
	}

	/**
	 * Removes a value from the configuration.
	 *
	 * @param   string   $key  Config key
	 * @return  boolean
	 */
	public function remove($key)
	{
		return Arr::remove($this->loaded, $key);
	}

	/**
	 * Parses the language key.
	 *
	 * @param   string     $key  Language key
	 * @return  array
	 */
	protected function parseKey($key)
	{
		return (strpos($key, '.') === false) ? [$key, null] : explode('.', $key, 2);
	}

	/**
	 * Load Config File
	 *
	 * @param    string $file Configuration file name
	 */
	protected function load($file)
	{
		$path = $this->getFilePath($file);
		if (file_exists($path)) {
			$config = require $path;
		}

		if (! isset($config)) {
			throw new RuntimeException(sprintf(
				"%s(): The file [ %s ] does not exist.",
				__METHOD__, $file
			));
		}

		// Merge environment specific configuration
		if ($this->environment !== null) {
			$namespacePos = strpos($file, '::');

			$namespaced = ($namespacePos === false) ? $this->environment . '.' . $file : substr_replace($file, $this->environment . '.', $namespacePos + 2, 0);

			$path = $this->getFilePath($namespaced);
			if (file_exists($path)) {
				$config = array_replace_recursive($config, include $path);
			}
		}

		$this->loaded[$file] = $config;
	}
}
