<?php
namespace System\Mvc;

use Closure;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use RuntimeException;
use System\Http\Message\Response;
use System\Http\Routing\Route;
use System\Mvc\View\View;

class Dispatcher
{
	/**
	 * @var ServerRequestInterface
	 */
	protected $request;

	/**
	 * @var Response
	 */
	protected $response;

	/**
	 * @var Route
	 */
	protected $route;

	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @var mixed
	 */
	protected $return;

	/**
	 * Should the after filters be skipped?
	 *
	 * @var boolean
	 */
	protected $skipAfterFilters = false;

	/**
	 * @param   ServerRequestInterface $request
	 * @param   ResponseInterface      $response
	 * @param   Route                  $route     The route we're dispatching
	 * @param   Container              $container IoC container
	 */
	public function __construct(ServerRequestInterface $request, ResponseInterface $response, Route $route, Container $container = null)
	{
		$this->request = $request;
		$this->response = $response;
		$this->route = $route;
		$this->container = $container ?: new Container;
	}

	/**
	 * send response
	 */
	public function send()
	{
		if ($this->return instanceof View) {
			$this->container->get('viewRenderer')->render($this->return);
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
		$this->return = $this->container->call($closure, $this->request->getAttributes());
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

			$this->return = $this->container->call(
				[$controller, $method], $this->request->getAttributes()
			);

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
