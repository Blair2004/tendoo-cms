<?php
namespace System\Http\Routing;

use Closure;

class Route
{
	/**
	 * @var array
	 */
	protected $methods;

	/**
	 * @var string
	 */
	protected $uri;

	/**
	 * @var string
	 */
	protected $uriPrefix = '';

	/**
	 * @var string|Closure
	 */
	protected $action;

	/**
	 * Route action namespace.
	 *
	 * @var string
	 */
	protected $namespace = '';

	/**
	 * @var array
	 */
	protected $constraints = [];

	/**
	 * @var array
	 */
	protected $beforeFilters = [];

	/**
	 * @var array
	 */
	protected $afterFilters = [];

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $namePrefix = '';

	/**
	 * @param   array       $methods    Route methods
	 * @param   array       $uri
	 * @param   string|Closure    $action     Route action
	 * @param   string|null $name       Route name
	 */
	public function __construct(array $methods, $uri, $action, $name = null)
	{
		$this->methods = $methods;
		$this->uri = rtrim($uri, '/');
		$this->action = $action;
		$this->name = $name;
	}

	/**
	 * Returns the HTTP methods the route responds to.
	 *
	 * @return  array
	 */
	public function getMethods()
	{
		return $this->methods;
	}

	/**
	 * @return  string
	 */
	public function getUri()
	{
		return $this->uriPrefix . $this->uri;
	}

	/**
	 * get route uri prefix
	 *
	 * @return string
	 */
	public function getUriPrefix()
	{
		return $this->uriPrefix;
	}

	/**
	 * @inheritdoc
	 */
	public function getAction()
	{
		return $this->action instanceof Closure ? $this->action : $this->namespace . $this->action;
	}

	/**
	 * get the route action namespace.
	 *
	 * @return  string
	 */
	public function getNamespace()
	{
		return $this->namespace;
	}

	/**
	 * Returns the route name.
	 *
	 * @return  string|null
	 */
	public function getName()
	{
		return $this->name === null ? null : $this->namePrefix . $this->name;
	}

	/**
	 * get route name prefix
	 *
	 * @return string|null
	 */
	public function getNamePrefix()
	{
		return $this->namePrefix;
	}

	/**
	 * Returns the regex needed to match the route.
	 *
	 * @return  string
	 */
	public function getPattern()
	{
		$retPattern = $this->getUri();

		// replace custom patterns if have any
		if (isset($this->constraints)) {
			foreach ($this->constraints as $subject => $pattern) {
				$retPattern = str_replace('{' . $subject . '}', "(?P<$subject>$pattern)", $retPattern);
			}
		}

		// replace default patterns
		$retPattern = preg_replace('#{.+}#', '(.+)', $retPattern);

		return '#^' . $retPattern . '$#s';
	}

	/**
	 * Returns the before filters.
	 *
	 * @return  array
	 */
	public function getBeforeFilters()
	{
		return $this->beforeFilters;
	}

	/**
	 * Returns the after filters.
	 *
	 * @return  array
	 */
	public function getAfterFilters()
	{
		return $this->afterFilters;
	}

	/**
	 * Returns TRUE if the route allows the specified method or FALSE if not.
	 *
	 * @param   string   $method  Method
	 * @return  boolean
	 */
	public function allows($method)
	{
		return in_array($method, $this->methods);
	}

	/**
	 * Adds a prefix to the  .
	 *
	 * @param   string $prefix
	 * @return  $this
	 */
	public function setUriPrefix($prefix)
	{
		if (! empty($prefix)) {
			$this->uriPrefix .= $prefix;
		}

		return $this;
	}

	/**
	 * Sets the route action namespace.
	 *
	 * @param   string $namespace  Route action namespace
	 * @return  $this
	 */
	public function setNamespace($namespace)
	{
		if (! empty($namespace)) {
			$this->namespace .= rtrim($namespace, '\\') . '\\';
		}

		return $this;
	}

	/**
	 * set route name prefix
	 *
	 * @param $prefix
	 */
	public function setNamePrefix($prefix)
	{
		$this->namePrefix .= $prefix;
	}

	/**
	 * Sets the custom constraints.
	 *
	 * @param   string|array $subject
	 * @param   string|null $pattern
	 * @return  $this
	 */
	public function when($subject, $pattern = null)
	{
		if (is_array($subject)) {
			$this->constraints = array_merge($this->constraints, $subject);
		} else {
			$this->constraints[$subject] = $pattern;
		}

		return $this;
	}

	/**
	 * Adds a set of before filters.
	 *
	 * @param   array|string|Closure $filters
	 * @return  $this
	 */
	public function before($filters)
	{
		$this->beforeFilters = array_merge($this->beforeFilters, (array) $filters);

		return $this;
	}

	/**
	 * Adds a set of after filters.
	 *
	 * @param   array|string|Closure $filters
	 * @return  $this
	 */
	public function after($filters)
	{
		$this->afterFilters = array_merge($this->afterFilters, (array) $filters);

		return $this;
	}
}
