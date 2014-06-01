<?php
	/**
	*	bootstrap_pagination_parser, génère une liste de lien au format HTML de bootstrap.
	**/
	function bootstrap_pagination_parser($array,$additionnal_classes = "pagination-sm m-t-none m-b-none")
	{
		?>
    <ul class="pagination <?php echo $additionnal_classes;?>">
    <?php 
	
    if(is_array($array[1]))
    {
		foreach($array[1] as $p)
		{
			if(isset($_GET['limit']))
			{
			?>
			<li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>?limit=<?php echo $_GET['limit'];?>"><?php echo $p['text'];?></a></li>
			<?php
			}
			else
			{
				?>
			<li class="<?php echo $p['state'];?>"><a href="<?php echo $p['link'];?>"><?php echo $p['text'];?></a></li>
			<?php
			}
		}
    }
    ?>
    </ul>
	<?php
	}
	/**
	*	pagination_helper Renvoi un tableau d'une pagination effectué avec les paramètres envoyés à la fonction
	**/	
	function pagination_helper($ContentPerPage,$TotalContent,$CurrentPage,$BaseUrl,$RedirectUrl = array('error','code','page404'))
	{
		$CORE	=	Controller::instance();
		$result	=	$CORE->tendoo->doPaginate($ContentPerPage,$TotalContent,$CurrentPage,$BaseUrl);
		if($result[0] == 'page404'): $CORE->url->redirect($RedirectUrl);endif;
		return $result;
	}
	/**
	*	module_access() Disponible uniquement lorsque l'objet tendoo_admin existe, donc uniquement dans l'espace administration
	**/
	function module_access($module_action,$module_namespace)
	{
		$CORE	=	Controller::instance();
		if(isset($CORE->tendoo_admin))
		{
			return $CORE->tendoo_admin->actionAccess($module_action,$module_namespace);
		}
		return false;
	}
	/**
	*	module assets url, renvoi le chemin d'accès vers le dossier du module actif (actuellement ouvert depuis l'interface d'admininstration), à utiliser uniquement dans l'environnement du module.
	**/
	function module_assets_url($segments)
	{
		$CORE	=	Controller::instance();
		if(isset($CORE->data))
		{
			if(array_key_exists('module',$CORE->data))
			{
				if(is_array($segments))
				{
					return $CORE->url->main_url().MODULES_DIR.$CORE->data['module'][0]['ENCRYPTED_DIR'].'/'.$CORE->url->array2Url($segments);
				}
				else
				{
					return $CORE->url->main_url().MODULES_DIR.$CORE->data['module'][0]['ENCRYPTED_DIR'].'/'.$segments;
				}
			}
		}
		return false;
	}
/*
	Tendoo 0.9.8 Only
	
	Facilite l'utilisation des ressources sans nécessairement avoir besoin d'utiliser l'objet Controller::instance();
	module_...()
	module_url()
		Renvoie l'url du module actuellement en cours d'exécution. Fait usage des méthodes $this->core->url... et du tableau $this->data;
*/
	
	function module_url($segments)
	{
		$CORE	=	Controller::instance();
		if(SCRIPT_CONTEXT == 'ADMIN')
		{
			if(isset($CORE->data))
			{
				if(array_key_exists('module',$CORE->data))
				{
					if(is_array($segments))
					{
						return $CORE->url->site_url('admin/open/modules/'.$CORE->data['module'][0]['ID'].'/'.$CORE->url->array2Url($segments));
					}
					else
					{
						return $CORE->url->site_url('admin/open/modules/'.$CORE->data['module'][0]['ID'].'/'.$segments);
					}
				}
			}
		}
		else
		{
			if(isset($CORE->data))
			{
				if(array_key_exists('module',$CORE->data))
				{
					if(is_array($segments))
					{
						return $CORE->url->site_url($CORE->data['page'][0]['PAGE_CNAME'].'/'.$CORE->url->array2Url($segments));
					}
					else
					{
						return $CORE->url->site_url($CORE->data['page'][0]['PAGE_CNAME'].'/'.$segments);
					}
				}
			}
		}
		return false;
	}
	function module_location($segments)
	{
		$CORE	=	Controller::instance();
		if(isset($CORE->data))
		{
			if(SCRIPT_CONTEXT == 'ADMIN')
			{
				if(array_key_exists('module',$CORE->data))
				{
					if(is_array($segments))
					{
						$baseSegments	=	array(
						'admin','open','modules',$CORE->data['module'][0]['ID']);
						// Nous ajoutons les segments aux segments de base
						foreach($segments as $seg)
						{
							array_push($baseSegments,$seg);
						}
						$CORE->url->redirect($baseSegments);
					}
					else
					{
						$baseSegments	=	array(
						'admin','open','modules',$CORE->data['module'][0]['ID']);
						// Nous ajoutons le segment aux segments de base
						array_push($baseSegments,$segments);
						$CORE->url->redirect($baseSegments);
						return $CORE->url->site_url($baseSegments);
					}
				}
			}
			else
			{
				if(array_key_exists('module',$CORE->data))
				{
					if(is_array($segments))
					{
						$baseSegments	=	array($CORE->data['page'][0]['PAGE_CNAME']);
						// Nous ajoutons les segments aux segments de base
						foreach($segments as $seg)
						{
							array_push($baseSegments,$seg);
						}
						$CORE->url->redirect($baseSegments);
					}
					else
					{
						$baseSegments	=	array($CORE->data['page'][0]['PAGE_CNAME']);
						// Nous ajoutons le segment aux segments de base
						array_push($baseSegments,$segments);
						$CORE->url->redirect($baseSegments);
						return $CORE->url->site_url($baseSegments);
					}
				}
			}
		}
		return false;
	}
	function theme_dir()
	{
		$CORE	=	Controller::instance();
		return $CORE->main_url().THEMES_DIR.$CORE->data['activeTheme']['ENCRYPTED_DIR'];
	}
	function theme_assets_url($url)
	{
		$CORE	=	Controller::instance();
		if(is_array($url))	
			return THEMES_DIR.$CORE->data['activeTheme']['ENCRYPTED_DIR'].'/'.$CORE->url->array2Url($url);
		else 
			return THEMES_DIR.$CORE->data['activeTheme']['ENCRYPTED_DIR'].'/'.$url;
	}
	function define_css_base_url($url)
	{
		$CORE	=	Controller::instance();
		$CORE->file->css_url	=	$url;
	}
	function define_js_base_url($url)
	{
		$CORE	=	Controller::instance();
		$CORE->file->js_url		=	$url;
	}
	function js_push_if_not_exists($url,$temporaryLocation)
	{
		$CORE	=	Controller::instance();
		$CORE->file->js_push_if_not_exists($url,$temporaryLocation);
	}
	function theme_cpush($url) // theme_css_push_if_not_exists
	{
		$CORE		=	Controller::instance();
		return css_push_if_not_exists(theme_assets_url($url),$CORE->url->main_url());
	}
	function theme_jpush($url)
	{
		$CORE		=	Controller::instance();
		return js_push_if_not_exists(theme_assets_url($url),$CORE->url->main_url());
	}
	function css_push_if_not_exists($url,$temporaryLocation)
	{
		$CORE	=	Controller::instance();	
		$CORE->file->css_push_if_not_exists($url,$temporaryLocation);
	}
	function site_datetime()
	{
		$CORE	=	Controller::instance();
		return $CORE->tendoo->datetime();
	}
	function site_options()
	{
		$CORE	=	Controller::instance();
		return $CORE->tendoo->getOptions();
	}
	function site_theme()
	{
		$CORE	=	Controller::instance();
		return $CORE->tendoo->getSiteTheme();
	}
	/**
	*	current_user
	*	Renvoi les informations à propos de l'utilisateur actuel.
	**/
	function current_user($input)
	{
		$CORE	=	Controller::instance();
		if(isset($CORE->users_global))
		{
			switch(strtolower($input))
			{
				case "menu"	:
				return $CORE->users_global->getUserMenu();
				break;
				case "isconnected"	:
				return $CORE->users_global->isConnected();
				break;
				case "isadmin"	:
				return $CORE->users_global->isAdmin();
				break;
				case "issuperadmin"	:
				return $CORE->users_global->isAdmin();
				break;
				case "margin"	:
				return $CORE->users_global->isConnected() ? 'style="margin-top:30px"' : '';
				break;
				default :
				return $CORE->users_global->current($input);
				break;
			}
		}
	}