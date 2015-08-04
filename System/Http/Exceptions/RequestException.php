<?php namespace System\Http\Exceptions;

use Exception;
use RuntimeException;

class RequestException extends RuntimeException
{
	/**
	 * Constructor.
	 *
	 * @access  public
	 * @param   int     $code         Exception code
	 * @param   Exception $previous  Previous exception
	 */
	public function __construct($code, Exception $previous = null)
	{
		parent::__construct(null, $code, $previous);
	}
}
