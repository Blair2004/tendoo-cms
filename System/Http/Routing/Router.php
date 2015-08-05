<?php
namespace System\Http\Routing;

use InvalidArgumentException;
use System\Core\Container;
use System\Http\Exceptions\NotFoundException;
use System\Http\Exceptions\MethodNotAllowedException;
use System\Http\Message\Response;
use System\Http\Message\ServerRequest;

class Router
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @var array
	 */
	protected $modules;

	/**
	 * @var array array of uri matched Routes but method not allow
	 */
	protected $matchedRoutes;

	/**
	 * @param Container $container
	 * @param array     $modules
	 */
	public function __construct(Container $container, array $modules = [])
	{
		$this->container = $container;
		$this->modules = $modules;
	}

	/**
	 * Matches and returns the appropriate route along with its parameters.
	 *
	 * @param ServerRequest $request
	 * @return  Route
	 */
	public function route(ServerRequest $request)
	{
		$parameters = [];

		$requestUri = $request->getPath();
		$requestMethod = $request->getMethod();

		foreach ($this->modules as $moduleName) {

			$modulePath = MODULES_PATH . $moduleName . DIRECTORY_SEPARATOR . 'Modules.php';
			if (! file_exists($modulePath)) {
				continue;
			}

			include $modulePath;
			$module = $this->container->get($moduleName . '\\Modules');

			if (! method_exists($module, 'getRoutes')) {
				continue;
			}

			/** @var Routes $routes */
			$routes = $module->getRoutes(new Routes());
			if (! $routes instanceof Routes) {
				throw new InvalidArgumentException(
					'Modules getRoutes method must return an instanceof System\Http\Routing\Routes'
				);
			}

			/** @var Route $route */
			foreach ($routes->getRoutes() as $route) {
				if ($this->matches($route, $requestUri, $parameters)) {
					if (! $route->allows($requestMethod)) {
						$this->matchedRoutes[] = $route;
						continue;
					}

					// If this is an "OPTIONS" request then well collect all the allowed request methods
					// from all routes matching the requested path. We'll then add an "allows" header
					// to the matched route
					if ($requestMethod === 'OPTIONS') {
						return [$this->optionsRoute($requestUri), []];
					}

					// set request attributes
					foreach ($parameters as $name => $value) {
						$request->withAttribute($name, $value);
					}

					// run module bootstrap
					if (method_exists($module, 'onBootstrap')) {
						/** @var callable $module */
						$this->container->call([$module, 'onBootstrap']);
					}

					return $route;
				}
			}
		}

		if ($this->matchedRoutes) {
			// We found a matching route but it does not allow the request method
			// so we'll throw a 405 exception
			throw new MethodNotAllowedException(
				$this->getAllowedMethodsForMatchingRoutes($requestUri)
			);
		} else {
			// No routes matched so we'll throw a 404 exception
			throw new NotFoundException();
		}
	}

	/**
	 * Returns TRUE if the route matches the request uri and FALSE if not.
	 *
	 * @param   Route  $route
	 * @param   string $uri
	 * @param   array  $parameters Parameters
	 * @return  boolean
	 */
	protected function matches(Route $route, $uri, array &$parameters = [])
	{
		if (preg_match($route->getPattern(), $uri, $parameters)) {
			foreach ($parameters as $key => $value) {
				if (is_int($key)) {
					unset($parameters[$key]);
				}
			}

			return true;
		}

		return false;
	}

	/**
	 * Returns an array of all allowed request methods for the requested route.
	 *
	 * @param   string $requestUri
	 * @return  array
	 */
	protected function getAllowedMethodsForMatchingRoutes($requestUri)
	{
		$methods = [];

		/** @var Route $route */
		foreach ($this->matchedRoutes as $route) {
			if ($this->matches($route, $requestUri)) {
				$methods = array_merge($methods, $route->getMethods());
			}
		}

		return array_unique($methods);
	}

	/**
	 * Returns a route with a closure action that sets the allow header.
	 *
	 * @param   string $request_uri
	 * @return  Route
	 */
	protected function optionsRoute($request_uri)
	{
		$allowedMethods = $this->getAllowedMethodsForMatchingRoutes($request_uri);

		return new Route([], '', function () use ($allowedMethods) {
			return (new Response())->withHeader('allow', implode(',', $allowedMethods));
		});
	}
}
