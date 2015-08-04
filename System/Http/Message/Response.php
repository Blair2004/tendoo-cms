<?php
namespace System\Http\Message;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class Response extends Message implements ResponseInterface
{
	const COOKIES_FLAT = 'flat';
	const COOKIES_ARRAY = 'array';

	/**
	 * Compress output?
	 *
	 * @var boolean
	 */
	protected $gzip = true;

	/**
	 * @var array
	 */
	protected $cookies = [];

	/**
	 * @var int
	 */
	protected $statusCode = 200;

	/**
	 * @var string
	 */
	private $reasonPhrase = '';

	/**
	 * Map of standard HTTP status code/reason phrases
	 *
	 * @var array
	 */
	protected $phrases = [
		// 1xx Informational
		100 => 'Continue',
		101 => 'Switching Protocols',
		102 => 'Processing',

		// 2xx Success
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		208 => 'Already Reported',
		226 => 'IM Used',

		// 3xx Redirection
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		306 => 'Switch Proxy',
		307 => 'Temporary Redirect',
		308 => 'Permanent Redirect',

		// 4xx Client Error
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		418 => 'I\'m a teapot',
		421 => 'There are too many connections from your internet address',
		422 => 'Un processable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		425 => 'Unordered Collection',
		426 => 'Upgrade Required',
		429 => 'Too Many Requests',
		431 => 'Request Header Fields Too Large',
		449 => 'Retry With',
		450 => 'Blocked by Windows Parental Controls',
		498 => 'Invalid or expired token',

		// 5xx Server Error
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		506 => 'Variant Also Negotiates',
		507 => 'Insufficient Storage',
		509 => 'Bandwidth Limit Exceeded',
		510 => 'Not Extended',
		511 => 'Network Authentication Required',
		530 => 'User access denied',
	];

	/**
	 * @param string|resource|StreamInterface $body Stream identifier and/or actual stream resource
	 * @param int $status Status code for the response, if any.
	 * @param array $headers Headers for the response, if any.
	 * @throws InvalidArgumentException on any invalid element.
	 */
	public function __construct($body = 'php://memory', $status = 200, array $headers = [])
	{
		if (! is_string($body) and ! is_resource($body) and ! $body instanceof StreamInterface) {
			throw new InvalidArgumentException(
				'Stream must be a string stream resource identifier, '
				. 'an actual stream resource, '
				. 'or a Psr\Http\Message\StreamInterface implementation'
			);
		}

		if (null !== $status) {
			$this->validateStatus($status);
		}

		$this->body = ($body instanceof StreamInterface) ? $body : new Stream($body, 'w');
		$this->statusCode = $status ? (int) $status : 200;
		list($this->headerNames, $this->headers) = $this->filterHeaders($headers);
	}

	/**
	 * Sets a cookie.
	 *
	 * @param Cookie $cookie
	 * @return $this
	 */
	public function withCookie(Cookie $cookie)
	{
		$new = clone $this;
		$new->cookies[$cookie->getDomain()][$cookie->getPath()][$cookie->getName()] = $cookie;

		return $new;
	}

	/**
	 * Removes a cookie from the array, but does not unset it in the browser.
	 *
	 * @param string $name
	 * @param string $path
	 * @param string $domain
	 * @return $this
	 */
	public function removeCookie($name, $path = '/', $domain = null)
	{
		if (null === $path) {
			$path = '/';
		}

		$new = clone $this;

		unset($new->cookies[$domain][$path][$name]);

		if (empty($new->cookies[$domain][$path])) {
			unset($new->cookies[$domain][$path]);

			if (empty($new->cookies[$domain])) {
				unset($new->cookies[$domain]);
			}
		}

		return $new;
	}

	/**
	 * Clears a cookie in the browser.
	 *
	 * @param string $name
	 * @param string $path
	 * @param string $domain
	 * @param bool   $secure
	 * @param bool   $httpOnly
	 * @return $this
	 */
	public function clearCookie($name, $path = '/', $domain = null, $secure = false, $httpOnly = true)
	{
		return $this->withCookie(new Cookie($name, null, 1, $path, $domain, $secure, $httpOnly));
	}

	/**
	 * Returns an array with all cookies.
	 *
	 * @param string $format
	 * @throws InvalidArgumentException When the $format is invalid
	 * @return array
	 */
	public function getCookies($format = self::COOKIES_FLAT)
	{
		if (! in_array($format, array(self::COOKIES_FLAT, self::COOKIES_ARRAY))) {
			throw new InvalidArgumentException(sprintf(
				'Format "%s" invalid (%s).',
				$format, implode(', ', array(self::COOKIES_FLAT, self::COOKIES_ARRAY))
			));
		}

		if (self::COOKIES_ARRAY === $format) {
			return $this->cookies;
		}

		$flattenedCookies = array();
		foreach ($this->cookies as $path) {
			foreach ($path as $cookies) {
				foreach ($cookies as $cookie) {
					$flattenedCookies[] = $cookie;
				}
			}
		}

		return $flattenedCookies;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withStatus($code, $reasonPhrase = '')
	{
		$this->validateStatus($code);

		$new = clone $this;
		$new->statusCode   = (int) $code;
		$new->reasonPhrase = $reasonPhrase;

		return $new;
	}

	/**
	 * Validate a status code.
	 *
	 * @param int|string $code
	 * @throws InvalidArgumentException on an invalid status code.
	 */
	protected function validateStatus($code)
	{
		if (! is_numeric($code)
			or is_float($code)
			or $code < 100
			or $code >= 600
		) {
			throw new InvalidArgumentException(sprintf(
				'Invalid status code "%s"; must be an integer between 100 and 599, inclusive',
				(is_scalar($code) ? $code : gettype($code))
			));
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getReasonPhrase()
	{
		if (! $this->reasonPhrase and isset($this->phrases[$this->statusCode])) {
			$this->reasonPhrase = $this->phrases[$this->statusCode];
		}

		return $this->reasonPhrase;
	}

	/**
	 * Sends HTTP headers.
	 *
	 * @return Response
	 */
	public function sendHeaders()
	{
		// headers have already been sent by the developer
		if (headers_sent()) {
			return $this;
		}

		// status
		header(sprintf('HTTP/%s %s %s', $this->protocol, $this->statusCode, $this->reasonPhrase), true, $this->statusCode);

		// headers
		foreach ($this->headers as $name => $values) {
			foreach ($values as $value) {
				header($name . ': ' . $value, false, $this->statusCode);
			}
		}

		// cookies
		foreach ($this->cookies as $cookie) {
			/** @var Cookie $cookie */
			setcookie($cookie->getName(), $cookie->getValue(), $cookie->getExpiresTime(), $cookie->getPath(), $cookie->getDomain(), $cookie->isSecure(), $cookie->isHttpOnly());
		}

		return $this;
	}

	/**
	 * Sends content for the current web response.
	 *
	 * @return Response
	 */
	public function sendContent()
	{
		if ($this->gzip) {
			ob_start('ob_gzhandler');
		}

		echo $this->getBody();

		return $this;
	}

	/**
	 * Sends HTTP headers and content.
	 *
	 * @return Response
	 */
	public function send()
	{
		$this->sendHeaders();
		$this->sendContent();

		if (function_exists('fastcgi_finish_request')) {
			fastcgi_finish_request();
		} elseif ('cli' !== PHP_SAPI) {
			static::closeOutputBuffers(0, true);
		}

		return $this;
	}

	/**
	 * Cleans or flushes output buffers up to target level.
	 *
	 * Resulting level can be greater than target level if a non-removable buffer has been encountered.
	 *
	 * @param int  $targetLevel The target output buffering level
	 * @param bool $flush       Whether to flush or clean the buffers
	 */
	public static function closeOutputBuffers($targetLevel, $flush)
	{
		$status = ob_get_status(true);
		$level = count($status);

		while ($level-- > $targetLevel
			and (!empty($status[$level]['del'])
				or (isset($status[$level]['flags'])
					and ($status[$level]['flags'] & PHP_OUTPUT_HANDLER_REMOVABLE)
					and ($status[$level]['flags'] & ($flush ? PHP_OUTPUT_HANDLER_FLUSHABLE : PHP_OUTPUT_HANDLER_CLEANABLE))
				)
			)
		) {
			if ($flush) {
				ob_end_flush();
			} else {
				ob_end_clean();
			}
		}
	}
}
