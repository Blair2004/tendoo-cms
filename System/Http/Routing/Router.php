<?php
namespace System\Http\Routing;

use Psr\Http\Message\ServerRequestInterface;
use System\Http\Exceptions\NotFoundException;
use System\Http\Exceptions\MethodNotAllowedException;
use System\Http\Message\Response;

class Router
{
	/**
	 * @var Routes
	 */
	protected $routes;

	/**
	 * @param Routes $routes
	 */
	public function __construct(Routes $routes)
	{
		$this->routes = $routes;
	}

	/**
	 * Matches and returns the appropriate route along with its parameters.
	 *
	 * @param ServerRequestInterface $request
	 * @return  Route
	 */
	public function route(ServerRequestInterface $request)
	{
		$matched = false;
		$parameters = [];

		$requestTarget = parse_url($request->getRequestTarget(), PHP_URL_PATH);
		$requestMethod = $request->getMethod();

		/** @var Route $route */
		foreach ($this->routes->getRoutes() as $route) {
			if ($this->matches($route, $requestTarget, $parameters)) {
				if (! $route->allows($requestMethod)) {
					$matched = true;
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

				return $route;
			}
		}

		if ($matched) {
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
		foreach ($this->routes->getRoutes() as $route) {
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
