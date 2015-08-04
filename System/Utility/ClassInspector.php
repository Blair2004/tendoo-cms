<?php
namespace System\Utility;

class ClassInspector
{
	/**
	 * Returns an array of all traits used by a class.
	 *
	 * @param   string|object $class    Class name or class instance
	 * @param   boolean       $autoload Autoload
	 * @return  array
	 */
	public static function getTraits($class, $autoload = true)
	{
		// Fetch all traits used by a class and its parents
		$traits = [];
		do $traits += class_uses($class, $autoload); while ($class = get_parent_class($class));

		// Find all traits used by the traits

		$search = $traits;
		$searched = [];

		while (! empty($search)) {
			$trait = array_pop($search);

			if (isset($searched[$trait])) {
				continue;
			}

			$traits += $search += class_uses($trait, $autoload);

			$searched[$trait] = $trait;
		}

		// Return complete list of traits used by the class
		return $traits;
	}
}
