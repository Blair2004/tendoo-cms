<?php
namespace System\Services;

use System\Http\Message\ServerRequestFactory;

class ServerRequest extends Service
{
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->registerSingleton(['System\Http\Message\ServerRequest', 'serverRequest'], function () {
			return ServerRequestFactory::fromGlobals();
		});
	}
}
