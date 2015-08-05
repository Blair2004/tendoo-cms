<?php
namespace System\Core;

class ModulesManager
{
	/**
	 * @var array
	 */
	protected $modules;

	/**
	 * @param array             $modules modules name
	 */
	public function __construct(array $modules = [])
	{
		$this->modules = $modules;
	}

	/**
	 * @return array array of modules name
	 */
	public function getModules()
	{
		return $this->modules;
	}
}
