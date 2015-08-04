<?php
namespace System\Services;

class Routes extends Service
{
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->registerSingleton(['System\Http\Routing\Routes', 'routes'], 'System\Http\Routing\Routes');
	}
}