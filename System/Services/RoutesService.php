<?php
namespace System\Services;

class RoutesService extends Service
{
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->register(['System\Mvc\Http\Routing\Routes', 'routes'], 'System\Mvc\Http\Routing\Routes');
	}
}