<?php
namespace System\I18n\Loaders;

use RuntimeException;
use InvalidArgumentException;
use System\I18n\PluralRule;
use System\I18n\TextDomain;

class Gettext implements FileLoaderInterface
{
	/**
	 * file path
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * Current file pointer.
	 *
	 * @var resource
	 */
	protected $file;

	/**
	 * Whether the current file is little endian.
	 *
	 * @var bool
	 */
	protected $littleEndian;

	/**
	 * {@inheritdoc}
	 */
	public function __construct($filename)
	{
		if (! is_file($filename) or ! is_readable($filename)) {
			throw new InvalidArgumentException(sprintf(
				'%s(): Could not find or open file [ %s ] for reading',
				__METHOD__, $filename
			));
		}

		if (($ext = pathinfo($filename, PATHINFO_EXTENSION)) != 'mo') {
			throw new InvalidArgumentException(sprintf(
				'%s(): only mo files can load with this loader [ %s ] given',
				__METHOD__, $ext
			));
		}

		$this->filename = $filename;
	}

	/**
	 * {@inheritdoc}
	 */
	public function load()
	{
		$textDomain = new TextDomain();

		$this->file = fopen($this->filename, 'rb');

		if (false === $this->file) {
			$error = error_get_last();
			throw new RuntimeException(sprintf(
				'Could not open file "%s" for reading (%s).',
				$this->filename, strip_tags($error['message'])
			));
		}

		// Verify magic number
		$magic = fread($this->file, 4);

		if ($magic == "\x95\x04\x12\xde") {
			$this->littleEndian = false;
		} elseif ($magic == "\xde\x12\x04\x95") {
			$this->littleEndian = true;
		} else {
			fclose($this->file);
			throw new InvalidArgumentException(sprintf(
				'"%s" is not a valid gettext file.',
				$this->filename
			));
		}

		// Verify major revision (only 0 and 1 supported)
		$majorRevision = ($this->readInteger() >> 16);

		if ($majorRevision !== 0 and $majorRevision !== 1) {
			fclose($this->file);
			throw new InvalidArgumentException(sprintf(
				'"%s" has an unknown major revision',
				$this->filename
			));
		}

		// Gather main information
		$numStrings = $this->readInteger();
		$originalStringTableOffset = $this->readInteger();
		$translationStringTableOffset = $this->readInteger();

		// Usually there follow size and offset of the hash table, but we have
		// no need for it, so we skip them.
		fseek($this->file, $originalStringTableOffset);
		$originalStringTable = $this->readIntegerList(2 * $numStrings);

		fseek($this->file, $translationStringTableOffset);
		$translationStringTable = $this->readIntegerList(2 * $numStrings);

		// Read in all translations
		for ($current = 0; $current < $numStrings; $current++) {
			$sizeKey = $current * 2 + 1;
			$offsetKey = $current * 2 + 2;
			$originalStringSize = $originalStringTable[$sizeKey];
			$originalStringOffset = $originalStringTable[$offsetKey];
			$translationStringSize = $translationStringTable[$sizeKey];
			$translationStringOffset = $translationStringTable[$offsetKey];

			$originalString = [''];
			if ($originalStringSize > 0) {
				fseek($this->file, $originalStringOffset);
				$originalString = explode("\0", fread($this->file, $originalStringSize));
			}

			if ($translationStringSize > 0) {
				fseek($this->file, $translationStringOffset);
				$translationString = explode("\0", fread($this->file, $translationStringSize));

				if (count($originalString) > 1 and count($translationString) > 1) {
					$textDomain[$originalString[0]] = $translationString;

					array_shift($originalString);

					foreach ($originalString as $string) {
						if (! isset($textDomain[$string])) {
							$textDomain[$string] = '';
						}
					}
				} else {
					$textDomain[$originalString[0]] = $translationString[0];
				}
			}
		}

		// Read header entries
		if (array_key_exists('', $textDomain)) {
			$rawHeaders = explode("\n", trim($textDomain['']));

			foreach ($rawHeaders as $rawHeader) {
				list($header, $content) = explode(':', $rawHeader, 2);

				if (trim(strtolower($header)) === 'plural-forms') {
					$textDomain->setPluralRule(new PluralRule($content));
				};
			}

			unset($textDomain['']);
		}

		fclose($this->file);

		return $textDomain;
	}

	/**
	 * Read a single integer from the current file.
	 *
	 * @return int
	 */
	protected function readInteger()
	{
		if ($this->littleEndian) {
			$result = unpack('Vint', fread($this->file, 4));
		} else {
			$result = unpack('Nint', fread($this->file, 4));
		}

		return $result['int'];
	}

	/**
	 * Read an integer from the current file.
	 *
	 * @param  int $num
	 * @return int
	 */
	protected function readIntegerList($num)
	{
		if ($this->littleEndian) {
			return unpack('V' . $num, fread($this->file, 4 * $num));
		}

		return unpack('N' . $num, fread($this->file, 4 * $num));
	}
}
