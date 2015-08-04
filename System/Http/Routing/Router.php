<?php
namespace System\Http\Routing;

use System\Http\Exceptions\NotFoundException;
use System\Http\Exceptions\MethodNotAllowedException;
use System\Http\Message\Response;
use System\Http\Message\ServerRequest;

class Router
{
	/**
	 * routes
	 *
	 * @var array
	 */
	protected $routes = [];

	/**
	 * Construct.
	 *
	 * @param Routes $routes
	 */
	public function __construct(Routes $routes)
	{
		$this->routes = $routes->getRoutes();
	}

	/**
	 * Matches and returns the appropriate route along with its parameters.
	 *
	 * @param ServerRequest $request
	 * @return  array
	 */
	public function route(ServerRequest $request)
	{
		$matched = false;
		$parameters = [];

		$requestUri = $request->getPath();
		$requestMethod = $request->getMethod();

		/** @var Route $route */
		foreach ($this->routes as $route) {
			if (! $this->matches($route, $requestUri, $parameters)) {
				continue;
			}

			if (! $route->allows($requestMethod)) {
				$matched = true;
				continue;
			}

			// If this is an "OPTIONS" request then well collect all the allowed request methods
			// from all routes matching the requested path. We'll then add an "allows" header
			// to the matched route
			if ($requestMethod === 'OPTIONS') {
				return [$this->optionsRoute($requestUri), []];
			}

			// Return the matched route and parameters
			return [$route, $parameters];
		}

		if ($matched) {
			// We found a matching route but it does not allow the request method so we'll throw a 405 exception
			throw new MethodNotAllowedException($this->getAllowedMethodsForMatchingRoutes($requestUri));
		} else {
			// No routes matched so we'll throw a 404 exception
			throw new NotFoundException();
		}
	}

	/**
	 * Returns TRUE if the route matches the request uri and FALSE if not.
	 *
	 * @param   Route  $route
	 * @param   string  $uri
	 * @param   array  $parameters  Parameters
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
	 * @param   string     $requestUri
	 * @return  array
	 */
	protected function getAllowedMethodsForMatchingRoutes($requestUri)
	{
		$methods = [];

		/** @var Route $route */
		foreach ($this->routes as $route) {
			if ($this->matches($route, $requestUri)) {
				$methods = array_merge($methods, $route->getMethods());
			}
		}

		return array_unique($methods);
	}

	/**
	 * Returns a route with a closure action that sets the allow header.
	 *
	 * @param   string                    $request_uri
	 * @return  Route
	 */
	protected function optionsRoute($request_uri)
	{
		$allowedMethods = $this->getAllowedMethodsForMatchingRoutes($request_uri);

		return new Route([], '', function() use ($allowedMethods) {
			return (new Response())->withHeader('allow', implode(',', $allowedMethods));
		});
	}
}
