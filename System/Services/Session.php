<?php
namespace System\Services;

class Session extends Service
{
	/**
	 * {@inheritdoc}
	 */
	public function register()
	{
		$this->container->registerSingleton(['System\Session\Session', 'session'], function () {
			$options = [
				'name' => 'elegantCMF',
				'save_path' => APP_PATH . 'storage' . DIRECTORY_SEPARATOR . 'session'
			];
			$session = new \System\Session\Session($options);
			$session->start();

			return $session;
		});
	}
}
