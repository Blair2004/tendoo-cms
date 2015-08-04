<?php
namespace System\Session;

use RuntimeException;
use SessionHandlerInterface;
use System\Utility\Arr;

class Session
{
	/**
	 * @var boolean
	 */
	protected $started = false;

	/**
	 * @var array
	 */
	protected $flashData = [];

	/**
	 * @var string
	 */
	protected $flashDataSesName = '__flashData';

	/**
	 * @param array                        $options
	 * @param SessionHandlerInterface|null $handler
	 */
	public function __construct(array $options = [], SessionHandlerInterface $handler = null)
	{
		$this->setOptions($options);

		! $handler or session_set_save_handler($handler);
		register_shutdown_function([$this, 'destruct']);

		$_SESSION = [];
	}

	public function destruct()
	{
		// Replace old flash data with new
		$_SESSION[$this->flashDataSesName] = $this->flashData;

		session_write_close();
	}

	public function start()
	{
		if ($this->started) {
			return;
		}

		if (PHP_SESSION_ACTIVE === session_status()) {
			throw new RuntimeException('Failed to start the session: already started by PHP.');
		}

		if (ini_get('session.use_cookies') and headers_sent($file, $line)) {
			throw new RuntimeException(sprintf(
				'Failed to start the session because headers have already been sent by "%s" at line %d.',
				$file, $line
			));
		}

		if (! session_start()) {
			throw new RuntimeException('Failed to start the session');
		}

		$this->started = true;
	}

	/**
	 * @return  string
	 */
	public function getId()
	{
		return session_id();
	}

	/**
	 * @param   boolean $keepOld Keep the session data associated with the old session id?
	 * @return  bool
	 */
	public function regenerateId($keepOld = false)
	{
		return session_regenerate_id($keepOld);
	}

	/**
	 * Returns all the session data.
	 *
	 * @return  array
	 */
	public function getData()
	{
		return $_SESSION;
	}

	/**
	 * Store a value in the session.
	 *
	 * @param   string $path
	 * @param   mixed  $value Session data
	 */
	public function put($path, $value)
	{
		Arr::set($_SESSION, $path, $value);
	}

	/**
	 * Returns TRUE if key exists in the session and FALSE if not.
	 *
	 * @param   string $path
	 * @return  boolean
	 */
	public function has($path)
	{
		return Arr::has($_SESSION, $path);
	}

	/**
	 * Returns a value from the session.
	 *
	 * @param   string $path
	 * @param   mixed  $default Default value
	 * @return  mixed
	 */
	public function get($path, $default = null)
	{
		return Arr::get($_SESSION, $path, $default);
	}

	/**
	 * Retrieving And Deleting An Item
	 *
	 * @param      $path
	 * @param null $default
	 * @return mixed
	 */
	public function pull($path, $default = null)
	{
		$session = $this->get($path, $default);
		$this->remove($path);

		return $session;
	}

	/**
	 * Removes a value from the session.
	 *
	 * @param   string $path
	 * @return bool
	 */
	public function remove($path)
	{
		return Arr::remove($_SESSION, $path);
	}

	/**
	 * Store a flash value in the session.
	 *
	 * @param   string $key   Flash key
	 * @param   mixed  $value Flash data
	 */
	public function putFlash($key, $value)
	{
		$this->flashData[$key] = $value;
	}

	/**
	 * Returns TRUE if key exists in the session and FALSE if not.
	 *
	 * @param   string $key Session key
	 * @return  bool
	 */
	public function hasFlash($key)
	{
		return isset($_SESSION[$this->flashDataSesName][$key]);
	}

	/**
	 * Returns a flash value from the session.
	 *
	 * @param   string $key     Session key
	 * @param   mixed  $default Default value
	 * @return  mixed
	 */
	public function getFlash($key, $default = null)
	{
		return $this->hasFlash($key) ? $_SESSION[$this->flashDataSesName][$key] : $default;
	}

	/**
	 * Removes a value from the session.
	 *
	 * @param   string $key Session key
	 * @return  bool
	 */
	public function removeFlash($key)
	{
		if (! $this->hasFlash($key)) {
			return false;
		}

		unset($_SESSION[$this->flashDataSesName][$key]);

		return true;
	}

	/**
	 * Extends the lifetime of the flash data by one request.
	 *
	 * @param   array $keys Keys to preserve
	 */
	public function reFlash(array $keys = [])
	{
		$flashData = isset($_SESSION[$this->flashDataSesName]) ? $_SESSION[$this->flashDataSesName] : [];

		$flashData = empty($keys) ? $flashData : array_intersect_key($flashData, array_flip($keys));

		$this->flashData = array_merge($this->flashData, $flashData);
	}

	public function clear()
	{
		session_unset();
	}

	/**
	 * @return bool
	 */
	public function destroy()
	{
		return session_destroy();
	}

	/**
	 * Sets session.* ini variables.
	 * For convenience we omit 'session.' from the beginning of the keys.
	 * Explicitly ignores other ini keys.
	 *
	 * @param array $options Session ini directives array(key => value).
	 * @see http://php.net/session.configuration
	 */
	public function setOptions(array $options)
	{
		$validOptions = array_flip([
			'cache_limiter', 'cache_expire', 'cookie_domain', 'cookie_httponly',
			'cookie_lifetime', 'cookie_path', 'cookie_secure',
			'entropy_file', 'entropy_length', 'gc_divisor',
			'gc_maxlifetime', 'gc_probability', 'hash_bits_per_character',
			'hash_function', 'name', 'referer_check',
			'serialize_handler', 'use_cookies', 'save_path',
			'use_only_cookies', 'use_trans_sid', 'upload_progress.enabled',
			'upload_progress.cleanup', 'upload_progress.prefix', 'upload_progress.name',
			'upload_progress.freq', 'upload_progress.min_freq', 'url_rewriter.tags',
		]);

		foreach ($options as $key => $value) {
			if (isset($validOptions[$key])) {
				ini_set('session.' . $key, $value);
			}
		}
	}
}