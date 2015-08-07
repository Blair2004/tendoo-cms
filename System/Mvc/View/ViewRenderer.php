<?php
namespace System\Mvc\View;

use Closure;
use RuntimeException;
use System\Common\NamespacedFileLoaderTrait;
use System\Mvc\View\Renderers\RendererInterface;

class ViewRenderer
{
	use NamespacedFileLoaderTrait;

	/**
	 * @var string
	 */
	protected $charset;

	/**
	 * @var array
	 */
	protected $renderers = ['.phtml' => 'System\Mvc\View\Renderers\Php'];

	/**
	 * @var string
	 */
	protected $cachePath;

	/**
	 * @var array
	 */
	protected $globalVariables = [];

	/**
	 * @var array
	 */
	protected $viewCache = [];

	/**
	 * @var array
	 */
	protected $rendererInstances;

	/**
	 * @param string       $cachePath
	 * @param string       $charset
	 */
	public function __construct($cachePath, $charset = 'UTF-8')
	{
		$this->setCachePath($cachePath);
		$this->setCharset($charset);
	}

	/**
	 * @param   string
	 * @return  $this
	 */
	public function setCachePath($cachePath)
	{
		$this->cachePath = $cachePath;

		return $this;
	}

	/**
	 * @return  string
	 */
	public function getCachePatch()
	{
		return $this->cachePath;
	}

	/**
	 * @param   string $charset Charset
	 * @return  $this
	 */
	public function setCharset($charset)
	{
		$this->assign('__CHARSET__', $charset)->charset = $charset;

		return $this;
	}

	/**
	 * @return  string
	 */
	public function getCharset()
	{
		return $this->charset;
	}

	/**
	 * Registers a custom view renderer.
	 *
	 * @param   string         $extension Extension handled by the renderer
	 * @param   string|Closure $renderer  Renderer class or closure that creates a renderer instance
	 * @return  $this
	 */
	public function registerRenderer($extension, $renderer)
	{
		$this->renderers[$extension] = $renderer;

		return $this;
	}

	/**
	 * Assign a global view variable that will be available in all views.
	 *
	 * @param   string $name  Variable name
	 * @param   mixed  $value View variable
	 * @return  $this
	 */
	public function assign($name, $value)
	{
		$this->globalVariables[$name] = $value;

		return $this;
	}

	/**
	 * Returns an array containing the view path and the renderer we should use.
	 *
	 * @param   string  $view           View
	 * @param   boolean $throwException Throw exception if view doesn't exist?
	 * @return  array
	 */
	protected function getViewPathAndExtension($view, $throwException = true)
	{
		if (! isset($this->viewCache[$view])) {
			foreach ($this->renderers as $extension => $renderer) {
				$path = $this->getFilePath($view, $extension);
				if (file_exists($path)) {
					return $this->viewCache[$view] = [$path, $extension];
				}
			}

			// We didn't find the view so we'll throw an exception or return false
			if ($throwException) {
				throw new RuntimeException(sprintf(
					"%s(): The [ %s ] view does not exist.",
					__METHOD__, $view
				));
			}

			return false;
		}

		return $this->viewCache[$view];
	}

	/**
	 * Returns a renderer instance.
	 *
	 * @param   string $extension Extension associated with the renderer
	 * @return  RendererInterface
	 */
	protected function resolveRenderer($extension)
	{
		if (! isset($this->rendererInstances[$extension])) {
			$this->rendererInstances[$extension] = $this->rendererFactory($this->renderers[$extension]);
		}

		return $this->rendererInstances[$extension];
	}

	/**
	 * Creates a renderer instance.
	 *
	 * @param   string|Closure $renderer Renderer class or closure
	 * @return  RendererInterface
	 */
	protected function rendererFactory($renderer)
	{
		return $renderer instanceof Closure ? $renderer() : new $renderer;
	}

	/**
	 * returns a rendered view.
	 *
	 * @param   View  $view      View
	 * @return  string
	 */
	public function render(View $view)
	{
		list($path, $extension) = $this->getViewPathAndExtension($view->getTemplate());

		$renderer = $this->resolveRenderer($extension);
		$view->getBody()->write($renderer->render($path, $view->getVariables() + $this->globalVariables));

		$view->send();
	}
}
