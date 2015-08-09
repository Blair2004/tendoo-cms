<?php
namespace System\Mvc;

use Closure;
use ReflectionClass;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionParameter;
use RuntimeException;
use System\Utility\ClassInspector;

class Container
{
	/**
	 * Registered type hints.
	 *
	 * @var array
	 */
	protected $hints = [];

	/**
	 * @var array
	 */
	protected $aliases = [];

	/**
	 * Singleton instances.
	 *
	 * @var array
	 */
	protected $instances = [];

	/**
	 * Parse the hint parameter.
	 *
	 * @param   string|array  $hint  Type hint or array containing both type hint and alias
	 * @return  string name
	 */
	protected function parseHint($hint)
	{
		if (is_array($hint)) {
			$name = array_shift($hint);
			foreach ($hint as $alias) {
				$this->aliases[$alias] = $name;
			}
		} else {
			$name = $hint;
		}

		return $name;
	}

	/**
	 * Register a type hint.
	 *
	 * @param   string|array     $hint       Type hint or array containing both type hint and alias
	 * @param   string|Closure  $class      Class name or closure
	 * @param   boolean          $singleton  Should we return the same instance every time?
	 */
	public function register($hint, $class, $singleton = false)
	{
		$this->hints[$this->parseHint($hint)] = ['class' => $class, 'singleton' => $singleton];
	}

	/**
	 * Register a type hint and return the same instance every time.
	 *
	 * @param   string|array     $hint   Type hint or array containing both type hint and alias
	 * @param   string|Closure  $class  Class name or closure
	 */
	public function registerSingleton($hint, $class)
	{
		$this->register($hint, $class, true);
	}

	/**
	 * Register a singleton instance.
	 *
	 * @param   string|array  $hint      Type hint or array containing both type hint and alias
	 * @param   object        $instance  Class instance
	 */
	public function registerInstance($hint, $instance)
	{
		$this->instances[$this->parseHint($hint)] = $instance;
	}

	/**
	 * Return the name based on its alias. If no alias exists then we'll just return the value we received.
	 *
	 * @param   string     $alias  Alias
	 * @return  string
	 */
	protected function resolveAlias($alias)
	{
		$alias = ltrim($alias, '\\');

		return isset($this->aliases[$alias]) ? $this->aliases[$alias] : $alias;
	}

	/**
	 * Resolve a type hint.
	 *
	 * @access  protected
	 * @param   string     $hint  Type hint
	 * @return  string
	 */
	protected function resolveHint($hint)
	{
		return isset($this->hints[$hint]) ? $this->hints[$hint]['class'] : $hint;
	}

	/**
	 * Checks if a class is registered in the container.
	 *
	 * @param   string   $class  Class name
	 * @return  boolean
	 */
	public function has($class)
	{
		$class = $this->resolveAlias($class);

		return isset($this->hints[$class]) or isset($this->instances[$class]);
	}

	/**
	 * Execute a callable and inject its dependencies.
	 *
	 * @param   callable $callable   Callable
	 * @param   array    $parameters Parameters
	 * @return  object
	 */
	public function call(callable $callable, array $parameters = [])
	{
		if ($callable instanceof Closure or (is_string($callable) and ($static = strpos('::', $callable)) === false)) {
			$reflection = new ReflectionFunction($callable);
		} else {
			if (isset($static) and $static) {
				$callable = explode('::'. $callable, 2);
			}

			$reflection = new ReflectionMethod($callable[0], $callable[1]);
		}

		$parameters = $this->resolveParameters($reflection->getParameters(), $parameters);

		return call_user_func_array($callable, $parameters);
	}

	/**
	 * Returns a class instance.
	 *
	 * @param   string  $class         Class name
	 * @param   array   $parameters    Constructor parameters
	 * @param   boolean $reuseInstance Reuse existing instance?
	 * @return  object
	 */
	public function get($class, array $parameters = [], $reuseInstance = true)
	{
		$class = $this->resolveAlias($class);

		// If a singleton instance exists then we'll just return it
		if ($reuseInstance and isset($this->instances[$class])) {
			return $this->instances[$class];
		}

		// Create new instance
		$instance = $this->factory($this->resolveHint($class), $parameters);

		// Store the instance if its registered as a singleton
		if ($reuseInstance and isset($this->hints[$class]) and $this->hints[$class]['singleton']) {
			$this->instances[$class] = $instance;
		}

		// Return the instance
		return $instance;
	}

	/**
	 * Resolve parameters.
	 *
	 * @param   array $reflectionParameters Reflection parameters
	 * @param   array $providedParameters   Provided Parameters
	 * @return  array
	 */
	protected function resolveParameters(array $reflectionParameters, array $providedParameters)
	{
		if (empty($reflectionParameters)) {
			return $providedParameters;
		}

		// Merge provided parameters with the ones we got using reflection
		$parameters = $this->mergeParameters($reflectionParameters, $providedParameters);

		// Loop through the parameters and resolve the ones that need resolving
		foreach ($parameters as $key => $parameter) {
			if ($parameter instanceof ReflectionParameter) {
				$parameters[$key] = $this->resolveParameter($parameter);
			}
		}

		// Return resolved parameters
		return $parameters;
	}

	/**
	 * Merges the provided parameters with the reflection parameters.
	 *
	 * @param   array $reflectionParameters Reflection parameters
	 * @param   array $providedParameters   Provided parameters
	 * @return  array
	 */
	protected function mergeParameters(array $reflectionParameters, array $providedParameters)
	{
		// Make reflection parameter array associative
		$associativeReflectionParameters = [];
		foreach ($reflectionParameters as $key => $value) {
			/** @var ReflectionParameter $value */
			$associativeReflectionParameters[$value->getName()] = $value;
		}

		// Make the provided parameter array associative
		$associativeProvidedParameters = [];
		foreach ($providedParameters as $key => $value) {
			if (is_numeric($key)) {
				/** @var ReflectionParameter $reflectionParameter */
				$reflectionParameter = $reflectionParameters[$key];
				$associativeProvidedParameters[$reflectionParameter->getName()] = $value;
			} else {
				$associativeProvidedParameters[$key] = $value;
			}
		}

		// Return merged parameters
		return array_replace($associativeReflectionParameters, $associativeProvidedParameters);
	}

	/**
	 * Resolve a parameter.
	 *
	 * @param   ReflectionParameter $parameter ReflectionParameter instance
	 * @return  mixed
	 * @throws RuntimeException when unable to resolve any parameter
	 */
	protected function resolveParameter(ReflectionParameter $parameter)
	{
		if (($parameterClass = $parameter->getClass()) !== null) {
			// The parameter should be a class instance. Try to resolve it though the container
			return $this->get($parameterClass->getName());
		}

		if ($parameter->isDefaultValueAvailable()) {
			// The parameter has a default value so we'll use that
			return $parameter->getDefaultValue();
		}

		// We have exhausted all our options. All we can do now is throw an exception
		throw new RuntimeException(sprintf(
			'Unable to resolve the $%s parameter of "%s".',
			$parameter->getName(), $this->getDeclaringFunction($parameter)
		));
	}

	/**
	 * Returns the name of the declaring function.
	 *
	 * @param   ReflectionParameter $parameter ReflectionParameter instance
	 * @return  string
	 */
	protected function getDeclaringFunction(ReflectionParameter $parameter)
	{
		$declaringFunction = $parameter->getDeclaringFunction();

		if ($declaringFunction->isClosure()) {
			return 'Closure';
		}

		return $parameter->getDeclaringClass()->getName() . '::' . $declaringFunction->getName();
	}

	/**
	 * Creates a class instance.
	 *
	 * @param   string|Closure  $factory      Class name or closure
	 * @param   array           $parameters Constructor parameters
	 * @return  object
	 */
	protected function factory($factory, array $parameters = [])
	{
		// Instantiate class
		if ($factory instanceof Closure) {
			$instance = $this->closureFactory($factory, $parameters);
		} else {
			$instance = $this->classFactory($factory, $parameters);
		}

		// Inject container using setter if the class is container aware
		if ($this->isContainerAware($instance)) {
			$instance->setContainer($this);
		}

		// Return the instance
		return $instance;
	}

	/**
	 * Creates a class instance using a factory closure.
	 *
	 * @param   Closure  $closure     closure
	 * @param   array     $parameters  Constructor parameters
	 * @return  object
	 * @throws RuntimeException when factory class doesn't return object
	 */
	protected function closureFactory(Closure $closure, array $parameters)
	{
		$closure = new ReflectionFunction($closure);

		$instance = $closure->invokeArgs($this->resolveParameters($closure->getParameters(), $parameters));

		// Check that the factory closure returned an object
		if (! is_object($instance)) {
			throw new RuntimeException('The factory closure must return an object.');
		}

		return $instance;
	}

	/**
	 * Creates a class instance using reflection.
	 *
	 * @param   string  $class       Class name
	 * @param   array   $parameters  Constructor parameters
	 * @return  object
	 * @throws RuntimeException when unable to create instance
	 */
	protected function classFactory($class, array $parameters)
	{
		$class = new ReflectionClass($class);

		// Check that it's possible to instantiate the class
		if(! $class->isInstantiable()) {
			throw new RuntimeException(sprintf('Unable create a "%s" instance.', $class->getName()));
		}

		// Get the class constructor
		$constructor = $class->getConstructor();

		if ($constructor === null) {
			// No constructor has been defined so we'll just return a new instance
			$instance = $class->newInstance();
		} else {
			// The class has a constructor. Lets get its parameters.
			$constructorParameters = $constructor->getParameters();

			// Create and return a new instance using our resolved parameters
			$instance = $class->newInstanceArgs($this->resolveParameters($constructorParameters, $parameters));
		}

		return $instance;
	}

	/**
	 * Checks if a class is container aware.
	 *
	 * @param   object     $class  Class instance
	 * @return  boolean
	 */
	protected function isContainerAware($class)
	{
		$traits = ClassInspector::getTraits($class);

		return isset($traits['System\Common\ContainerAwareTrait']);
	}
}
