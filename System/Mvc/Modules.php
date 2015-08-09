<?php
namespace System\Mvc;

use OutOfBoundsException;
use RuntimeException;
use System\Mvc\Http\Routing\Router;

class Modules
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var array
	 */
	protected $modules;

	/**
	 * @param Container $container
	 * @param string    $path
	 * @param array     $modules
	 */
	public function __construct(Container $container, $path, array $modules = [])
	{
		$this->container = $container;
		$this->path = rtrim($path, '/\\') . DIRECTORY_SEPARATOR;
		$this->modules = $modules;
	}

	/**
	 * @return array array of modules name
	 */
	public function getModules()
	{
		return $this->modules;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param $name
	 * @return object
	 */
	public function performModule($name)
	{
		if (! in_array($name, $this->modules)) {
			throw new OutOfBoundsException(sprintf(
				'Module "%s" does not exist.', $name
			));
		}

		$modulePath = $this->path . $name . DIRECTORY_SEPARATOR . 'Modules.php';
		if (! file_exists($modulePath)) {
			throw new RuntimeException(sprintf(
				'Module "%s" config file does not exist.', $name
			));
		}

		require $modulePath;

		return $this->container->get($name . '\\Modules');
	}

	/**
	 * @return array array of Module.php file object
	 */
	public function performModules()
	{
		$out = [];
		foreach ($this->modules as $moduleName) {
			$out[$moduleName] = $this->performModule($moduleName);
		}

		return $out;
	}

	/**
	 * @return Router
	 */
	public function getRouter()
	{
		return new Router($this->container, $this->performModules());
	}
}
