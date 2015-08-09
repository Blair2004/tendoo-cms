<?php
namespace System\Http\Exceptions;

use Exception;

class MethodNotAllowedException extends RequestException
{
	/**
	 * Allowed methods.
	 *
	 * @var array
	 */
	 protected $allowedMethods;

	/**
	 * Constructor.
	 *
	 * @access  public
	 * @param   array      $allowedMethods  Allowed methods
	 * @param   \Exception $previous        Previous exception
	 */
	public function __construct(array $allowedMethods, Exception $previous = null)
	{
		$this->allowedMethods = $allowedMethods;

		parent::__construct(405, $previous);
	}

	/**
	 * Returns the allowed methods.
	 *
	 * @access  public
	 * @return  array
	 */
	public function getAllowedMethods()
	{
		return $this->allowedMethods;
	}
}