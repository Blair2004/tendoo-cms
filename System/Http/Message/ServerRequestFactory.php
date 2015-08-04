<?php
namespace System\Http\Message;

use InvalidArgumentException;
use Psr\Http\Message\UploadedFileInterface;

class ServerRequestFactory
{
	/**
	 * Create a request from the supplied super global values.
	 *
	 * If any argument is not supplied, the corresponding super global value will
	 * be used.
	 *
	 * The ServerRequest created is then passed to the fromServer() method in
	 * order to marshal the request URI and headers.
	 *
	 * @return ServerRequest
	 * @throws InvalidArgumentException for invalid file values
	 */
	public static function fromGlobals()
	{
		$server  = static::normalizeServer($_SERVER);
		$files   = static::normalizeFiles($_FILES);

		return new ServerRequest($server, $_COOKIE, $_GET, $files);
	}

	/**
	 * Marshal the $_SERVER array
	 *
	 * Pre-processes and returns the $_SERVER super global.
	 *
	 * @param array $server
	 * @return array
	 */
	public static function normalizeServer(array $server)
	{
		// This seems to be the only way to get the Authorization header on Apache
		$apacheRequestHeaders = 'apache_request_headers';
		if (isset($server['HTTP_AUTHORIZATION']) or ! is_callable($apacheRequestHeaders)) {
			return $server;
		}

		$apacheRequestHeaders = $apacheRequestHeaders();

		if (isset($apacheRequestHeaders['Authorization'])) {
			$server['HTTP_AUTHORIZATION'] = $apacheRequestHeaders['Authorization'];

			return $server;
		}

		if (isset($apacheRequestHeaders['authorization'])) {
			$server['HTTP_AUTHORIZATION'] = $apacheRequestHeaders['authorization'];

			return $server;
		}

		return $server;
	}

	/**
	 * Normalize uploaded files
	 *
	 * Transforms each value into an UploadedFileInterface instance, and ensures
	 * that nested arrays are normalized.
	 *
	 * @param array $files
	 * @return array
	 * @throws InvalidArgumentException for unrecognized values
	 */
	public static function normalizeFiles(array $files)
	{
		$normalized = [];
		foreach ($files as $key => $value) {
			if ($value instanceof UploadedFileInterface) {
				$normalized[$key] = $value;
				continue;
			}

			if (is_array($value) and isset($value['tmp_name'])) {
				$normalized[$key] = static::createUploadedFileFromSpec($value);
				continue;
			}

			if (is_array($value)) {
				$normalized[$key] = static::normalizeFiles($value);
				continue;
			}

			throw new InvalidArgumentException('Invalid value in files specification');
		}

		return $normalized;
	}

	/**
	 * Create and return an UploadedFile instance from a $_FILES specification.
	 *
	 * If the specification represents an array of values, this method will
	 * delegate to normalizeNestedFileSpec() and return that return value.
	 *
	 * @param array $value $_FILES struct
	 * @return array|UploadedFileInterface
	 */
	protected static function createUploadedFileFromSpec(array $value)
	{
		if (is_array($value['tmp_name'])) {
			return self::normalizeNestedFileSpec($value);
		}

		return new UploadedFile(
			$value['tmp_name'],
			$value['size'],
			$value['error'],
			$value['name'],
			$value['type']
		);
	}

	/**
	 * Normalize an array of file specifications.
	 *
	 * Loops through all nested files and returns a normalized array of
	 * UploadedFileInterface instances.
	 *
	 * @param array $files
	 * @return UploadedFileInterface[]
	 */
	protected static function normalizeNestedFileSpec(array $files = [])
	{
		$normalizedFiles = [];
		foreach (array_keys($files['tmp_name']) as $key) {
			$spec = [
				'tmp_name' => $files['tmp_name'][$key],
				'size'     => $files['size'][$key],
				'error'    => $files['error'][$key],
				'name'     => $files['name'][$key],
				'type'     => $files['type'][$key],
			];
			$normalizedFiles[$key] = static::createUploadedFileFromSpec($spec);
		}

		return $normalizedFiles;
	}
}
