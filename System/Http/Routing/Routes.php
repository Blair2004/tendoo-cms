<?php
namespace System\Http\Routing;

use Closure;

class Routes
{
	/**
	 * @var array
	 */
	protected $routes = [];

	/**
	 * @var array
	 */
	protected $groups = [];

	/**
	 * Adds a grouped set of routes to the collection.
	 *
	 * @param   array   $options Group options
	 * @param   Closure $routes  Route closure
	 */
	public function group(array $options, Closure $routes)
	{
		$this->groups[] = $options;

		$routes($this);

		array_pop($this->groups);
	}

	/**
	 * Adds a route that responds to all HTTP methods to the collection.
	 *
	 * @param                           $uri
	 * @param   string|Closure         $action
	 * @return  Route
	 */
	public function any($uri, $action)
	{
		return $this->custom(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'], $uri, $action);
	}

	/**
	 * Adds a route that responds to GET requests to the collection.
	 *
	 * @param   string         $uri
	 * @param   string|Closure $action Route action
	 * @return  Route
	 */
	public function get($uri, $action)
	{
		return $this->custom(['GET', 'HEAD', 'OPTIONS'], $uri, $action);
	}

	/**
	 * Adds a route that responds to POST requests to the collection.
	 *
	 * @param   string         $uri
	 * @param   string|Closure $action Route action
	 * @return Route
	 */
	public function post($uri, $action)
	{
		return $this->custom(['POST', 'OPTIONS'], $uri, $action);
	}

	/**
	 * Adds a route that responds to PUT requests to the collection.
	 *
	 * @param   string         $uri
	 * @param   string|Closure $action Route action
	 * @return Route
	 */
	public function put($uri, $action)
	{
		return $this->custom(['PUT', 'OPTIONS'], $uri, $action);
	}

	/**
	 * Adds a route that responds to PATCH requests to the collection.
	 *
	 * @param   string         $uri
	 * @param   string|Closure $action Route action
	 * @return Route
	 */
	public function patch($uri, $action)
	{
		return $this->custom(['PATCH', 'OPTIONS'], $uri, $action);
	}

	/**
	 * Adds a route that responds to DELETE requests to the collection.
	 *
	 * @param   string         $uri
	 * @param   string|Closure $action Route action
	 * @return Route
	 */
	public function delete($uri, $action)
	{
		return $this->custom(['DELETE', 'OPTIONS'], $uri, $action);
	}

	/**
	 * Adds a route that responds to the chosen HTTP methods to the collection.
	 *
	 * @param   array          $methods Array of HTTP methods the route should respond to
	 * @param   string         $uri
	 * @param   string|Closure $action  Route action
	 * @return Route
	 */
	public function custom(array $methods, $uri, $action)
	{
		$route = new Route($methods, $uri, $action);

		if (! empty($this->groups)) {
			foreach ($this->groups as $group) {
				foreach ($group as $option => $value) {
					$route->{$this->getRealMethodName($option)}($value);
				}
			}
		}

		return $this->routes[] = $route;
	}

	/**
	 * Returns the registered routes.
	 *
	 * @return  array
	 */
	public function getRoutes()
	{
		return $this->routes;
	}

	/**
	 * Returns the real route method name.
	 *
	 * @param   string  $method  Method name
	 * @return  string
	 */
	protected function getRealMethodName($method)
	{
		return str_replace(
			['namespace', 'name', 'prefix'],
			['setNamespace', 'setNamePrefix', 'setUriPrefix'],
			$method
		);
	}
}
