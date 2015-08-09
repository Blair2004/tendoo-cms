<?php
namespace System\Mvc;

use Composer\Autoload\ClassLoader;
use System\Http\Message\Response;
use System\Http\Message\ServerRequest;

class App
{
	/**
	 * @var ClassLoader
	 */
	protected $loader;

	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var Modules
	 */
	protected $modules;

	/**
	 * @var string
	 */
	protected $charset;

	/**
	 * @param ClassLoader $loader
	 */
	public function __construct(ClassLoader $loader)
	{
		$this->loader = $loader;

		// set core
		$this->initialize();

		// set default configs
		$this->configure();

		// Dispatcher

		/** @var ServerRequest $request */
		$request = $this->container->get('serverRequest');

		// get route
		$route = $this->modules->getRouter()->route($request);

		(new Dispatcher($request, new Response(), $route, $this->container))->dispatch()->send();
	}

	/**
	 * Returns the environment. NULL is returned if no environment is specified.
	 *
	 * @return  string|null
	 */
	public function getEnvironment()
	{
		return getenv('APP_ENV') ?: null;
	}

	/**
	 * Returns the app charset.
	 *
	 * @return  string
	 */
	public function getCharset()
	{
		return $this->charset;
	}

	/**
	 * @return ClassLoader
	 */
	public function getLoader()
	{
		return $this->loader;
	}

	/**
	 * Sets up the framework core.
	 */
	protected function initialize()
	{
		// Create IoC container instance and register it in itself so that it can be injected
		$this->container = new Container();
		$this->container->registerInstance(['System\Mvc\Container', 'container'], $this->container);

		// Register self so that the app instance can be injected
		$this->container->registerInstance(['System\Mvc\App', 'app'], $this);

		// Register config instance
		$this->config = new Config(APP_PATH . 'config', $this->getEnvironment());
		$this->container->registerInstance(['System\Mvc\Config', 'config'], $this->config);

		// insert mvc modules
		$this->modules = new Modules(
			$this->container, APP_PATH . 'Modules', $this->config->get('app.modules', [])
		);
		$this->container->registerInstance(['System\Mvc\Modules', 'modules'], $this->modules);
	}

	protected function configure()
	{
		$config = $this->config->get('app');

		// set default mb functions encodings and site default encoding
		$this->charset = $config['charset'];
		if (empty($this->charset)) {
			$this->config->set('app.charset', $this->charset = 'UTF-8');
		}
		mb_language('uni');
		mb_regex_encoding($this->charset);
		mb_internal_encoding($this->charset);

		// set default app time zone
		$timezone = $config['timezone'];
		if (empty($timezone)) {
			$this->config->set('app.timezone', $timezone = 'Asia/Tehran');
		}
		date_default_timezone_set($timezone);

		// set services
		foreach ($config['services'] as $service) {
			/** @var \System\Services\Service $service */
			$service = new $service($this->container);
			$service->register();
		}
	}
}
