<?php
class Tendoo_admin 
{
	protected $getpages;
	private $heritedObj					=	array(); // 0.9.7
	public function __construct()
	{
		$this->core				=	Controller::instance();
		$this->tendoo			=&	$this->core->tendoo;
		$this->load_tendoo_admin_classes();
		
		$this->__herits(new tendoo_file_manager());
		$this->__herits(new tendoo_controllers());
		$this->__herits(new tendoo_menu());
		$this->__herits(new tendoo_privileges());
		$this->__herits(new tendoo_modules());
		$this->__herits(new tendoo_restore());
		$this->__herits(new tendoo_stats());
		$this->__herits(new tendoo_themes());
		$this->__herits(new tendoo_settings());
		$this->__herits(new tendoo_installer());
		$this->__herits(new tendoo_system());
		
	}
	public function __call($method,$arguments)// 0.9.7
	{	
		if(!method_exists($this,$method))
		{
			foreach($this->heritedObj as $obj)
			{
				if(method_exists($obj,$method))
				{
					return call_user_func_array(array($obj,$method),$arguments);
				}
			}
		}
        throw new Exception("\"{$method}\" is not defined or doesn't exists");
	}
	public function __herits(&$obj)
	{
		$this->heritedObj[]	=	$obj;
	}
	public function load_tendoo_admin_classes()
	{
		// Forcément l'utilisateur est censé être un administrateur, chargement des classes...
		$tad	=	'tendoo_core/libraries/tendoo_admin/'; // Tendoo Admin Directory
		// Including Extended functionnality
		if(is_dir($tad))
		{
			$dir	=	opendir($tad);
			while (false !== ($file = readdir($dir))) {
				if ($file != "." && $file != "..") {
					include_once($tad.$file); // including all files
				}
			}
			closedir($dir);
		}
		// Ends
	}
}