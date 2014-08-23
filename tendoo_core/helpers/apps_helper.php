<?php
	/**
	*	include_if_file_exists() : 
	**/
	function include_if_file_exists( $path ){
		if( is_file( $path ) ){
			include_once( $path );
		}
	}
	/**
	*	bind_event( 'event' , 'do' )
	**/
	function bind_event( $event , $do){ 
		$saved_events				=	get_core_vars( 'get_core_events' ) ? get_core_vars( 'get_core_events' ) : array();
		$current_event			 	=	return_if_array_key_exists( $event , $saved_events );
		if( !$current_event ) : $saved_events[ $event ] = array() ; endif;
		$saved_events[ $event ][]	= 	$do;
		return set_core_vars( 'get_core_events' , $saved_events );
	}
	/**
	*	trigger_events() : déclenche les évenements attachés
	**/
	function trigger_events( $events , $params = array() ){
		if( $current_events = has_events( $events ) )
		{
			$result;
			foreach( $current_events as $event )
			{
				if( is_string( $event ) )
				{
					if( function_exists( $event ) )
					{
						$result	=	$event( $params );
					}
				}
				else if( is_array( $event ) )
				{
					if( is_object( $event[0] ) )
					{
						if( method_exists( $event[0] , $event[1] ) )
						{
							$result	= $event[0]->$event[1]( $params );
						}
					}
				}
			}
			return ( $result != null ) ? $result : false;
		}
		return false;
	}
	function has_events( $events ){
		$events_binded		=	get_core_vars( 'get_core_events' );
		$current_events		=	return_if_array_key_exists( $events , $events_binded );
		if( is_array( $current_events ) )
		{
			return $current_events;
		}
		return false;
	};
	/**
	*	bootstrap_pagination_parser, génère une liste de lien au format HTML de bootstrap.
	**/
	function bootstrap_pagination_parser($array,$additionnal_class = "pagination-sm m-t-none m-b-none")
	{
		?>

<ul class="pagination <?php echo $additionnal_class;?>">
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
			if(true == ($module	=	get_core_vars( 'opened_module' )))
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
			if(true == ($page	=	get_core_vars('page')))
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
		if(SCRIPT_CONTEXT == 'ADMIN')
		{
			if(get_core_vars('opened_module'))
			{
				$module	=	get_core_vars('opened_module');
				if(is_array($segments))
				{
					$baseSegments	=	array(
					'admin','open','modules',$module[0]['ID']);
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
					'admin','open','modules',$module[0]['ID']);
					// Nous ajoutons le segment aux segments de base
					array_push($baseSegments,$segments);
					$instance->url->redirect($baseSegments);
					return $instance->url->site_url($baseSegments);
				}
			}
		}
		else
		{
			if(get_core_vars('module'))
			{
				$page	=	get_core_vars('page');
				if(is_array($segments))
				{
					$baseSegments	=	array($page[0]['PAGE_CNAME']);
					// Nous ajoutons les segments aux segments de base
					foreach($segments as $seg)
					{
						array_push($baseSegments,$seg);
					}
					$instance->url->redirect($baseSegments);
				}
				else
				{
					$baseSegments	=	array($page[0]['PAGE_CNAME']);
					// Nous ajoutons le segment aux segments de base
					array_push($baseSegments,$segments);
					$instance->url->redirect($baseSegments);
					return $instance->url->site_url($baseSegments);
				}
			}
		}
		return false;
	}
	function theme_assets_url($url)
	{
		$activeTheme	=	get_core_vars('activeTheme');
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
		if($specified_key == null)
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
				return $instance->users_global->isSuperAdmin();
				break;
				case "show_menu"	:
				return $instance->users_global->setMenuStatus('show_menu');
				break;
				case "hide_menu"	:
				return $instance->users_global->setMenuStatus('hide_menu');
				break;
				case "top_margin"	:
				return $instance->users_global->isConnected() ? 'style="margin-top:38px"' : '';
				break;
				case "top_offset"	:	
				return $instance->users_global->isConnected() ? 'style="top:38px"' : '';
				break;
				default :
					if(method_exists($instance->users_global,$input))
					{
						return $instance->users_global->$input();
					}
					else
					{
						return $instance->users_global->current($input);	
					}
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
			echo $instance->file->css_load();
		}
		else if($element == 'js')
		{
			echo $instance->file->js_load();
		}
		else if($element == 'notice')
		{
			echo notice('parse');
		}
		else if($element == 'headers') // must be added to each theme head
		{
			// Including new UserBar css
			css_push_if_not_exists('tendoo_userbar',$instance->url->main_url().'/tendoo_assets/css/');
			// Ouputing CSS and JS
			output('css');
			output('js');
		}
		else if($element == 'headers_css') // must be added to each theme head
		{
			// Including new UserBar css
			css_push_if_not_exists('tendoo_userbar',$instance->url->main_url().'/tendoo_assets/css/');
			// Ouputing CSS and JS
			output('css');
		}
		else if($element == 'footers')
		{
			
		}
		else
		{
			if(function_exists('ouput_'.$element))
			{
				eval('ouput_'.$element.'();');
			}
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
	*	set_core_vars
	*	Ajoute une valeur au tableau du system
	**/
	function set_core_vars($key,$value,$access = 'writable')
	{
		$instance	=	get_instance();
		return $instance->set_core_vars($key,$value,$access);
	}
	/**
	*	get_core_vars()
	*	Recupère un champ sur le tableau du système.
	**/
	function get_core_vars($key = null)
	{
		$instance	=	get_instance();
		if($key == null)
		{
			$simple_values	=	array();
			// valeur plus accessibilité (read_only ou writable)
			foreach($instance->get_core_vars() as $key	=>	$vars)
			{
				$simple_values[ $key ] =	$vars[0];
			}
			return $simple_values;
		}
		else
		{
			$instance	=	get_instance();
			return $instance->get_core_vars($key);
		}
	}
	/**
	*	push_core_vars : ajoute une nouvelle valeur à un tableau déjà existant dans le tableau du noyau
	**/
	function push_core_vars( $key , $var , $value = null ){
		$vars	=	get_core_vars( $key , $var );
		if( $vars ){
			if( $value != null ){
				$vars[ $var ] =	$value;
				return set_core_vars( $key , $vars );
			}
		};
		return false;
	};
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
			case "declared_shortcuts"	:
				return get_declared_shortcuts();
			break;				
		}
	}
	/**
	*	set_options()
	**/
	function set_options($array,$process = "from_admin_interface") // Modifie les options du site
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
	/**
	*	declare_notices : enregistre des nofication dans le système pour l'éxécution du script en cours.
	**/
	function declare_notice($key,$notice_text)
	{
		return declare_notices($key,$notice_text);
	}
	function declare_notices($array,$notice_text) // add to doc new tendoo 1.2
	{
		// Utilisation de la variable globale
		global $NOTICE_SUPER_ARRAY;
		if(!is_array($array))
		{
			$NOTICE_SUPER_ARRAY[$array]	=	$notice_text;
		}
		else
		{
			foreach($array as $k => $v)
			{
				$NOTICE_SUPER_ARRAY[$k]	=	$v;
			}
		}
	}	
	/**
	*	declare_shortcut
	**/
	function declare_shortcut($text,$link,$mod_namespace = '',$mod_name = '')
	{
		if(is_array($text))
		{
			if(array_key_exists('text',$text) &&
			array_key_exists('link',$text) &&
			array_key_exists('mod_namespace',$text) &&
			array_key_exists('mod_name',$text))
			{
				return declare_shortcut($text['text'],$text['link'],$text['mod_namespace'],$text['mod_name']);
			}
			return false;
		}
		else
		{
			$declared	=	get_core_vars('declared_shortcuts') ? get_core_vars('declared_shortcuts') : array();
			$shortcut	=	array(
				'link'				=>	$link,
				'text'				=>	$text,
				'mod_namespace'		=>	$mod_namespace,
				'mod_name'			=>	$mod_name
			);
			array_push($declared,$shortcut);
			return set_core_vars('declared_shortcuts',$declared);
		}
	}
	function declare_shortcuts($text,$link,$mod_namespace = '',$mod_name = '')
	{
		return declare_shorcut($text,$link,$mod_namespace,$mod_name);
	}
	function get_declared_shortcuts()
	{
		return get_core_vars('declared_shortcuts');
	}
	/**
	*	get_module()
	**/
	function get_modules($element = 'all',$filter = 'filter_id',$where = '', $value = '')
	{
		// Must Specify a valid filter
		if(!in_array($filter,array('filter_id','filter_namespace','filter_nothing')))
		{
			return false;
		}
		$DB	=	get_db();
		if($where != '' && $value != '')
		{
			$DB->where($where,$value);
		}
		if($filter == 'filter_id')
		{
			$DB->where('ID',$element);
		}
		else if($filter == 'filter_namespace')
		{
			$DB->where('NAMESPACE',$element);
		}
		$query	=	$DB->get('tendoo_modules');
		$result	=	$query->result_array();
		$result[0]['URI_PATH']	=	MODULES_DIR.$result[0]['ENCRYPTED_DIR'].'/';
		$result[0]['URL_PATH']	=	get_instance()->url->main_url().MODULES_DIR.$result[0]['ENCRYPTED_DIR'].'/';
		return $result;
	}
	/**
	*	get_themes()
	**/
	function get_themes( $element = 'all', $filter = 'filter_id' , $where = '', $value = '')
	{
		// Must Specify a valid filter
		if(!in_array($filter,array('filter_id','filter_namespace','filter_active')))
		{
			return false;
		}
		$DB	=	get_db();
		if($where != '' && $value != '')
		{
			$DB->where($where,$value);
		}
		if($filter == 'filter_id')
		{
			$DB->where('ID',$element);
		}
		else if($filter == 'filter_namespace')
		{
			$DB->where('NAMESPACE',$element);
		}
		else if($filter == 'filter_active')
		{
			$DB->where('ACTIVATED',"TRUE");
		}
		$query	=	$DB->get('tendoo_themes');
		return $query->result_array();
	}
	/**
	*	does_active_theme_support : vérifie la compatibilité du thème actif, avec les applications insallés, affiche une
	*	alerte dans le cas contraire.
	*	"activeTheme" est déclaré sur tendoo_core/controllers/admin.php ::__construct()
	* 	"activeTheme" est déclaré sur tendoo_core/Systeme.Core.php ::boot()
	**/
	function does_active_theme_support($APP)
	{
		$active_theme	=	get_core_vars( 'activeTheme' );

		if( $active_theme )	{
			$app_supported	=	return_if_array_key_exists( 'APPS_COMPATIBILITY' , $active_theme );			
			if( is_array( $app_supported ) )
			{
				if( in_array( $APP , $app_supported ) )
				{
					return true;
				}
			}
			// Si la valeur renvoyé n'est pas un booléen, alors le thème sera utilisé pour afficher l'alerte.
			return $active_theme;
		}
		
		return false;
	}
	/**
	*	set_app_compatibility() : définit une compatibilité pour un thème.
	**/
	function active_theme_compatibility( $APP ){
		if( is_array( $APP ) )
		{
			foreach( $APP as $_app )
			{
				active_theme_compatibility( $_app );
			}
			return true;
		}
		else
		{
			$apps_supported	=	get_active_theme_vars( 'APPS_COMPATIBILITY' )
				? get_active_theme_vars( 'APPS_COMPATIBILITY' ) : array();
				$apps_supported[]	=	$APP;			
			return set_active_theme_vars( 'APPS_COMPATIBILITY' , $apps_supported );
		}
		return false;
	}
	function set_active_theme_vars( $key , $value ){
		$active_theme	=	get_core_vars( 'activeTheme' );
		if( $active_theme ) {
			$active_theme[ $key ] =	$value;
			return set_core_vars( 'activeTheme' , $active_theme );
		}
		return false;
	}
	function get_active_theme_vars( $key = null ){
		$active_theme	=	get_core_vars( 'activeTheme' );
		if( $key == null ) {
			return $active_theme;
		}
		return return_if_array_key_exists( $key , $active_theme );
	}
	/**
	*	declare_admin_widget()
	*	Autorise la déclaration des widgets qui seront affiché à l'accueil du tableau de bord via tepas.
	**/
	function declare_admin_widget($widget,$widget_form = "normal_form") // allowed form collapsible_form, normal_form...
	{	
		$process	=	true;
		$widget['widget_form']	=	$widget_form;
		foreach(array('module_namespace','widget_namespace','widget_title','widget_description','widget_content') as $keys)
		{
			if(!in_array($keys,array_keys($widget)))
			{
				$process	=	false;
			}
		}
		if($process == true)
		{
			if(!get_core_vars('admin_widgets'))
			{
				set_core_vars('admin_widgets',array());
			}
			// Lorsque le control de l'accéssibilité à une action a échoué, le widget n'est pas chargé
			if(array_key_exists('action_control',$widget))
			{
				if($widget['action_control'] !== true)
				{
					return false;
				}
			}
			$declared_admin_widgets	=	get_core_vars('admin_widgets');
			array_push($declared_admin_widgets,$widget);
			return set_core_vars('admin_widgets',$declared_admin_widgets);
		}
		return false;
	}
	function get_declared_admin_widgets()
	{
		return get_core_vars('admin_widgets');
	}
	function ouput_admin_widgets()
	{
		function __get_sections_widgets($admin_widgets, $section = 0)
		{
			$widget				=	array();
			$widget[0]			=	get_data('widget_0', 'from_user_options' );
			$widget[1]			=	get_data('widget_1', 'from_user_options' );
			$widget[2]			=	get_data('widget_2', 'from_user_options' );
			// var_dump($widget);
			// Uniquement si le widget est disponible, on l'ajoute
			if(array_key_exists($section,$widget))
			{
				if($widget[$section] != null)
				{
					// Parcours de l'ordre des widgets
					for($i=0; $i < count($widget[$section]); $i++)
					{
						foreach($admin_widgets as $value)
						{
							$widget_id	=	$value['widget_namespace'].'/'.$value['module_namespace'];
							// Verifie si le widget existe ou s'il vient d'être ajouté
							if($section == 1)
							{
								$new_widget_exists	=	FALSE;
								foreach($widget as $_s)
								{
									if(in_array($widget_id,$_s))
									{
										// Si le widget existe, déclare qu'il existe, donc il ne faut pas l'ajouter en plus
										$new_widget_exists	=	TRUE;
									}
								}
								// On ajoute le nouveau widget par défaut dans la colonne 1
								if($new_widget_exists == FALSE)
								{
									array_push($widget[$section],$widget_id);
								}
							}
							if($widget_id	==	$widget[$section][$i])
							{
								// Filtre, ne seront affiché que ceux qui sont activés.
								if(admin_widget_is_enabled($value['widget_namespace'].'/'.$value['module_namespace']))
								{
									
									?>
									<div 
										widget_id="<?php echo $value['widget_namespace'];?>/<?php echo $value['module_namespace'];?>"
									>
										<?php 
										if($value['widget_form']	==	"normal_form") // ideas : collapsible_form
										{
											echo $value[ 'widget_content' ];
										}
										?>
									</div>
									<?php
			
								}
							}
							// For new Admin Widget
						}
					}
				}
			}
		}
		// 5 colonnes par défaut
		$admin_widgets	=	get_core_vars( 'admin_widgets' );
		if(is_array($admin_widgets))
		{
			$disabled_widgets	=	json_decode( current_user( 'ADMIN_WIDGETS_DISABLED' ) ,  true );
			if( !get_data('widget_0', 'from_user_options' ) && !get_data('widget_1', 'from_user_options' ) && !get_data('widget_2', 'from_user_options' ) ){
				?>
                <div class="col-lg-12">
                <?php
				echo tendoo_info( 'Aucun widget n\'a été activé depuis les <strong><a href="'.get_instance()->url->site_url( array( 'admin' , 'setting' ) ).'">paramètres</a></strong>' );
				?>
                </div>
                <?php
			} else {
				for($i = 0;$i < 3;$i++)
				{
					if($i == 0)
					{
				?>
				<div class="col-lg-4 draggable_widgets">
					<?php echo __get_sections_widgets($admin_widgets,0);?>
				</div>
				<?php
					}
					else if($i == 1)
					{
						?>
				<div class="col-lg-5 draggable_widgets">
					<?php echo __get_sections_widgets($admin_widgets,1);?>
				</div>
				<?php
					}
					else
					{
						?>
				<div class="col-lg-3 draggable_widgets">
					<?php echo __get_sections_widgets($admin_widgets,2);?>
				</div>
						<?Php
					}
				}
				?>
				<script>
					$(document).ready(function(){
						function __doSort(event,ui){
							ui.item.closest(".draggable_widgets").parent().find('.draggable_widgets').each(function(){
								$(this).children(function(){
									alert($(this).attr('widget_id'));
								})
							});
							var tab		=	new Array;
							var section	=	0;
							var newSet	=	{};
							$('.draggable_widgets').each(function(){
								if(typeof tab[section] == 'undefined')
								{
									tab[section] = new Array;
								}
								$(this).find('div[widget_id]').each(function(){
									tab[section].push($(this).attr('widget_id'));
								});
								// Saving Each Fields	
								_.extend(newSet,_.object([ "widget_"+section ],[ tab [ section ] ]));
								section++;
							});
							$.ajax(tendoo.url.site_url('admin/ajax/resetUserWidgetInterface'),{
								dataType	:	'json',
								type		:	'POST',
								data		:	newSet
							});
						}
						var actionAllower	=	{};
						$('.draggable_widgets').sortable({
							grid			:	[ 10 , 10 ],
							connectWith		: 	".draggable_widgets",
							items			:	"div[widget_id]",
							placeholder		:	"widget-placeholder",
							forceHelperSize	:	false,
							// zIndex			:	tendoo.zIndex.draggable,
							forcePlaceholderSize	:	true,
							stop			:	function(event, ui){
								__doSort(event, ui);
							},
							delay			: 	150 
						});
					});
                </script>
				<?php
				
			}
		}
		return false;
	}
	function admin_widget_is_enabled($widget_id) // "widget_namespace_module_namespace"
	{
		//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		$userDisabledWidget	=	json_decode(current_user('ADMIN_WIDGETS_DISABLED'),true);
		$userDisabledWidget	=	is_array($userDisabledWidget) ? $userDisabledWidget : array();
		//-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		if(in_array($widget_id,$userDisabledWidget))
		{
			return false;
		}
		return true;
	}
	/**
	*	Engage passive Scripting
	**/
	function engage_tepas()
	{
		if(!defined('TEPAS_CALLED'))
		{
			define( 'TEPAS_CALLED' , 'TRUE');
			$tos_module_enabled	=	get_modules( 'all' , 'filter_nothing' , 'HAS_PASSIVE_SCRIPTING' , 1 );
			if($tos_module_enabled)
			{
				foreach($tos_module_enabled as $m)
				{
					$tepas_file	=	MODULES_DIR.$m['ENCRYPTED_DIR'].'/tepas.php';
					if(is_file($tepas_file))
					{
						include_once($tepas_file);
						if(class_exists($m['NAMESPACE'].'_tepas_class'))
						{
							eval('new '.$m['NAMESPACE'].'_tepas_class($m);');
						}
					}
				}
			}
			// Tepas enabled only on active theme
			$active_theme		=	get_themes( 'all' , 'filter_active' );
			if( is_array( $active_theme ) && count( $active_theme ) >  0 ) { // Si le thème existe
				$tepas_file			=	THEMES_DIR . $active_theme[0][ 'ENCRYPTED_DIR' ] . '/tepas.php';
				if( is_file( $tepas_file ) )
				{
					include_once( $tepas_file );
					if( class_exists( $active_theme[0][ 'NAMESPACE' ] . '_theme_tepas_class' ) )
					{
						eval( 'new '. $active_theme[0][ 'NAMESPACE' ] . '_theme_tepas_class($active_theme);' );
					}
				}
			}
		}
	}
	/**
	*	get_data()
	**/
	function get_data($key,$source	=	"from_options") // to doc
	{
		if($source	==	"from_options")
		{
			$options			=	get_options();
			$decoded			=	json_decode($options[0][ 'LIGHT_DATA' ],TRUE);
			if(!in_array($decoded,array(null,false),true))
			{
				if(array_key_exists($key,$decoded))
				{
					return $decoded[ $key ];
				}
			}
		}
		else if($source	==	"from_user_options")
		{
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			get_instance()->users_global->refreshUser();
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$decoded			=	json_decode( current_user( 'LIGHT_DATA' ), TRUE );
			if(!in_array($decoded,array(null,false),true))
			{
				if(array_key_exists($key,$decoded))
				{
					return $decoded[ $key ];
				}
			}
		}
		return false;
	}
	/**
	*	set_data()
	*	futur : ajouter un timestamp à une clé et leur donner uen valeur d'un mois.
	**/
	function set_data($key,$value,$source	=	 "from_options")
	{
		if($source	==	"from_options")
		{
			$options		=	get_options();
			$decoded		=	json_decode($options[0][ 'LIGHT_DATA' ],TRUE);
			$light_array	=	array();
			if(!in_array($decoded,array(null,false),true))
			{
				$light_array	=	 $decoded;
			}
			$light_array[ $key ] 	=	$value;
			return set_options(array(
				'LIGHT_DATA' =>	json_encode($light_array, JSON_FORCE_OBJECT)
			));
		}
		else if($source	==	"from_user_options")
		{
			// -=-=-=-=
			get_instance()->users_global->refreshUser();
			// -=-=-=-=
			$userOptions	=	json_decode(current_user( 'LIGHT_DATA' ),TRUE);
			if(in_array($userOptions,array(null,false),true))
			{
				$userOptions	=	array();
			}
			$userOptions[ $key ]	=	 $value;
			get_instance()->users_global->setUserElement( 'LIGHT_DATA' , json_encode( $userOptions , JSON_FORCE_OBJECT ) );
		}
	}
	/**
	*	unset_data()
	**/
	function unset_data($key, $source	=	"from_options")
	{
		if($source	==	"from_options")
		{
			$options		=	get_options();
			$decoded		=	json_decode($options[0][ 'LIGHT_DATA' ],TRUE);
			if(!in_array($decoded,array(null,false),true))
			{
				if(array_key_exists($key,$decoded))
				{
					unset($decoded[ $key ]);
				}
			}
			return set_options(array(
				'LIGHT_DATA' =>	json_encode($decoded)
			));
		}
		else if($source	==	"from_user_options")
		{
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
				get_instance()->users_global->refreshUser();
			// -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$userOptions	=	json_decode(current_user( 'LIGHT_DATA' ),TRUE);
			if(!in_array($userOptions,array(null,false),true))
			{
				if(array_key_exists( $key , $userOptions ))
				{
					unset( $userOptions[ $key ] );
				}
			}
			get_instance()->users_global->setUserElement( "LIGHT_DATA" , json_encode($userOptions, JSON_FORCE_OBJECT) );
		}
	}
	/**
	*	set_admin_menu
	**/
	function setup_admin_left_menu( $title , $icon ){
		return set_core_vars( 'admin_left_menu' , array(
			'text'		=>	$title,
			'icon'		=>	$icon
		) );
	}
	function add_admin_left_menu( $title , $link ){
		$saved_menus	=	get_core_vars( 'admin_left_menus' ) ? get_core_vars( 'admin_left_menus' ) : array();
		$saved_menus[]	=	array(
			'text'		=>	$title,
			'link'		=>	$link
		);
		set_core_vars( 'admin_left_menus' , $saved_menus );
	};
	function get_admin_left_menus(){
		$saved_menu			=		get_core_vars( 'admin_left_menus' );
		$left_menu_config	=		get_core_vars( 'admin_left_menu' );
		if( $left_menu_config )
		{
		?>
        <li class="dropdown-submenu">
        	<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown">
            	<i class="fa fa-<?php echo $left_menu_config[ 'icon' ];?>"></i>
				<?php echo $left_menu_config[ 'text' ];?>
			</a>
            <?php if(is_array( $saved_menu ) ) : ?>
            <ul class="dropdown-menu">
            	<?php foreach( $saved_menu as $menu ){ ?>
					<li><a href="<?php echo $menu[ 'link' ];?>"> <?php echo $menu[ 'text' ];?></a></li>
                <?php }?>
            </ul>
            <?php endif;?>
        </li>
        <?php
		}
	}
	/**
	*	declare_api( $api_namespace , $callback_api )
	* 	Les API ne sont définie qu'une seule fois !!
	**/
	function declare_api( $api_namespace, $human_name , $callback_api ){
		$declared_api	=	get_core_vars( 'api_declared' ) ? get_core_vars( 'api_declared' ) : array();
		if( !return_if_array_key_exists( $api_namespace , $declared_api ) ){
			$declared_api[ $api_namespace ] = array(
				'callback'		=>	$callback_api ,
				'human_name'	=>	$human_name,
				'namespace'		=>	$api_namespace
			); // CallBack API cant be a function declared on public context on array with object and method
			return set_core_vars( 'api_declared' , $declared_api );
		}
		return false;
	}
	/**
	*	Return Declared API
	**/
	function get_apis( $namespace = null ){
		if( $namespace != null ){
			return return_if_array_key_exists( $namespace , get_core_vars( 'api_declared' ) );
		} else if ( $namespace == null ){
			return get_core_vars( 'api_declared' );
		}	
	};
 