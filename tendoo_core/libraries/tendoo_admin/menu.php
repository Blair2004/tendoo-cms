<?php
class tendoo_menu
{
	private $leftMenuExtentionBefore 	= '';
	private $leftMenuExtentionAfter 	= '';
	public function __construct()
	{
		__extends($this);
	}
	public function menuExtendsAfter($e) // Ajout menu après le menu systeme
	{
		$this->leftMenuExtentionAfter = $e;
	}
	public function menuExtendsBefore($e) // Ajout avant le menu système
	{
		$this->leftMenuExtentionBefore = $e;
	}
	public function parseMenuBefore()
	{
		return $this->leftMenuExtentionBefore;
	}
	public function parseMenuAfter()
	{
		return $this->leftMenuExtentionAfter;
	}
	
}