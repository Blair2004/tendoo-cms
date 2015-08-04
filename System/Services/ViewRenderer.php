<?php
namespace System\Services;

use System\Core\App;

class ViewRenderer extends Service
{
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->registerSingleton(['System\Mvc\View\ViewRenderer', 'viewRenderer'], function (App $app) {
			$cachePath = APP_PATH . 'storage/cache';
			return new \System\Mvc\View\ViewRenderer($cachePath, $app->getCharset());
		});
	}
}