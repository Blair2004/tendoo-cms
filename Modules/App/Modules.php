<?php
namespace App;

use System\Core\App;
use System\Http\Routing\Routes;
use System\Mvc\View\ViewRenderer;

class Modules
{
	public function onBootstrap(App $app, ViewRenderer $viewRenderer)
	{
		$app->getLoader()->addPsr4(__NAMESPACE__ . '\\', MODULES_PATH . __NAMESPACE__);

		$viewRenderer->setPath(MODULES_PATH . __NAMESPACE__ . DIRECTORY_SEPARATOR . 'views');
	}

	public function getRoutes(Routes $routes)
	{
		$routes->any('/test', 'App\Controllers\Home::index', 'route1');

		return $routes;
	}
}
