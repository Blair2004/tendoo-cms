<?php
namespace System\Http\Message;

use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\StreamInterface;

class Request extends Message implements RequestInterface
{
	/**
	 * @var string
	 */
	protected $method = '';

	/**
	 * The request-target, if it has been provided or calculated.
	 *
	 * @var null|string
	 */
	protected $requestTarget;

	/**
	 * @var null|UriInterface
	 */
	protected $uri;

	/**
	 * @param string|resource|StreamInterface $body Message body, if any.
	 * @param null|string|UriInterface $uri URI for the request, if any.
	 * @param null|string $method HTTP method for the request, if any.
	 * @param array $headers Headers for the message, if any.
	 * @throws InvalidArgumentException for any invalid value.
	 */
	public function __construct($body = 'php://input', $uri = null, $method = null, array $headers = [])
	{
		if (! $uri instanceof UriInterface and ! is_string($uri) and null !== $uri) {
			throw new InvalidArgumentException(
				'Invalid URI provided; must be null, '
				. 'a string, or a Psr\Http\Message\UriInterface instance'
			);
		}

		$this->validateMethod($method);

		if (! is_string($body) and ! is_resource($body) and ! $body instanceof StreamInterface) {
			throw new InvalidArgumentException(
				'Body must be a string stream resource identifier, '
				. 'an actual stream resource, '
				. 'or a Psr\Http\Message\StreamInterface implementation'
			);
		}

		$this->uri = is_string($uri) ? new Uri($uri) : ($uri ?: new Uri());
		$this->method = $method ?: '';
		$this->stream = ($body instanceof StreamInterface) ? $body : new Stream($body, 'r');
		list($this->headerNames, $this->headers) = $this->filterHeaders($headers);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getRequestTarget()
	{
		if (null !== $this->requestTarget) {
			return $this->requestTarget;
		}

		if (! $this->uri) {
			return '/';
		}

		$target = $this->uri->getPath();
		if ($query = $this->uri->getQuery()) {
			$target .= '?' . $query;
		}

		if (empty($target)) {
			$target = '/';
		}

		return $this->requestTarget = $target;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withRequestTarget($requestTarget)
	{
		if (preg_match('#\s#', $requestTarget)) {
			throw new InvalidArgumentException(
				'Invalid request target provided; cannot contain whitespace'
			);
		}

		$new = clone $this;
		$new->requestTarget = $requestTarget;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * check given method with correct method
	 *
	 * @param $method
	 * @return bool
	 */
	public function isMethod($method)
	{
		return strtoupper($method) === $this->getMethod();
	}

	/**
	 * {@inheritdoc}
	 */
	public function withMethod($method)
	{
		$this->validateMethod($method);

		$new = clone $this;
		$new->method = strtoupper($method);

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withUri(UriInterface $uri, $preserveHost = false)
	{
		$new = clone $this;
		$new->uri = $uri;

		if ($preserveHost and $this->hasHeader('Host')) {
			return $new;
		}

		if (! $uri->getHost()) {
			return $new;
		}

		$host = $uri->getHost();
		if ($uri->getPort()) {
			$host .= ':' . $uri->getPort();
		}

		$new->headerNames['host'] = 'Host';
		$new->headers['Host'] = [$host];

		return $new;
	}

	/**
	 * Validate the HTTP method
	 *
	 * @param null|string $method
	 * @throws InvalidArgumentException on invalid HTTP method.
	 */
	protected function validateMethod($method)
	{
		if (null === $method) {
			return;
		}

		if (! is_string($method)) {
			throw new InvalidArgumentException(sprintf(
				'Unsupported HTTP method; must be a string, received %s',
				(is_object($method) ? get_class($method) : gettype($method))
			));
		}

		if (! preg_match('/^[!#$%&\'*+.^_`\|~0-9a-z-]+$/i', $method)) {
			throw new InvalidArgumentException(sprintf(
				'Unsupported HTTP method "%s" provided',
				$method
			));
		}
	}
}
