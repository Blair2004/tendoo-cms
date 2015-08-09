<?php
namespace System\Services;

use System\Mvc\Container;

abstract class Service
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @param   Container  $container  IoC container instance
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Registers the service.
	 */
	abstract public function register();
}
