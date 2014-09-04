<?php
class Tendoo
{
	public function __construct()
	{
		$this->instance			=		get_instance();
		$this->load				=&		$this->instance->load;
		$this->defaultTitle 	= 		'Page Sans Titre - Tendoo';
		$this->defaultDesc		= 		'Page sans description - Tendoo';
		// DEPRECATED START
		if(is_file('tendoo-core/config/db_config.php'))
		{
			$this->isInstalled =  true;
		}
		else
		{
			$this->isInstalled = false;
		}	
		// DEPRECATED END
	}
	public function getBackgroundImage()
	{
		$images_list	=	array("bkoverlay.jpg");
		$rand			=	$images_list[0]; // [rand(0,count($images_list)-1)]
		return $rand;
	}
	public function isInstalled()
	{
		return $this->isInstalled;
	}
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
	public function getSiteTheme()
	{
		$query	=	get_db()->where('ACTIVATED','TRUE')->get('tendoo_themes');
		$data	=	$query->result_array();
		if(array_key_exists(0,$data))
		{
			return $data[0];
		}
		else
		{
			return false;
		
		}
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
				return 'page404';
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
				return 'page404';
			}
		}
	}
	public function getPage($page = 'index',$getAll = FALSE)
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
		else if(preg_match('#@#',$page))
		{
			$Teurmola	=	explode('@',$page);
			return array(
				array(
					'PAGE_TITLE'				=>		$this->getTitle(),
					'PAGE_CNAME'				=>		$page,
					'PAGE_DESCRIPTION'			=>		$this->getDescription()
				)
			);
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
				return 'page404';
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
		echo tendoo_warning('Tendoo::get_sublevel(...) est une méthode déprécié, Utiliser Tendoo::get_pages(...) à la plage');
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
	public function get_pages($page =NULL,$showHidden=TRUE,$getModuleData = TRUE,$getChild = TRUE) 
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
						'PAGE_CHILDS'	=> 	$this->get_pages($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
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
						'PAGE_CHILDS'	=> 	$this->get_pages($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
						'PAGE_LINK'		=>	$obj->PAGE_LINK, // new added 0.9.4
						'PAGE_POSITION'	=>	$obj->PAGE_POSITION,
						'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
					);
				}
			}
			$this->getpages	=	$array;
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
							'PAGE_CHILDS'	=>	$this->get_pages($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
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
							'PAGE_CHILDS'	=>	$this->get_pages($obj->PAGE_CNAME,$showHidden,$getModuleData,$getChild),
							'PAGE_LINK'		=>	$obj->PAGE_LINK, // New added 0.9.4
							'PAGE_POSITION'	=>	$obj->PAGE_POSITION, // added 0.9.5,
							'PAGE_KEYWORDS'	=>	$obj->PAGE_KEYWORDS
						);

					}
				}
				$this->getpages	=	$array;
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
	/// MODULES LOADER
	public function getGlobalModules() // Récupération de tous les modules de type GLOBAL
	{
		return false;
		$query	=	get_db()	->where('TYPE','GLOBAL')
									->where('ACTIVE','1')
									->get('tendoo_modules');
		$data	=	$query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function getSpeModule($id,$option =	TRUE) // Obsolete Transit
	{
		return $this->getSpeMod($id,$option);
	}
	public function getSpeMod($value,$option = TRUE)
	{
		get_db()		->select('*')
							->from('tendoo_modules');
		if($option == TRUE)
		{
			get_db()->where('ID',$value);
		}
		else
		{
			get_db()->where('NAMESPACE',$value);
		}
							
		$query				= get_db()->get();
		$data				=	 $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;		
	}
	public function getSpeModuleByNamespace($namespace)
	{
		get_db()		->select('*')
							->from('tendoo_modules')
							->where('NAMESPACE',$namespace)
							->where('ACTIVE','1');
		$query				= get_db()->get();
		$data				= $query->result_array();
		if(count($data) > 0)
		{
			return $data;
		}
		return false;
	}
	public function setTitle($e)
	{
		$this->defaultTitle = $e;
	}
	public function getTitle()
	{
		return $this->defaultTitle;
	}
	public function setDescription($e)
	{
		$this->defaultDesc	=	strip_tags(word_limiter($e,200));
	}
	public function getDescription()
	{
		return $this->defaultDesc;
	}
	public function setKeywords($e)
	{
		$this->keyWords		=	$e;
	}
	public function getKeywords()
	{
		if(isset($this->keyWords))
		{
			return $this->keyWords;
		}
		return false;
	}
	/* INNER FUNCTION */
	/*public function loadModules() /// OBSOLETE
	{
		$modules= array();
		if($dir	=	opendir('application/views/modules'))
		{
			while(($file = readdir($dir)) !== FALSE)
			{
				if(!in_array($file,array('.','..')))
				{
					$modules[]	=	new Modules($file);
				}
			}
			return $modules;
		}
		return false;
	}*/
	public function presentation()
	{
		include(SYSTEM_DIR.'presentation.php');
	}
	public function interpreter($Class,$Method,$Parameters,$Init	=	array(),$module_datas	=	array())
	{
		if(class_exists($Class))
		{
			 eval('$objet	= new '.$Class.'($Init);'); // Création de l'objet
		}
		else
		{
			$this->error('controllerNotWellDefined');die;
		}
		// Default Else
		$BODY	=	'404';
		if($module_datas == TRUE)
		{
			if( riake( 'self_url_handle' , $module_datas ) == true )
			{
				array_unshift($Parameters,$Method);
				// On laisse la prise en charge du contrôleur au module si le souhaite
				eval( '$BODY 	=	$objet->index($Parameters);' );
			}
			else if(method_exists($objet,$Method))
			{
				$param_text		=	'';
				$i = 0;
				foreach($Parameters as $p)
				{
					if($p != '') // Les parametres vide ne sont pas accepté
					{
					//	var_dump($p);
						if($i+1 < count($Parameters)) // Tant que l'on n'a pas atteind la fin du tableau.
						{
							if(strlen($Parameters[$i+1]) > 0) // Si le nombre de caractère est supérieur a 0
							{
								$param_text .= '"'.$p.'",'; // ajouté une virgule à la fin de la chaine de caractère personnalisée.
							}
							else
							{
								$param_text .= '"'.$p.'"'; // omettre la virgule.	
							}
						}
						else
						{
							$param_text .= '"'.$p.'"'; // omettre la virgule.
						}
					}
					$i++;
				}		
				//var_dump($param_text);
				eval('$BODY 	=	$objet->'.$Method.'('.$param_text.');'); // exécution du controller.
				
				return $BODY;
			}
		}
		else if(method_exists($objet,$Method))
		{
			$param_text		=	'';
			$i = 0;
			foreach($Parameters as $p)
			{
				if($p != '') // Les parametres vide ne sont pas accepté
				{
				//	var_dump($p);
					if($i+1 < count($Parameters)) // Tant que l'on n'a pas atteind la fin du tableau.
					{
						if(strlen($Parameters[$i+1]) > 0) // Si le nombre de caractère est supérieur a 0
						{
							$param_text .= '"'.$p.'",'; // ajouté une virgule à la fin de la chaine de caractère personnalisée.
						}
						else
						{
							$param_text .= '"'.$p.'"'; // omettre la virgule.	
						}
					}
					else
					{
						$param_text .= '"'.$p.'"'; // omettre la virgule.
					}
				}
				$i++;
			}		
			//var_dump($param_text);
			eval('$BODY 	=	$objet->'.$Method.'('.$param_text.');'); // exécution du controller.
			
			return $BODY;
		}
		return $BODY;
	}
	public function error($notice)
	{
		set_page('title','Erreur');
		get_instance()->load->library('file');
		get_instance()->file->css_push('app.v2');
		get_instance()->file->css_push('tendoo_global');
		$error	=	fetch_notice_output($notice);
		
		include_once(VIEWS_DIR.'warning.php');
	}
	public function show_error($error,$heading)
	{
		$this->setTitle('Erreur - '.$heading);
		$this->instance			=	get_instance();
		$this->instance->load->library('file');
		$this->instance->file->css_push('app.v2');
		$this->instance->file->css_push('tendoo_global');
		include_once(VIEWS_DIR.'warning.php');
	}
	public function paginate($elpp,$ttel,$pagestyle,$classOn,$classOff,$current_page,$baselink,$ajaxis_link=null) // Deprecated
	{
		tendoo_warning('<strong>tendoo::paginate</strong> est désormais déprécié, utilisez "<strong>doPaginate</strong>" à la place.');
		/*// Gloabl ressources Control*/
		if(!is_finite($elpp))				: echo '<strong>$elpp</strong> is not finite'; return;
		elseif(!is_finite($pagestyle))		: echo '<strong>$pagestyle</strong> is not finite'; return;
		elseif(!is_finite($current_page))	: echo '<strong>$current_page</strong> is not finite'; return;
		endif;
		
		$more	=	array();
		if($pagestyle == 1)
		{
			$ttpage = ceil($ttel / $elpp);
			if(($current_page > $ttpage || $current_page < 1) && $ttel > 0): return array('',null,null,false,$more);
			endif;
			$firstoshow = ($current_page - 1) * $elpp;
			/*// FTS*/
			if($current_page < 5):$fts = 1;
			elseif($current_page >= 5):$fts = $current_page - 4;
			endif;
			/*// LTS*/
			if(($current_page + 4) <= $ttpage):$lts = $current_page + 4;
			/*elseif($ttpage > 5):$lts = $ttpage - $current_page;*/
			else:$lts = $ttpage;
			endif;
			
			$content = null;
			for($i = $fts;$i<=$lts;$i++)
			{
				$more[]	=	array(
					'link'	=>	$baselink.$i,
					'text'	=>	$i,
					'state'	=>	((int)$i === (int)$current_page) ? $classOn : $classOff // Fixing int type 03.11.2013
				);
				static $content = 'Page :';
				if($i == $fts && $i != 1): $content = $content.'<span style="margin:0 2px">...</span>';endif;
				if($current_page == $i)
				{
				$content = $content.'<span style="margin:0 2px">'.$i.'</span>';
				}
				else
				{
					if($ajaxis_link != null)
					{
						$content = $content.'<a ajaxis_link="'.$ajaxis_link.$i.'" href="'.$baselink.$i.'" class="'.$classOn.'" style="margin:0 2px" title="Aller &agrave; la page '.$i.'">'.$i.'</a>';
					}
					else
					{
						$content = $content.'<a href="'.$baselink.$i.'" class="'.$classOn.'" style="margin:0 2px" title="Aller &agrave; la page '.$i.'">'.$i.'</a>';
					}
				}
				if($i == $lts && $i != $ttpage):$content = $content.'<span style="margin:0 2px">...</span>';endif;
			}		
			return array($content,$firstoshow,$elpp,true,$more);
		}
		else if($pagestyle == 2)
		{
			$ttpage = ceil($ttel / $elpp);
			if($current_page > $ttpage || $current_page < 1): return array('',null,null,false);endif;
			$firstoshow = ($current_page - 1) * $elpp;
			if($current_page == 1)
			{
				$content['Precedent'] = '<a class="'.$classOff.'">Pr&eacute;c&eacute;dent</a>';
			}
			else if($current_page > 1)
			{
				if($ajaxis_link != null)
				{
					$content['Precedent'] = '<a ajaxis_link="'.$ajaxis_link.($current_page-1).'" href="'.$baselink.($current_page-1).'" class="'.$classOn.'">Pr&eacute;c&eacute;dent</a>';
				}
				else
				{
					$content['Precedent'] = '<a href="'.$baselink.($current_page-1).'" class="'.$classOn.'">Pr&eacute;c&eacute;dent</a>';
				}
			}
			if($current_page == $ttpage)
			{
				$content['Suivant']		= '<a class="'.$classOff.'">Suivant</a>';
			}
			else if($current_page < $ttpage)
			{
				if($ajaxis_link != null)
				{
					$content['Suivant']		= '<a ajaxis_link="'.$ajaxis_link.($current_page+1).'" class="'.$classOn.'" href="'.$baselink.($current_page+1).'">Suivant</a>';
				}
				else
				{
					$content['Suivant']		= '<a class="'.$classOn.'" href="'.$baselink.($current_page+1).'">Suivant</a>';
				}
			}
			/*// Debug*/
			/*echo 'Frist To Show: '.$fts.'<br>';
			echo 'Current Page: '.$current_page.'<br>';
			echo 'Last To Show: '.$lts.'<br>';*/
			return array($content,$firstoshow,$elpp,true);
		}
	}
	public function doPaginate($elpp,$ttel,$current_page,$baselink)
	{
		/*// Gloabl ressources Control*/
		if(!is_finite($elpp))				: echo '<strong>$elpp</strong> is not finite'; return;
		elseif(!is_finite($current_page))	: echo '<strong>$current_page</strong> is not finite'; return;
		endif;
		
		$more	=	array();
		$ttpage = ceil($ttel / $elpp);
		if(($current_page > $ttpage || $current_page < 1) && $ttel > 0): return array(
			'start'				=>	0,
			'end'				=>	0,
			'page404', 			// 	Deprécié
			array(),			// 	Déprécié
			'status'			=>	'page404',
			'pagination'		=>	array(),
			'available_pages'	=>	0,
			'current_page'		=>	0
		);
		endif;
		$firstoshow = ($current_page - 1) * $elpp;
		/*// FTS*/
		if($current_page < 5):$fts = 1;
		elseif($current_page >= 5):$fts = $current_page - 4;
		endif;
		/*// LTS*/
		if(($current_page + 4) <= $ttpage):$lts = $current_page + 4;
		/*elseif($ttpage > 5):$lts = $ttpage - $current_page;*/
		else:$lts = $ttpage;
		endif;
		
		$content = null;
		for($i = $fts;$i<=$lts;$i++)
		{
			$more[]	=	array(
				'link'	=>	$baselink.'/'.$i,
				'text'	=>	$i,
				'state'	=>	((int)$i === (int)$current_page) ? "active" : "" // Fixing int type 03.11.2013
			);
		}		
		return array(
			'start'				=>	$firstoshow,
			'end'				=>	$elpp,
			'pageExists', 		// 	Deprécié
			$more,				// 	Déprécié
			'status'			=>	'pageExists',
			'pagination'		=>	$more,
			'available_pages'	=>	$ttpage,
			'current_page'		=>	$current_page
		);
		
	}
	public function callbackLogin() // Renvoie vers la page de connexion lorsque l'utilisateur n'est pas connecté et le renvoir sur la dernier pas en cas de connexion
	{
		if(!$this->instance->users_global->isConnected())
		{
			$this->instance->url->redirect(array('login?ref='.urlencode($this->instance->url->request_uri())));
			return;
		}
	}	
}