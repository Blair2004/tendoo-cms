<?php
namespace System\I18n;

use Closure;
use RuntimeException;

class PluralRule
{
	/**
	 * @var string
	 */
	protected $pluralForms;

	/**
	 * Number of plurals in this rule.
	 *
	 * @var int
	 */
	protected $numPlurals;

	/**
	 * function for check plural rule
	 *
	 * @var Closure
	 */
	protected $checker;

	/**
	 * @param string $pluralForms
	 */
	public function __construct($pluralForms)
	{
		list($count, $code) = explode(';', $pluralForms, 2);

		$this->pluralForms = $pluralForms;
		$this->numPlurals = (int) str_replace('nplurals=', '', $count);
		$this->checker = $this->createClosure($code);
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->pluralForms;
	}

	/**
	 * Get number of plurals in this rule.
	 *
	 * @return int
	 */
	public function getNumPlurals()
	{
		return $this->numPlurals;
	}

	/**
	 * Get plural forms
	 *
	 * @return string
	 */
	public function getPluralForms()
	{
		return $this->pluralForms;
	}

	/**
	 * check plural rule
	 *
	 * @param $n
	 * @return bool
	 */
	public function check($n)
	{
		return call_user_func($this->checker, $n);
	}

	/**
	 * Returns a unique function name as a string, or FALSE on error.
	 *
	 * @param $code
	 * @return Closure
	 * @throws RuntimeException
	 */
	protected function createClosure($code)
	{
		$function = create_function('$n', str_replace('plural=', 'return ', str_replace('n', '$n', static::fixTerseIfs($code))));

		if (! $function) {
			$error = error_get_last();
			throw new RuntimeException(sprintf(
				'Unable to create function (%s).',
				strip_tags($error['message'])
			));
		}

		return $function;
	}

	/**
	 * This function will recursively wrap failure states in brackets if they contain a nested terse if
	 *
	 * This because PHP can not handle nested terse if's unless they are wrapped in brackets.
	 *
	 * This code probably only works for the gettext plural decision codes.
	 *
	 * return ($n==1 ? 0 : $n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2);
	 * becomes
	 * return ($n==1 ? 0 : ($n%10>=2 && $n%10<=4 && ($n%100<10 || $n%100>=20) ? 1 : 2));
	 *
	 * @param  string $code  the terse if string
	 * @param  bool   $inner If inner is true we wrap it in brackets
	 * @return string A formatted terse If that PHP can work with.
	 */
	public static function fixTerseIfs($code, $inner = false)
	{
		/**
		 * (?P<expression>[^?]+)   Capture everything up to ? as 'expression'
		 * \?                      ?
		 * (?P<success>[^:]+)      Capture everything up to : as 'success'
		 * :                       :
		 * (?P<failure>[^;]+)      Capture everything up to ; as 'failure'
		 */
		if (! preg_match('/(?P<expression>[^?]+)\?(?P<success>[^:]+):(?P<failure>[^;]+)/', $code, $matches)) {
			// If no match was found then no terse if was present
			return $code;
		}

		$expression = $matches['expression'];
		$success    = $matches['success'];
		$failure    = $matches['failure'];

		// Go look for another terse if in the failure state or success state
		$failure = self::fixTerseIfs($failure, true);
		$success = self::fixTerseIfs($success, true);

		$code = $expression.' ? '.$success.' : '.$failure;

		if ($inner) {
			return "($code)";
		}

		// note the semicolon. We need that for executing the code.
		return "$code;";
	}
}
