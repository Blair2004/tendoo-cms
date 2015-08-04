<?php
namespace System\Mvc\View\Renderers;

class Php implements RendererInterface
{
	/**
	 * {@inheritdoc}
	 */
	public function render($view, array $variables = [])
	{
		extract($variables, EXTR_REFS | EXTR_SKIP);

		ob_start();

		include $view;

		return ob_get_clean();
	}
}
