<?php
namespace System\Services;

use System\Http\Message\ServerRequestFactory;

class Request extends Service
{
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->registerSingleton(['System\Http\Message\ServerRequest', 'request'], function () {
			return ServerRequestFactory::fromGlobals();
		});
	}
}
