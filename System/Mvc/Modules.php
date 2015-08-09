<?php
namespace System\Mvc;

use OutOfBoundsException;
use RuntimeException;
use System\Http\Routing\Route;
use System\Http\Routing\Routes;

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
	 * @var array
	 */
	protected $routes = [];

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

		$modulePath = $this->path . $name . DIRECTORY_SEPARATOR . 'Module.php';
		if (! file_exists($modulePath)) {
			throw new RuntimeException(sprintf(
				'Module "%s" config file does not exist.', $name
			));
		}

		require_once $modulePath;

		return $this->container->get($name . '\\Module');
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
	 * @param Routes $routes
	 * @return Routes
	 */
	public function getRoutes(Routes $routes)
	{
		$oldRoutes = [];
		foreach ($this->performModules() as $moduleName => $module) {
			if (! method_exists($module, 'routes')) {
				continue;
			}

			$module->routes($routes);

			$routesArr = $routes->getRoutes();
			$this->routes[$moduleName] = array_udiff($routesArr, $oldRoutes, function ($a, $b) {
				return strcmp(spl_object_hash($a), spl_object_hash($b));
			});
			$oldRoutes = $routesArr;
		}

		return $routes;
	}

	/**
	 * @param Route $route
	 * @return object|null
	 */
	public function getActive(Route $route)
	{
		foreach ($this->routes as $moduleName => $routes) {
			if (in_array($route, $routes, true)) {
				return $this->performModule($moduleName);
			}
		}

		return null;
	}

	/**
	 * @param Route $route
	 */
	public function runActive(Route $route)
	{
		$module = $this->getActive($route);
		if (! $module) {
			return;
		}

		if (method_exists($module, 'onRoute')) {
			$this->container->call([$module, 'onRoute']);
		}
	}
}
