<?php
namespace System\Mvc\View;

use System\Http\Message\Response;

class View extends Response
{
	/**
	 * @var string
	 */
	protected $template;

	/**
	 * @var array
	 */
	protected $variables;

	/**
	 * @param string $template
	 * @param array  $variables
	 */
	public function __construct($template, array $variables = [])
	{
		parent::__construct();

		$this->setTemplate($template);
		$this->variables = $variables;
	}

	/**
	 * Assign a local view variable.
	 *
	 * @param   string $name  Variable name
	 * @param   mixed  $value View variable
	 * @return  $this
	 */
	public function assign($name, $value)
	{
		$this->variables[$name] = $value;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getVariables()
	{
		return $this->variables;
	}

	/**
	 * @return string
	 */
	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * @param string $template
	 * @return $this
	 */
	public function setTemplate($template)
	{
		$this->template = $template;

		return $this;
	}
}
