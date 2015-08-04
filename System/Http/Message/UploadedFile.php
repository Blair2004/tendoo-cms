<?php
namespace System\Http\Message;

use InvalidArgumentException;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UploadedFileInterface;
use RuntimeException;

class UploadedFile implements UploadedFileInterface
{
	/**
	 * @var string
	 */
	protected $clientFilename;

	/**
	 * @var string
	 */
	protected $clientMediaType;

	/**
	 * @var int
	 */
	protected $error;

	/**
	 * @var null|string
	 */
	protected $file;

	/**
	 * @var bool
	 */
	protected $moved = false;

	/**
	 * @var int
	 */
	protected $size;

	/**
	 * @var null|StreamInterface
	 */
	protected $stream;

	public function __construct($streamOrFile, $size, $error, $clientFilename = null, $clientMediaType = null)
	{
		if ($error === UPLOAD_ERR_OK) {
			if (is_string($streamOrFile)) {
				$this->file = $streamOrFile;
			}

			if (is_resource($streamOrFile)) {
				$this->stream = new Stream($streamOrFile);
			}

			if (! $this->file and ! $this->stream) {
				if (! $streamOrFile instanceof StreamInterface) {
					throw new InvalidArgumentException(
						'Invalid stream or file provided for UploadedFile'
					);
				}
				$this->stream = $streamOrFile;
			}
		}

		if (! is_int($size)) {
			throw new InvalidArgumentException(
				'Invalid size provided for UploadedFile; must be an int'
			);
		}
		$this->size = $size;

		if (
			! is_int($error)
			or 0 > $error
			or 8 < $error
		) {
			throw new InvalidArgumentException(
				'Invalid error status for UploadedFile; must be an UPLOAD_ERR_* constant'
			);
		}
		$this->error = $error;

		if (null !== $clientFilename and ! is_string($clientFilename)) {
			throw new InvalidArgumentException(
				'Invalid client filename provided for UploadedFile; must be null or a string'
			);
		}
		$this->clientFilename = $clientFilename;

		if (null !== $clientMediaType and ! is_string($clientMediaType)) {
			throw new InvalidArgumentException(
				'Invalid client media type provided for UploadedFile; must be null or a string'
			);
		}
		$this->clientMediaType = $clientMediaType;
	}

	/**
	 * {@inheritdoc}
	 * @throws \RuntimeException if the upload was not successful.
	 */
	public function getStream()
	{
		if ($this->error !== UPLOAD_ERR_OK) {
			throw new RuntimeException('Cannot retrieve stream due to upload error');
		}
		if ($this->moved) {
			throw new RuntimeException('Cannot retrieve stream after it has already been moved');
		}
		if ($this->stream instanceof StreamInterface) {
			return $this->stream;
		}

		$this->stream = new Stream($this->file);

		return $this->stream;
	}

	/**
	 * {@inheritdoc}
	 * @see http://php.net/is_uploaded_file
	 * @see http://php.net/move_uploaded_file
	 * @param string $targetPath Path to which to move the uploaded file.
	 * @throws \RuntimeException if the upload was not successful.
	 * @throws \InvalidArgumentException if the $path specified is invalid.
	 * @throws \RuntimeException on any error during the move operation, or on
	 *                           the second or subsequent call to the method.
	 */
	public function moveTo($targetPath)
	{
		if ($this->error !== UPLOAD_ERR_OK) {
			throw new RuntimeException('Cannot retrieve stream due to upload error');
		}
		
		if (! is_string($targetPath)) {
			throw new InvalidArgumentException(
				'Invalid path provided for move operation; must be a string'
			);
		}
		
		if (empty($targetPath)) {
			throw new InvalidArgumentException(
				'Invalid path provided for move operation; must be a non-empty string'
			);
		}
		
		if ($this->moved) {
			throw new RuntimeException('Cannot move file; already moved!');
		}
		
		$sapi = PHP_SAPI;
		switch (true) {
			case (empty($sapi) or 0 === strpos($sapi, 'cli') or ! $this->file):
				// Non-SAPI environment, or no filename present
				$this->writeFile($targetPath);
				break;
			default:
				// SAPI environment, with file present
				if (false === move_uploaded_file($this->file, $targetPath)) {
					throw new RuntimeException('Error occurred while moving uploaded file');
				}
				break;
		}
		
		$this->moved = true;
	}

	/**
	 * {@inheritdoc}
	 * @return int|null The file size in bytes or null if unknown.
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * {@inheritdoc}
	 * @see http://php.net/manual/en/features.file-upload.errors.php
	 * @return int One of PHP's UPLOAD_ERR_XXX constants.
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * {@inheritdoc}
	 * @return string|null The filename sent by the client or null if none
	 *     was provided.
	 */
	public function getClientFilename()
	{
		return $this->clientFilename;
	}

	/**
	 * {@inheritdoc}
	 */
	public function getClientMediaType()
	{
		return $this->clientMediaType;
	}

	/**
	 * Returns the maximum size of an uploaded file as configured in php.ini.
	 *
	 * @return int The maximum size of an uploaded file in bytes
	 */
	public static function getMaxFilesize()
	{
		$iniMax = strtolower(ini_get('upload_max_filesize'));

		if ('' === $iniMax) {
			return PHP_INT_MAX;
		}

		$max = ltrim($iniMax, '+');
		if (0 === strpos($max, '0x')) {
			$max = intval($max, 16);
		} elseif (0 === strpos($max, '0')) {
			$max = intval($max, 8);
		} else {
			$max = (int) $max;
		}

		switch (substr($iniMax, -1)) {
			case 't': $max *= 1024;
			case 'g': $max *= 1024;
			case 'm': $max *= 1024;
			case 'k': $max *= 1024;
		}

		return $max;
	}

	/**
	 * Returns an informative upload error message.
	 *
	 * @return string The error message regarding the specified error code
	 */
	public function getErrorMessage()
	{
		static $errors = [
			UPLOAD_ERR_INI_SIZE => 'The file "%s" exceeds your upload_max_filesize ini directive (limit is %d KiB).',
			UPLOAD_ERR_FORM_SIZE => 'The file "%s" exceeds the upload limit defined in your form.',
			UPLOAD_ERR_PARTIAL => 'The file "%s" was only partially uploaded.',
			UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
			UPLOAD_ERR_CANT_WRITE => 'The file "%s" could not be written on disk.',
			UPLOAD_ERR_NO_TMP_DIR => 'File could not be uploaded: missing temporary directory.',
			UPLOAD_ERR_EXTENSION => 'File upload was stopped by a PHP extension.',
		];

		$errorCode = $this->error;
		$maxFilesize = $errorCode === UPLOAD_ERR_INI_SIZE ? static::getMaxFilesize() / 1024 : 0;
		$message = isset($errors[$errorCode]) ? $errors[$errorCode] : 'The file "%s" was not uploaded due to an unknown error.';

		return sprintf($message, $this->getClientFilename(), $maxFilesize);
	}

	/**
	 * Write internal stream to given path
	 *
	 * @param string $path
	 */
	protected function writeFile($path)
	{
		$handle = fopen($path, 'wb+');
		if (false === $handle) {
			throw new RuntimeException('Unable to write to designated path');
		}
		$this->stream->rewind();
		while (! $this->stream->eof()) {
			fwrite($handle, $this->stream->read(4096));
		}
		fclose($handle);
	}
}
