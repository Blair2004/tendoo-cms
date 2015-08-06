<?php
namespace System\Common;

use RuntimeException;
use System\Core\Container;

trait ContainerAwareTrait
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * Sets the container instance.
	 *
	 * @param   Container $container IoC container instance
	 */
	public function setContainer(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * Resolves item from the container using overloading.
	 *
	 * @param   string $key Key
	 * @return  mixed
	 */
	public function __get($key)
	{
		if (! $this->container->has($key)) {
			throw new RuntimeException(sprintf('Unable to resolve "%s".', $key));
		}

		return $this->container->get($key);
	}
}
