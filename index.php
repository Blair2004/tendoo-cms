<?php
/**
 *  Resolve the system path for increased reliability
 */
define('APP_PATH', __DIR__ . DIRECTORY_SEPARATOR);
define('MODULES_PATH', APP_PATH . 'Modules' . DIRECTORY_SEPARATOR);

/**
 * Configure PHP error reporting.
 */
switch (getenv('APP_ENV')) {
	case 'prod':
		ini_set('display_errors', false);
		error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
		break;
	default:
		ini_set('display_errors', true);
		error_reporting(E_ALL);
		break;
}


/**
 * Override the default path for error logs.
 */
ini_set('error_log', APP_PATH . 'storage' . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'error_' . gmdate('Y_m_d') . '.log');

/**
 * Convert all errors to ErrorExceptions.
 */
set_error_handler(function ($code, $message, $file, $line) {
	if ((error_reporting() & $code) !== 0) {
		throw new ErrorException($message, $code, 0, $file, $line);
	}
});

/**
 * Define some constants.
 */
define('APP_START_TIME', microtime(true));
define('APP_START_MEMORY_USAGE', memory_get_usage(true));

/**
 * require composer autoload
 * @var \Composer\Autoload\ClassLoader $loader
 */
$loader = require APP_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * create new app :)
 */
new \System\Mvc\App($loader);
