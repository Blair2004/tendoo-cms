<?php
namespace System\Mvc\View\Renderers;

interface RendererInterface
{
	/**
	 * Returns the rendered view.
	 *
	 * @param   string  $view       View path
	 * @param   array   $variables  View variables
	 * @return  string
	 */
	public function render($view, array $variables = []);
}
