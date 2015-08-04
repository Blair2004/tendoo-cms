<?php
namespace System\Common;

use OutOfBoundsException;

trait NamespacedFileLoaderTrait
{
	/**
	 * @var string
	 */
	protected $path;

	/**
	 * Default files extension.
	 *
	 * @var string
	 */
	protected $extension = '.php';

	/**
	 * @var array
	 */
	protected $namespaces = [];

	/**
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param   string $extension Extension
	 */
	public function setExtension($extension)
	{
		$this->extension = $extension;
	}

	/**
	 * @param   string $namespace Namespace name
	 * @param   string $path      Namespace path
	 */
	public function registerNamespace($namespace, $path)
	{
		$this->namespaces[$namespace] = $path;
	}

	/**
	 * @param $namespace
	 * @return  string
	 */
	public function getNamespaceValue($namespace)
	{
		if (! isset($this->namespaces[$namespace])) {
			throw new OutOfBoundsException(sprintf('The "%s" namespace does not exist.', $namespace));
		}

		return $this->namespaces[$namespace];
	}

	/**
	 * Returns the path to the file.
	 *
	 * @param   string $file      File name
	 * @param   string $extension File extension
	 * @param   string     $suffix     Path suffix
	 * @return  array
	 */
	public function getFilePath($file, $extension = null, $suffix = null)
	{
		if (strpos($file, '::') === false) {
			// No namespace so we'll just use the default path
			$path = $this->path;
		} else {
			// The file is namespaced so we'll use the namespace path
			list($namespace, $file) = explode('::', $file, 2);
			$path = $this->getNamespaceValue($namespace);
		}

		if ($suffix !== null) {
			$path .= rtrim($suffix, '/\\') . DIRECTORY_SEPARATOR;
		}

		return $path . str_replace('.', DIRECTORY_SEPARATOR, $file) . ($extension ?: $this->extension);
	}
}
