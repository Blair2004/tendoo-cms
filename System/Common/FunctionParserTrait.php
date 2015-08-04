<?php
namespace System\Common;

use RuntimeException;

trait FunctionParserTrait
{
	/**
	 * Parses custom "function calls".
	 * The return value is an array consisting of the function name and parameters.
	 *
	 * @param   string $function Function
	 * @return  array
	 */
	protected function parseFunction($function)
	{
		if (strpos($function, ':') === false) {
			return [$function, []];
		}

		list($function, $parameters) = explode(':', $function, 2);

		$parameters = (array) json_decode($parameters, true);

		if (json_last_error() !== JSON_ERROR_NONE) {
			throw new RuntimeException('Function parameters must be valid JSON.');
		}

		return [$function, $parameters];
	}
}
