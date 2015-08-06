<?php
namespace System\Http\Message;

use SimpleXMLElement;
use InvalidArgumentException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
	/**
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * @var array
	 */
	protected $cookieParams = [];

	/**
	 * @var array|object|array
	 */
	protected $parsedBody;

	/**
	 * @var array
	 */
	protected $queryParams = [];

	/**
	 * @var array
	 */
	protected $serverParams = [];

	/**
	 * @var array An array tree of UploadedFileInterface instances
	 */
	protected $uploadedFiles = [];

	/**
	 * @var string
	 */
	protected $baseURL;

	/**
	 * @var string
	 */
	protected $basePath = '';

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * @var string
	 */
	protected $locale;

	/**
	 * @var string
	 */
	protected $localePrefix;

	/**
	 * @var string
	 */
	protected $defaultLocale;

	/**
	 * @var string
	 */
	protected $defaultLocalePrefix;

	/**
	 * @var string
	 */
	protected $clientIp;

	/**
	 * Is this an Ajax request?
	 *
	 * @var boolean
	 */
	protected $isAjax;

	/**
	 * Was the request made using HTTPS?
	 *
	 * @var boolean
	 */
	protected $isSecure;

	/**
	 * @param array  $server     The SERVER parameters
	 * @param array  $cookie     The COOKIE parameters
	 * @param array  $query      The GET parameters
	 * @param array  $files      The FILES parameters
	 * @param array  $attributes The request attributes (parameters parsed from the PATH_INFO, ...)
	 * @param string $body       The raw body data
	 */
	public function __construct(array $server = [], array $cookie = [], array $query = [], array $files = [], array $attributes = [], $body = 'php://input')
	{
		$this->validateUploadedFiles($files);

		$this->serverParams = $server;
		$this->cookieParams = $cookie;
		$this->queryParams = $query;
		$this->uploadedFiles = $files;
		$this->attributes = $attributes;

		$this->collectInfo();


		$this->path = $this->determinePath();
		$query = empty($this->serverParams['QUERY_STRING']) ? '' : '?' . $this->serverParams['QUERY_STRING'];
		$this->requestTarget = $this->getPath() . $query;
		$uri = $this->getBaseUrl() . $this->getPath() . $query;

		parent::__construct($body, $uri, $this->determineMethod(), $this->collectHeaders());
	}

	/**
	 * {@inheritdoc}
	 */
	public function getServerParams()
	{
		return $this->serverParams;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getCookieParams()
	{
		return $this->cookieParams;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withCookieParams(array $cookies)
	{
		$new = clone $this;
		$new->cookieParams = $cookies;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getQueryParams()
	{
		return $this->queryParams;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withQueryParams(array $query)
	{
		$new = clone $this;
		$new->queryParams = $query;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getUploadedFiles()
	{
		return $this->uploadedFiles;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withUploadedFiles(array $uploadedFiles)
	{
		$this->validateUploadedFiles($uploadedFiles);

		$new = clone $this;
		$new->uploadedFiles = $uploadedFiles;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getParsedBody()
	{
		if ($this->parsedBody === null) {
			switch ($this->getHeader('content-type')) {
				case 'multipart/form-data':
				case 'application/x-www-form-urlencoded':
					$this->parsedBody = $_POST;
					break;
				case 'text/json':
				case 'application/json':
					$this->parsedBody = json_decode($this->getBody(), true);
					break;
				case 'text/xml':
				case 'application/xml':
					$this->parsedBody = new SimpleXMLElement($this->getBody());
					break;
				default:
					$this->parsedBody = [];
					break;
			}
		}

		return $this->parsedBody;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withParsedBody($data)
	{
		if (! is_array($data) and ! is_object($data) and $data !== null) {
			throw new InvalidArgumentException(sprintf(
				'Parsed body must array or object or null "%s" given.',
				(is_object($data) ? get_class($data) : gettype($data))
			));
		}

		$new = clone $this;
		$new->parsedBody = $data;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttributes()
	{
		return $this->attributes;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getAttribute($name, $default = null)
	{
		if (isset($this->attributes[$name])) {
			return $this->attributes[$name];
		}

		return $default;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withAttribute($name, $value)
	{
		$new = clone $this;
		$new->attributes[$name] = $value;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withoutAttribute($name)
	{
		if (! isset($this->attributes[$name])) {
			return $this;
		}

		$new = clone $this;
		unset($new->attributes[$name]);

		return $new;
	}

	/**
	 * @return Uri
	 */
	public function getBaseUrl()
	{
		if ($this->baseURL !== null) {
			return $this->baseURL;
		}

		$uri = new Uri('');

		// URI scheme
		$uri = $uri->withScheme($this->isSecure ? 'https' : 'http');

		// Set the server name and port
		if (empty($this->serverParams['HTTP_HOST'])) {
			$host = isset($this->serverParams['SERVER_NAME']) ? $this->serverParams['SERVER_NAME'] : '';
			$port = isset($this->serverParams['SERVER_PORT']) ? $this->serverParams['SERVER_PORT'] : null;
		} else {
			@list($host, $port) = explode(':', $this->serverParams['HTTP_HOST']);
		}

		if (! empty($host)) {
			$uri = $uri->withHost($host);
			if (! empty($port)) {
				/** @var Uri $uri */
				$uri = $uri->withPort($port);
			}
		}

		// set base path
		if (! empty($this->basePath)) {
			$uri = $uri->withPath($this->basePath);
		}

		return $this->baseURL = $uri;
	}

	/**
	 * @return string
	 */
	public function getBasePath()
	{
		return $this->basePath;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Determines the request path.
	 *
	 * @param   array $languages Locale segments
	 * @return  string
	 */
	protected function determinePath(array $languages = [])
	{
		if ($path = parse_url($this->serverParams['REQUEST_URI'], PHP_URL_PATH)) {
			// Remove base path from the request path
			$basePath = $this->getBasePath();
			if ($basePath !== '/' and stripos($path, $basePath) === 0) {
				$path = mb_substr($path, mb_strlen($basePath));
			}

			$path = rawurldecode($path);

			if ($path !== '/') {
				$path = $this->stripLocaleSegment($languages, $path);
			}
		} else {
			$path = '/';
		}

		return $path;
	}

	/**
	 * @return  string
	 */
	public function getLocale()
	{
		return $this->locale ?: $this->defaultLocale;
	}

	/**
	 * @return  string
	 */
	public function getLocalePrefix()
	{
		return $this->localePrefix ?: $this->defaultLocalePrefix;
	}

	/**
	 * Strips the locale segment from the path.
	 *
	 * @param   array  $locales Locale segments
	 * @param   string $path      Path
	 * @return  string
	 */
	protected function stripLocaleSegment(array $locales, $path)
	{
		foreach ($locales as $key => $locale) {
			if (strpos($path, '/' . $key) === 0) {
				$this->locale = $locale;
				$this->localePrefix = $key;
				$path = mb_substr($path, (mb_strlen($key) + 1));
				break;
			}
		}

		return $path;
	}

	/**
	 * @return    bool
	 */
	public function isAjax()
	{
		return $this->isAjax;
	}

	/**
	 * Is HTTPS?
	 * Determines if the application is accessed via an encrypted
	 * (HTTPS) connection.
	 *
	 * @return    bool
	 */
	public function isSecure()
	{
		return $this->isSecure;
	}

	/**
	 * @return string The client IP address
	 */
	public function getClientIp()
	{
		if ($this->clientIp !== null) {
			return $this->clientIp;
		}

		$ip_keys = [
			'HTTP_CLIENT_IP',
			'HTTP_X_FORWARDED_FOR',
			'HTTP_X_FORWARDED',
			'HTTP_X_CLUSTER_CLIENT_IP',
			'HTTP_FORWARDED_FOR',
			'HTTP_FORWARDED',
			'REMOTE_ADDR'
		];

		foreach ($ip_keys as $key) {
			if (isset($this->serverParams[$key])) {
				foreach (explode(',', $this->serverParams[$key]) as $ip) {
					// trim for safety measures
					$ip = trim($ip);

					// attempt to validate IP
					if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) {
						return $this->clientIp = $ip;
					}
				}
			}
		}

		return $this->clientIp = isset($this->serverParams['REMOTE_ADDR']) ? $this->serverParams['REMOTE_ADDR'] : '127.0.0.1';
	}

	protected function collectInfo()
	{
		// Is this an Ajax request?
		$this->isAjax = (isset($this->serverParams['HTTP_X_REQUESTED_WITH']) and ($this->serverParams['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'));

		// Was the request made using HTTPS?
		if (
			(
				! empty($this->serverParams['HTTPS'])
				and strtolower($this->serverParams['HTTPS']) !== 'off'
			) or (
				isset($this->serverParams['HTTP_X_FORWARDED_PROTO'])
				and $this->serverParams['HTTP_X_FORWARDED_PROTO'] === 'https'
			) or (
				! empty($this->serverParams['HTTP_FRONT_END_HTTPS'])
				and strtolower($this->serverParams['HTTP_FRONT_END_HTTPS']) !== 'off'
			)
		)
			$this->isSecure = true;
		else
			$this->isSecure = false;

		// set base path
		if (isset($this->serverParams['SCRIPT_NAME'])) {
			$this->basePath = dirname($this->serverParams['SCRIPT_NAME']);
		}
	}

	/**
	 * Collect headers from server params
	 *
	 * @return array
	 */
	protected function collectHeaders()
	{
		$headers = [];
		foreach ($this->serverParams as $key => $value) {
			if (strpos($key, 'HTTP_COOKIE') === 0) {
				// Cookies are handled using the $_COOKIE super global
				continue;
			}

			if ($value and strpos($key, 'HTTP_') === 0) {
				$name = strtr(substr($key, 5), '_', ' ');
				$name = strtr(ucwords(strtolower($name)), ' ', '-');
				$name = strtolower($name);
				$headers[$name] = $value;
				continue;
			}

			if ($value and strpos($key, 'CONTENT_') === 0) {
				$name = substr($key, 8); // Content-
				$name = 'Content-' . (($name == 'MD5') ? $name : ucfirst(strtolower($name)));
				$name = strtolower($name);
				$headers[$name] = $value;
				continue;
			}
		}

		return $headers;
	}

	/**
	 * Determines the request method.
	 *
	 * @param bool  $useOverrides
	 * @return  string
	 */
	protected function determineMethod($useOverrides = true)
	{
		$method = 'GET';

		if (isset($this->serverParams['REQUEST_METHOD'])) {
			$method = strtoupper($this->serverParams['REQUEST_METHOD']);
		}

		if ($useOverrides and $method === 'POST') {
			if (isset($_POST['REQUEST_METHOD_OVERRIDE'])) {
				$method = $_POST['REQUEST_METHOD_OVERRIDE'];
			} elseif (isset($this->serverParams['HTTP_X_HTTP_METHOD_OVERRIDE'])) {
				$method = $this->serverParams['HTTP_X_HTTP_METHOD_OVERRIDE'];
			}
		}

		return strtoupper($method);
	}

	/**
	 * Recursively validate the structure in an uploaded files array.
	 *
	 * @param array $uploadedFiles
	 * @throws InvalidArgumentException if any leaf is not an UploadedFileInterface instance.
	 */
	protected function validateUploadedFiles(array $uploadedFiles)
	{
		foreach ($uploadedFiles as $file) {
			if (is_array($file)) {
				$this->validateUploadedFiles($file);
				continue;
			}

			if (! $file instanceof UploadedFileInterface) {
				throw new InvalidArgumentException('Invalid leaf in uploaded files structure');
			}
		}
	}
}
