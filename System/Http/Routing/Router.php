<?php
namespace System\Http\Routing;

use Psr\Http\Message\ServerRequestInterface;
use System\Core\Container;
use System\Http\Exceptions\NotFoundException;
use System\Http\Exceptions\MethodNotAllowedException;
use System\Http\Message\Response;

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
	 * @param ServerRequestInterface $request
	 * @return  Route
	 */
	public function route(ServerRequestInterface $request)
	{
		$parameters = [];

		$requestTarget = parse_url($request->getRequestTarget(), PHP_URL_PATH);
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

			$routes = new Routes();
			$module->getRoutes($routes);

			/** @var Route $route */
			foreach ($routes->getRoutes() as $route) {
				if ($this->matches($route, $requestTarget, $parameters)) {
					if (! $route->allows($requestMethod)) {
						$this->matchedRoutes[] = $route;
						continue;
					}

					// If this is an "OPTIONS" request then well collect all the allowed request methods
					// from all routes matching the requested path. We'll then add an "allows" header
					// to the matched route
					if ($requestMethod === 'OPTIONS') {
						return $this->optionsRoute($requestTarget);
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
				$this->getAllowedMethodsForMatchingRoutes($requestTarget)
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
	 * @param   string $requestTarget
	 * @param   array  $parameters Parameters
	 * @return  boolean
	 */
	protected function matches(Route $route, $requestTarget, array &$parameters = [])
	{
		if (preg_match($route->getPattern(), $requestTarget, $parameters)) {
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
	 * @param   string $requestTarget
	 * @return  array
	 */
	protected function getAllowedMethodsForMatchingRoutes($requestTarget)
	{
		$methods = [];

		/** @var Route $route */
		foreach ($this->matchedRoutes as $route) {
			if ($this->matches($route, $requestTarget)) {
				$methods = array_merge($methods, $route->getMethods());
			}
		}

		return array_unique($methods);
	}

	/**
	 * Returns a route with a closure action that sets the allow header.
	 *
	 * @param   string $requestTarget
	 * @return  Route
	 */
	protected function optionsRoute($requestTarget)
	{
		$allowedMethods = $this->getAllowedMethodsForMatchingRoutes($requestTarget);

		return new Route([], '', function () use ($allowedMethods) {
			return (new Response())->withHeader('allow', implode(',', $allowedMethods));
		});
	}
}
