<?php
namespace Test;

use System\Mvc\App;
use System\Http\Routing\Routes;
use System\Mvc\View\ViewRenderer;

class Module
{
	public function __construct(App $app)
	{
		$app->getLoader()->addPsr4(__NAMESPACE__ . '\\', MODULES_PATH . __NAMESPACE__);
	}

	public function onRoute(ViewRenderer $viewRenderer)
	{
		$viewRenderer->setPath(MODULES_PATH . __NAMESPACE__ . DIRECTORY_SEPARATOR . 'views');
	}

	public function routes(Routes $routes)
	{
		$routes->any('/test', 'Test\Controllers\Home::index');
	}
}
