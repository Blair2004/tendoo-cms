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
	/// MODULES LOADER
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
			$this->error('controller-not-properly');
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
		include_once( CONTROLLERS_DIR . '/error.php' );
		$error		=	new Error;
		$error->code( $notice );
	}
	public function show_error($error,$heading)
	{
		$this->error( $error );
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
			'page-404', 			// 	Deprécié
			array(),			// 	Déprécié
			'status'			=>	'page-404',
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