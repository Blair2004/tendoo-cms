<?php
class Controller
{
	public function firstController($name,$cname,$mod,$title,$description,$main,$visible)
	{
		get_db()->select('*')
					->from('tendoo_controllers');
		$query		=	get_db()->get();
		if($query->num_rows == 0)
		{
			$e['PAGE_CNAME']		=	strtolower($cname);
			$e['PAGE_NAMES']		=	strtolower($name);
			$e['PAGE_TITLE']		=	$title;
			$e['PAGE_DESCRIPTION']	=	$description;
			$e['PAGE_MAIN']			=	$main;
			$e['PAGE_MODULES']		=	$mod;
			$e['PAGE_VISIBLE']		=	$visible;
			$e['PAGE_PARENT']		=	'none'; // Par défaut le premier lien est à la racine puisqu'il s'agit du premier contrôleur.
			return get_db()->insert('tendoo_controllers',$e);			
		}
		return false;
	}
	public function get_controllers( $filter , $id_or_cname_or_start = null , $end = null )
	{
		if( $filter == 'filter_id' ){
			get_db()->select('*')
						->from('tendoo_controllers')
						->where('ID',$id_or_cname_or_start);
			$data		= 	get_db()->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;
			}
			else
			{
				return 'page-404';
			}
		}
		else if( $filter == 'filter_cname' ){
			get_db()->select('*')
						->from('tendoo_controllers')
						->where( 'PAGE_CNAME' , $id_or_cname_or_start );
			$data		= 	get_db()->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;
			}
			else
			{
				return 'page-404';
			}
		}
	}
	public function _get($page = 'index',$getAll = FALSE)
	{
		if($page == 'index')
		{
			get_db()->select('*')
						->from('tendoo_controllers')
						->where('PAGE_MAIN','TRUE');
			$data 		=	get_db()->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;					
			}
			return 'noMainPage';
		}
		else if($getAll == FALSE && $page != null)
		{
			get_db()->select('*')
						->from('tendoo_controllers')
						->where('PAGE_CNAME',$page);
			$data		= 	get_db()->get();
			$value		=	$data->result_array();
			if(count($value) == 1)
			{
				return $value;
			}
			else
			{
				return 'page-404';
			}
		}
		else
		{
			get_db()->select('*')
						->from('tendoo_controllers');
			$data		= 	get_db()->get();
			$value		=	$data->result_array();
			return $value;
		}
	}
	public function getControllers()
	{
		get_db()->select('*')
					->from('tendoo_controllers')->where('PAGE_VISIBLE','TRUE')->order_by('PAGE_POSITION','asc');
		$r			=	get_db()->get();
		return $r->result_array();
	}
	private $levelLimit					= 20; // limitation en terme de sous menu
	public function get_sublevel($cname,$level,$showHidden=TRUE,$getModuleData=TRUE) // Deprecated ?
	{	
		echo tendoo_warning('Tendoo::get_sublevel(...) est une méthode déprécié, Utiliser Tendoo::get(...) à la plage');
		if($level <= $this->levelLimit)
		{
			if($showHidden == FALSE)// ??
			{
				get_db()->where('PAGE_VISIBLE','TRUE');
			}
			get_db()->select('*')
						->where('PAGE_PARENT',$cname) // On recupère le menu de base
						->order_by('PAGE_POSITION','asc')
						->from('tendoo_controllers');
			$query 		=	get_db()->get();
			if($query->num_rows > 0)
			{
				$array		=	array();
				foreach($query->result() as $obj)
				{
					$array[] = array(
						'ID'				=>		$obj->ID,
						'PAGE_CNAME'		=>		$obj->PAGE_CNAME,
						'PAGE_PARENT'		=>		$obj->PAGE_PARENT,
						'PAGE_NAMES'		=>		$obj->PAGE_NAMES,
						'PAGE_MODULES'		=>		$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : $this->getSpeModuleByNamespace($obj->PAGE_MODULES),
						'PAGE_TITLE'		=>		$obj->PAGE_TITLE,
						'PAGE_DESCRIPTION'	=>		$obj->PAGE_DESCRIPTION,
						'PAGE_MAIN'			=>		$obj->PAGE_MAIN,
						'PAGE_VISIBLE'		=>		$obj->PAGE_VISIBLE,
						'PAGE_CHILDS'		=> 		$this->get_sublevel($obj->ID,$level+1),
						'PAGE_LINK'			=>		$obj->PAGE_LINK,
						'PAGE_POSITION'		=>		$obj->PAGE_POSITION
					);
				}
				return $array;
			}
		}
		return false;
	}
	/*
		@$page			=	Code CNAME du contrôleur.
		@$showHidden	=	Recupérer les contrôleurs invisibles sur le menu [true/false].
		@getModuleData	=	Recupérer les modules attachés aux contrôleurs [true/false].
		@getChild		=	Traite $page comme étant parent et opère récupération des enfants au lieu du parent [true/false], défaut FALSE.
	*/
	public function get($page =NULL,$showHidden=TRUE,$getModuleData = TRUE,$getChild = TRUE) 
	{
		if(in_array($page,array('',NULL))) 
		{
			if($showHidden == FALSE)
			{
				get_db()->where('PAGE_VISIBLE','TRUE');
			}
			get_db()->select('*')
						->where('PAGE_PARENT','none') // On recupère le menu de base
						->from('tendoo_controllers');
			$query 	=	get_db()->get();
			$array		=	array();
			foreach($query->result() as $obj)
			{
				if($getModuleData == TRUE)
				{
					$array[] = array(
						'ID'			=>$obj->ID,
						'PAGE_CNAME'	=>$obj->PAGE_CNAME,
						'PAGE_PARENT'	=>$obj->PAGE_PARENT,
						'PAGE_NAMES'	=>$obj->PAGE_NAMES,
						'PAGE_MODULES'	=>$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : get_modules( 'filter_active_namespace' , $obj->PAGE_MODULES ),
						'PAGE_TITLE'	=>$obj->PAGE_TITLE,
						'PAGE_DESCRIPTION'		=>$obj->PAGE_DESCRIPTION,
						'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
						'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
						'PAGE_CHILDS'	=> 	$this->get($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
						'PAGE_LINK'		=>	$obj->PAGE_LINK, // new added 0.9.4
						'PAGE_POSITION'	=>	$obj->PAGE_POSITION,
						'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
					);
				}
				else
				{
					$array[] = array(
						'ID'			=>$obj->ID,
						'PAGE_CNAME'	=>$obj->PAGE_CNAME,
						'PAGE_PARENT'	=>$obj->PAGE_PARENT,
						'PAGE_NAMES'	=>$obj->PAGE_NAMES,
						'PAGE_MODULES'	=>$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : '#MODULE NOT LOADED',
						'PAGE_TITLE'	=>$obj->PAGE_TITLE,
						'PAGE_DESCRIPTION'		=>$obj->PAGE_DESCRIPTION,
						'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
						'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
						'PAGE_CHILDS'	=> 	$this->get($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
						'PAGE_LINK'		=>	$obj->PAGE_LINK, // new added 0.9.4
						'PAGE_POSITION'	=>	$obj->PAGE_POSITION,
						'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
					);
				}
			}
			$this->_gets	=	$array;
			return $array;	
		}
		else
		{
			// If there is any content founded, $array will be overwrited.
			$array		=	FALSE;
			if($showHidden == FALSE)
			{
				get_db()->where('PAGE_VISIBLE','TRUE');
			}
			if($getChild == TRUE)
			{
				get_db()->where('PAGE_PARENT',$page) // On recupère le menu de base
							// ->order_by('PAGE_POSITION','asc')
							->from('tendoo_controllers');
				$query 	=	get_db()->get();
				// var_dump($query);
			}
			else
			{
				get_db()->select('*')
							->from('tendoo_controllers')
							->where('PAGE_CNAME',$page);
				$query 	=	get_db()->get();
			}
			if(count(get_object_vars($query)) > 0)
			{
				// var_dump($query->result());
				foreach($query->result() as $obj)
				{
					if($getModuleData == TRUE)
					{
						$array[] = array(
							'ID'		=>$obj->ID,
							'PAGE_CNAME'	=>	$obj->PAGE_CNAME,
							'PAGE_PARENT'	=>	$obj->PAGE_PARENT,
							'PAGE_NAMES'	=>	$obj->PAGE_NAMES,
							'PAGE_MODULES'	=>	$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : get_modules( 'filter_active_namespace' , $obj->PAGE_MODULES ),
							'PAGE_TITLE'	=>	$obj->PAGE_TITLE,
							'PAGE_DESCRIPTION'	=>$obj->PAGE_DESCRIPTION,
							'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
							'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
							'PAGE_CHILDS'	=>	$this->get($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
							'PAGE_LINK'		=>	$obj->PAGE_LINK, // New added 0.9.4
							'PAGE_POSITION'	=>	$obj->PAGE_POSITION, // added 0.9.5,
							'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
						);
					}
					else
					{
						$array[] = array(
							'ID'		=>$obj->ID,
							'PAGE_CNAME'	=>	$obj->PAGE_CNAME,
							'PAGE_PARENT'	=>	$obj->PAGE_PARENT,
							'PAGE_NAMES'	=>	$obj->PAGE_NAMES,
							'PAGE_MODULES'	=>	$obj->PAGE_MODULES == '#LINK#' ? $obj->PAGE_MODULES : '#MODULE NOT LOADED',
							'PAGE_TITLE'	=>	$obj->PAGE_TITLE,
							'PAGE_DESCRIPTION'	=>$obj->PAGE_DESCRIPTION,
							'PAGE_MAIN'		=>	$obj->PAGE_MAIN,
							'PAGE_VISIBLE'	=>	$obj->PAGE_VISIBLE,
							'PAGE_CHILDS'	=>	$this->get($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
							'PAGE_LINK'		=>	$obj->PAGE_LINK, // New added 0.9.4
							'PAGE_POSITION'	=>	$obj->PAGE_POSITION, // added 0.9.5,
							'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
						);

					}
				}
				$this->_gets	=	$array;
			}	
			return $array;
		}
	}
	public function getControllersAttachedToModule($module) // Recupere la page qui embarque le module spécifié.
	{
		get_db()->select('*')
					->from('tendoo_controllers')->where('PAGE_MODULES',$module); // Nous avons choisi de ne pas exiger la selection des controleur visible "->where('PAGE_VISIBLE','TRUE')"
		$r			=	get_db()->get();
		return $r->result_array();
	}
}