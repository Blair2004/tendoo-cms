<?php
namespace System\Http\Exceptions;

use Exception;

class NotFoundException extends RequestException
{
	/**
	 * Constructor.
	 *
	 * @access  public
	 * @param   Exception $previous  Previous exception
	 */
	public function __construct(Exception $previous = null)
	{
		parent::__construct(404, $previous);
	}
}
