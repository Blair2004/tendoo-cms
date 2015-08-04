<?php
namespace System\Http\Message;

use InvalidArgumentException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

class Message implements MessageInterface
{
	/**
	 * List of all registered headers, as key => array of values.
	 *
	 * @var array
	 */
	protected $headers = [];

	/**
	 * Map of normalized header name to original name used to register header.
	 *
	 * @var array
	 */
	protected $headerNames = [];

	/**
	 * @var string
	 */
	protected $protocol = '1.1';

	/**
	 * @var StreamInterface
	 */
	protected $body;

	/**
	 * {@inheritdoc}
	 */
	public function getProtocolVersion()
	{
		return $this->protocol;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withProtocolVersion($version)
	{
		$new = clone $this;
		$new->protocol = $version;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHeaders()
	{
		return $this->headers;
	}

	/**
	 * {@inheritdoc}
	 */
	public function hasHeader($name)
	{
		return array_key_exists(strtolower($name), $this->headerNames);
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHeader($name)
	{
		if (! $this->hasHeader($name)) {
			return [];
		}

		$name = $this->headerNames[strtolower($name)];
		$value  = (array) $this->headers[$name];

		return $value;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getHeaderLine($name)
	{
		$value = $this->getHeader($name);
		if (empty($value)) {
			return '';
		}

		return implode(',', $value);
	}

	/**
	 * {@inheritdoc}
	 */
	public function withHeader($name, $value)
	{
		$value = (array) $value;

		if (! $this->filterHeaderParams($value)) {
			throw new InvalidArgumentException(
				'Invalid header value; must be a string or array of strings without line break'
			);
		}

		if (! $this->filterHeaderParam(true, $name)) {
			throw new InvalidArgumentException(
				'Invalid header name; must be a string without line break'
			);
		}

		$normalized = strtolower($name);

		$new = clone $this;
		$new->headerNames[$normalized]  = $name;
		$new->headers[$name]            = $value;

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withAddedHeader($name, $value)
	{
		$value = (array) $value;

		if (! $this->filterHeaderParams($value)) {
			throw new InvalidArgumentException(
				'Invalid header value; must be a string or array of strings without line break'
			);
		}

		if (! $this->filterHeaderParam(true, $name)) {
			throw new InvalidArgumentException(
				'Invalid header name; must be a string without line break'
			);
		}

		if (! $this->hasHeader($name)) {
			return $this->withHeader($name, $value);
		}

		$normalized = strtolower($name);
		$name = $this->headerNames[$normalized];

		$new = clone $this;
		$new->headers[$name] = array_merge($this->headers[$name], $value);

		return $new;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withoutHeader($header)
	{
		if (! $this->hasHeader($header)) {
			return $this;
		}

		$normalized = strtolower($header);
		$original = $this->headerNames[$normalized];

		$new = clone $this;
		unset($new->headers[$original], $new->headerNames[$normalized]);

		return $new;
	}

	/**
	 * Filter a set of headers to ensure they are in the correct internal format.
	 *
	 * Used by message constructors to allow setting all initial headers at once.
	 *
	 * @param array $originalHeaders Headers to filter.
	 * @return array Filtered headers and names.
	 */
	protected function filterHeaders(array $originalHeaders)
	{
		$headerNames = $headers = [];

		foreach ($originalHeaders as $header => $value) {
			if (! is_string($header)) {
				continue;
			}
			if (! is_array($value) and ! is_string($value)) {
				continue;
			}
			if (! is_array($value)) {
				$value = [ $value ];
			}

			$headerNames[strtolower($header)] = $header;
			$headers[$header] = $value;
		}

		return [$headerNames, $headers];
	}

	/**
	 * Test that an array contains only strings without line break
	 *
	 * @param array $array
	 * @return bool
	 */
	protected function filterHeaderParams(array $array)
	{
		return array_reduce($array, [$this, 'filterHeaderParam'], true);
	}

	/**
	 * Test if a value is a string and doesn't have any line break
	 *
	 * @param bool $carry
	 * @param mixed $item
	 * @return bool
	 */
	protected static function filterHeaderParam($carry, $item)
	{
		if (! is_string($item) or preg_match("#[\n\r]#", $item)) {
			return false;
		}

		return $carry;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * {@inheritdoc}
	 */
	public function withBody(StreamInterface $body)
	{
		$new = clone $this;
		$new->body = $body;

		return $new;
	}
}
