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
		$instance	=	get_instance();
		$result	=	$instance->tendoo->doPaginate($ContentPerPage,$TotalContent,$CurrentPage,$BaseUrl);
		if($result[0] == 'page404'): $instance->url->redirect($RedirectUrl);endif;
		return $result;
	}
	/**
	*	module assets url, renvoi le chemin d'accès vers le dossier du module actif (actuellement ouvert depuis l'interface d'admininstration), à utiliser uniquement dans l'environnement du module.
	**/
	function module_assets_url($segments)
	{
		$instance	=	get_instance();
		if(isset($instance->data))
		{
			if(array_key_exists('module',$instance->data))
			{
				if(is_array($segments))
				{
					return $instance->url->main_url().MODULES_DIR.$instance->data['module'][0]['ENCRYPTED_DIR'].'/'.$instance->url->array2Url($segments);
				}
				else
				{
					return $instance->url->main_url().MODULES_DIR.$instance->data['module'][0]['ENCRYPTED_DIR'].'/'.$segments;
				}
			}
		}
		return false;
	}
	/**
	*	module_include('module_namespace','path');
	*	utilise la méthode include_once pour un fichier contenu dans le dossier du module dont l'espace nom est fourni comme premier paramètre.
	**/
	function module_include($mod_namespace,$path)
	{
		$instance	=	get_instance();
		if(isset($instance->tendoo_admin))
		{
			$mod	=	$instance->tendoo_admin->getSpeModuleByNamespace($mod_namespace);
			if($mod)
			{
				include_once(MODULES_DIR.$mod[0]['ENCRYPTED_DIR'].'/'.$mod_namespace);
			}
		}
		return false;
	}
	/**
	*	Module action
	*	Vérifie l'accès à une action d'un module pour le privilège en cours (Celui utilisé par l'utilisateur courant, voir "current_user").
	**/
	function module_action($mod_namespace,$mod_action)
	{
		$instance	=	get_instance();
		if(SCRIPT_CONTEXT	== 	'ADMIN')
		{
			return $instance->tendoo_admin->actionAccess($mod_action,$mod_namespace);
		}
		return false;
	}
	/**
	*		module_action_location
	*	Opère redirection lorsqu'une action n'est pas autorisé au privilège en cours.
	*	Le privilège en cause est celui actuellement connecté voir "current_user"
	**/
	function module_action_location($mod_namespace,$mod_action,$segment_location)
	{
		if(!module_action($mod_namespace,$mod_action))
		{
			module_location($segment_location);
		}
	}
/*
	Tendoo 0.9.8 Only
	
	Facilite l'utilisation des ressources sans nécessairement avoir besoin d'utiliser l'objet get_instance();
	module_...()
	module_url()
		Renvoie l'url du module actuellement en cours d'exécution. Fait usage des méthodes $this->instance->url... et du tableau $this->data;
*/
	
	function module_url($segments)
	{
		$instance	=	get_instance();
		if(SCRIPT_CONTEXT == 'ADMIN')
		{
			if(true == ($module	=	get_core_array('module')))
			{
				if(is_array($segments))
				{
					return $instance->url->site_url('admin/open/modules/'.$module[0]['ID'].'/'.$instance->url->array2Url($segments));
				}
				else
				{
					return $instance->url->site_url('admin/open/modules/'.$module[0]['ID'].'/'.$segments);
				}
			}
		}
		else
		{
			if(true == ($page	=	get_core_array('page')))
			{
				if(is_array($segments))
				{
					return $instance->url->site_url($page[0]['PAGE_CNAME'].'/'.$instance->url->array2Url($segments));
				}
				else
				{
					return $instance->url->site_url($page[0]['PAGE_CNAME'].'/'.$segments);
				}
			}
		}
		return false;
	}
	function module_location($segments)
	{
		$instance	=	get_instance();
		if(isset($instance->data))
		{
			if(SCRIPT_CONTEXT == 'ADMIN')
			{
				if(array_key_exists('module',$instance->data))
				{
					if(is_array($segments))
					{
						$baseSegments	=	array(
						'admin','open','modules',$instance->data['module'][0]['ID']);
						// Nous ajoutons les segments aux segments de base
						foreach($segments as $seg)
						{
							array_push($baseSegments,$seg);
						}
						$instance->url->redirect($baseSegments);
					}
					else
					{
						$baseSegments	=	array(
						'admin','open','modules',$instance->data['module'][0]['ID']);
						// Nous ajoutons le segment aux segments de base
						array_push($baseSegments,$segments);
						$instance->url->redirect($baseSegments);
						return $instance->url->site_url($baseSegments);
					}
				}
			}
			else
			{
				if(array_key_exists('module',$instance->data))
				{
					if(is_array($segments))
					{
						$baseSegments	=	array($instance->data['page'][0]['PAGE_CNAME']);
						// Nous ajoutons les segments aux segments de base
						foreach($segments as $seg)
						{
							array_push($baseSegments,$seg);
						}
						$instance->url->redirect($baseSegments);
					}
					else
					{
						$baseSegments	=	array($instance->data['page'][0]['PAGE_CNAME']);
						// Nous ajoutons le segment aux segments de base
						array_push($baseSegments,$segments);
						$instance->url->redirect($baseSegments);
						return $instance->url->site_url($baseSegments);
					}
				}
			}
		}
		return false;
	}
	function theme_assets_url($url)
	{
		$activeTheme	=	get_core_array('activeTheme');
		if(is_array($url))	
			return THEMES_DIR.$activeTheme['ENCRYPTED_DIR'].'/'.$instance->url->array2Url($url);
		else 
			return THEMES_DIR.$activeTheme['ENCRYPTED_DIR'].'/'.$url;
	}
	function define_css_base_url($url)
	{
		$instance	=	get_instance();
		$instance->file->css_url	=	$url;
	}
	function define_js_base_url($url)
	{
		$instance	=	get_instance();
		$instance->file->js_url		=	$url;
	}
	function js_push_if_not_exists($url,$temporaryLocation = null)
	{
		$instance	=	get_instance();
		$instance->file->js_push_if_not_exists($url,$temporaryLocation);
	}
	function theme_cpush($url) // theme_css_push_if_not_exists
	{
		$instance		=	get_instance();
		return css_push_if_not_exists(theme_assets_url($url),$instance->url->main_url());
	}
	function theme_jpush($url)
	{
		$instance		=	get_instance();
		return js_push_if_not_exists(theme_assets_url($url),$instance->url->main_url());
	}
	function theme_dir()
	{
		$instance	=	get_instance();
		return $instance->main_url().THEMES_DIR.$instance->data['activeTheme']['ENCRYPTED_DIR'];
	}
	/**
	*	theme_include() include_once() en utilisant le dossier du thème dont l'interface est visité via open/themes/xx où xx est l'espace nom d'un thème valide.
	**/
	function theme_include($file_path)
	{
		$instance	=	get_instance();
		include_once(THEMES_DIR.$instance->data['theme'][0]['ENCRYPTED_DIR'].'/'.$file_path);
	}	
	/**
	*	theme_view() méthode view en utilisant le répertoire
	**/
	function theme_view($file_path,$data,$doAction = 'showDirectly')
	{
		$instance	=	get_instance();
		if($doAction == 'showDirectly')
		{
			$instance->load->view($file_path,$data,false,true);
		}
		else if($doAction == 'return')
		{
			$instance->load->view($file_path,$data,true,true);
		}
	}
	function css_push_if_not_exists($url,$temporaryLocation = null)
	{
		$instance	=	get_instance();	
		$instance->file->css_push_if_not_exists($url,$temporaryLocation);
	}
	function site_datetime()
	{
		$instance	=	get_instance();
		return $instance->date->datetime();
	}
	function site_options($specified_key = null)
	{
		$instance	=	get_instance();
		if($specified_key != null)
		{
			$options	=	$instance->options->get();
			return $options[0];
		}
		else
		{
			$options	=	$instance->options->get();			
			if(array_key_exists($specified_key,$options[0]))
			{
				return $options[0][$specified_key];
			}
			return false;
		}
	}
	function site_theme()
	{
		$instance	=	get_instance();
		return $instance->tendoo->getSiteTheme();
	}
	/**
	*	current_user
	*	Renvoi les informations à propos de l'utilisateur actuel.
	**/
	function current_user($input)
	{
		$instance	=	get_instance();
		if(isset($instance->users_global))
		{
			switch(strtolower($input))
			{
				case "menu"	:
				return $instance->users_global->getUserMenu();
				break;
				case "isconnected"	:
				return $instance->users_global->isConnected();
				break;
				case "isadmin"	:
				return $instance->users_global->isAdmin();
				break;
				case "issuperadmin"	:
				return $instance->users_global->isAdmin();
				break;
				case "show_menu"	:
				return $instance->users_global->setMenuStatus('show_menu');
				break;
				case "hide_menu"	:
				return $instance->users_global->setMenuStatus('hide_menu');
				break;
				case "margin"	:
				return $instance->users_global->isConnected() ? 'style="margin-top:30px"' : '';
				break;
				default :
				return $instance->users_global->current($input);
				break;
			}
		}
	}
	/**
	*
	**/
	function output($element) // add to doc
	{
		$instance	=	get_instance();
		if($element == 'css')
		{
			return $instance->file->css_load();
		}
		else if($element == 'js')
		{
			return $instance->file->js_load();
		}
		else if($element == 'notice')
		{
			return notice('parse');
		}
	}
	/**
	*	notice, classe de gestion des notifications
	**/
	function notice($action,$params = array())
	{
		$instance	=	get_instance();
		switch($action)
		{
			case 'push' : 
				$instance->notice->push_notice($params);
			break;
			case 'parse' : 
				$instance->notice->parse_notice();
			break;
		}
	}
	/**
	*	db() return current mysql connexion
	**/
	function get_db() // add to doc
	{
		global $database;
		return $database;
	}
	function set_db($db) // add to doc
	{
		global $database;
		$database	=	$db;
	}
	function get_instance() // add to doc
	{
		return instance::instance();
	}
	/**
	*	set_page() :: Définir des informations pour la page
	**/
	function set_page($key,$value) // add to doc
	{
		if(in_array($key,array('title','description','keywords')))
		{
			$instance	=	get_instance();
			$instance->$key	=	$value;
		}
	}
	/**
	*	get_page('key') 
	*	renvoie une valeur définit avec set_page() 
	**/
	function get_page($key) // add to doc
	{
		if(in_array($key,array('title','description','keywords')))
		{
			$instance	=	get_instance();
			return $instance->$key;
		}
	}
	/**
	*	update_core_array
	*	Ajoute une valeur au tableau du system
	**/
	function update_core_array($key,$value)
	{
		$instance	=	get_instance();
		return $instance->update_core_array($key,$value);
	}
	/**
	*	get_core_array()
	*	Recupère un champ sur le tableau du système.
	**/
	function get_core_array($key)
	{
		$instance	=	get_instance();
		return $instance->get_core_array($key);
	}
	/**
	*	get recupère des informations sur le système.
	**/
	function get($key) // add to doc
	{
		$instance	=	get_instance();
		switch($key)
		{
			case "core_version"	:
				return $instance->version();
			break;
			case "core_id"	:
				return $instance->id();
			break;
		}
	}
	/**
	*	set_options()
	**/
	function set_options($array,$process = "from_admin_internface") // Modifie les options du site
	{
		if(in_array($process,array("from_admin_interface","from_install_interface")))
		{
			$instance	=	get_instance();
			return $instance->options->set($array,$process);
		}
	}
	/**
	*	get_options()
	**/
	function get_options()
	{
		$instance	=	get_instance();
		return $instance->options->get();
	}
