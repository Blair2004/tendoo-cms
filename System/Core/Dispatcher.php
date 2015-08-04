<?php
namespace System\Core;

use Closure;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use System\Http\Message\Response;
use System\Http\Routing\Route;
use System\Mvc\View\View;
use System\Mvc\View\ViewRenderer;

class Dispatcher
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @var Response
	 */
	protected $response;

	/**
	 * @var Route
	 */
	protected $route;

	/**
	 * @var mixed
	 */
	protected $return;

	/**
	 * Route parameters.
	 *
	 * @var array
	 */
	protected $parameters;

	/**
	 * Should the after filters be skipped?
	 *
	 * @var boolean
	 */
	protected $skipAfterFilters = false;

	/**
	 * @param   ResponseInterface $response
	 * @param   Route             $route      The route we're dispatching
	 * @param   array             $parameters Route parameters
	 * @param   Container         $container  IoC container
	 */
	public function __construct(ResponseInterface $response, Route $route, array $parameters = [], Container $container = null)
	{
		$this->response = $response;
		$this->route = $route;
		$this->parameters = $parameters;
		$this->container = $container ?: new Container;
	}

	/**
	 * send response
	 */
	public function send()
	{
		if ($this->return instanceof View) {
			/** @var App $app */
			$app = $this->container->get('app');
			$module = $app->getModule(current(explode('\\', $this->route->getAction())));

			/** @var ViewRenderer $r */
			$r = $this->container->get('viewRenderer');
			$r->setPath($module->getConfig()['view_path']);
			$r->render($this->return);
		} elseif ($this->return instanceof ResponseInterface) {
			$this->return->send();
		} else {
			$this->response->getBody()->write($this->return);
			$this->response->send();
		}
	}

	/**
	 * @return $this
	 */
	public function dispatch()
	{
		foreach ($this->route->getBeforeFilters() as $filter) {
			$return = $this->container->call($this->makeCallable($filter));

			if (! empty($return)) {
				break;
			}
		}

		if (empty($return)) {
			$action = $this->route->getAction();

			if ($action instanceof Closure) {
				$this->dispatchClosure($action);
			} else {
				$this->dispatchController($action);
			}

			if (! $this->skipAfterFilters) {
				foreach ($this->route->getAfterFilters() as $filter) {
					$this->container->call($this->makeCallable($filter));
				}
			}
		} else {
			$this->return = $return;
		}

		return $this;
	}

	/**
	 * Dispatch a closure controller action.
	 *
	 * @param   Closure $closure Closure
	 */
	protected function dispatchClosure(Closure $closure)
	{
		$this->return = $this->container->call($closure, $this->parameters);
	}

	/**
	 * Dispatch a controller action.
	 *
	 * @param   string $controller Controller
	 */
	protected function dispatchController($controller)
	{
		list($controller, $method) = explode('::', $controller, 2);

		$controller = $this->container->get($controller);

		// Execute the before filter if we have one
		if (method_exists($controller, 'beforeFilter')) {
			$this->return = $this->container->call([$controller, 'beforeFilter']);
		}

		if (empty($this->return)) {
			// The before filter didn't return any data so we can set the
			// response body to whatever the route action returns

			$this->return = $this->container->call([$controller, $method], $this->parameters);

			// Execute the after filter if we have one

			if (method_exists($controller, 'afterFilter')) {
				$this->container->call([$controller, 'afterFilter']);
			}
		} else {
			$this->skipAfterFilters = true;
		}
	}

	/**
	 * make string and Closure and function to callable
	 *
	 * @param string|Closure $action
	 * @return callable
	 * @throws RuntimeException
	 */
	protected function makeCallable($action)
	{
		if ($action instanceof Closure) {
			return $action;
		}

		list($class, $method) = explode('::', $action, 2);

		$callable = [$this->container->get($class), $method];

		return $callable;
	}
}
