<?php
namespace System\Services;

use System\Core\Config;

class ModulesManager extends Service
{
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->registerSingleton(['System\Core\ModulesManager', 'modulesManager'], function (Config $config) {
			return new \System\Core\ModulesManager($config->get('app.modules', []));
		});
	}
}