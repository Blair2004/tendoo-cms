<?php
	function core_meta_namespace( $array )
	{
		if( is_string( $array ) )
		{
			return 'meta.tendoo.org/' . $array;
		}
		else if( is_array( $array ) )
		{
			$namespace	=	'meta.tendoo.org' ;
			$final_slashes	=	'';
			foreach( $array as $value )
			{
				$final_slashes .=  '/' . $value;
			}
			return $namespace . $final_slashes;
		}
	}
	/**
	*	@var 	: string required
	*	@return : null
	*	@note : echo something if it's "echo-able". While Debug mode is enabled, it return an notice if @var
	**/
	function safe_echo( $var )
	{
		if( !is_object( $string ) && !is_object( $string ) && ! is_resource( $string ) )
		{
			echo $string;
		}
	}
	function print_array( $array , $return = FALSE )
	{
		ob_start();
		echo '<pre>';
		print_r( $array , $return );
		echo '</pre>';
		return $return ? ob_get_clean() : null;
	}
	function convert_to_array( $item )
	{
		if( !is_array( $item ) )
		{
			return array( $item );
		}
		return $item;
	}
	function force_array( $array )
	{
		if( is_array( $array ) )
		{
			return $array;
		}
		return array();
	}
	/**
	*	create_admin_menu()
	**/
	function create_admin_menu( $namespace , $position , $item )
	{
		return __create_menu( 'admin' , $namespace , $position , $item );
	}
	function __create_menu( $interface , $namespace , $position , $item )
	{
		if( in_array( $interface , array( 'admin' , 'account' ) ) ) 
		{
			$interface_menus	=	get_core_vars( $interface . '_menus' );
			if( in_array( $position , get_core_vars( $interface . '_menu_position' ) ) && in_array( $item , get_core_vars( $interface . '_menu_items' ) ) )
			{
				$interface_menus[ $item ][ $position ][ $namespace ]	=	array(); // Saving menu namespace
			}
			return set_core_vars( $interface . '_menus' , $interface_menus ); // save it to the main array;
		}
		return false;
	}
	/**
	* 	add_admin_menu()
	**/
	function add_admin_menu( $namespace , $config )
	{
		return __add_menu( 'admin' , $namespace , $config );
	}
	function __add_menu( $interface , $namespace , $config )
	{
		if( in_array( $interface , array( 'admin' , 'account' ) ) )
		{
			/*
			*	[title, href, icon] config keys
			*/
			$interface_menus	=	is_array( $array	=	get_core_vars( $interface . '_menus' ) ) ? $array : array();
			if( is_array( $interface_menus ) )
			{
				foreach( $interface_menus as $item_key	=>	$items )
				{
					if( is_array( $items ) )
					{
						foreach( $items as $item_position 	=>	$position )
						{
							if( is_array( $position ) )
							{
								foreach( $position  as $_namespace => $_config )
								{
									if( $_namespace == $namespace )
									{
										$interface_menus[ $item_key ][ $item_position ][ $_namespace ][]	=	$config;
									}
								}
							}
						}
					}
				}
			}
			// Saving Menu
			set_core_vars( $interface . '_menus' , $interface_menus );
		}
	}
	/**
	*	show_admin_menu( 'position' )
	**/
	function __show_menu( $interface , $position , $item )
	{
		if( in_array( $interface , array( 'admin' , 'account' ) ) ) 
		{
			if( in_array( $item , force_array( get_core_vars( $interface . '_menu_items' ) ) ) )
			{
				if( in_array( $position , array( 'before' , 'after' ) ) )
				{
					$get_menus		=	riake( $item , get_core_vars( $interface . '_menus' ) , array() );
					$menu_position	=	riake( $position , $get_menus , array() );
					if( is_array( $menu_position ) )
					{
						foreach( $menu_position as $namespace	=>	 $menu_list )
						{
							$first_index	=	0;
							$class	=	is_array( $menu_list ) && count( $menu_list ) > 1 ? 'dropdown-submenu' : '';
							// Check if a menu as a open submenu
							$custom_ul_style	=	'';
							$menu_status	=	'';
							foreach( $menu_list as $check )
							{
								if( riake( 'href' , $check ) == get_instance()->url->site_url() )
								{
									$custom_ul_style	= 'style="display: block;"';
									$menu_status	=	'active';
									break;
								}
							}
							?>
							<li class="<?php echo $class . ' ' . $menu_status;?>">
							<?php
							// Displaying menu and their childs
							foreach( $menu_list as $menu )
							{
								if( ( $title = riake( 'title' , $menu ) ) == true && ( $url = riake( 'href' , $menu ) ) == true )
								{
									if( $class != '' ) // means if it has child
									{
										$custom_style	=	get_instance()->url->site_url() == riake( 'href' , $menu , '#' ) ? 'style="color:#fff"' : '';
										if( $first_index == 0 ) // parent
										{
											?>
											<a <?php echo $custom_style;?> href="javascript:void(0)" class="dropdown-toggle <?php echo $menu_status;?>"> 
												<span class="pull-right auto"> <i class="fa fa-angle-down text"></i> <i class="fa fa-angle-up text-active"></i> </span>
												<i class="<?php echo riake( 'icon' , $menu , 'fa fa-star' );?>"></i> 
												<span><?php echo $title;?></span> 
											</a>
											<ul <?php echo $custom_ul_style;?> class="nav none dker">
												<li> <a <?php echo $custom_style;?> href="<?php echo riake( 'href' , $menu , '#' );?>"><?php echo riake( 'title' , $menu );?></a> </li>	
											<?php
											
										}
										else // childs menus
										{
											// inlight current page
											?>
												<li> <a <?php echo $custom_style;?> href="<?php echo riake( 'href' , $menu , '#' );?>"><?php echo riake( 'title' , $menu );?></a> </li>	
											<?php
										}
										if( $first_index == ( count( $menu_list ) - 1 ) ) // If is last item of the menu
										{
											?>
											</ul>
											<?php
										}
									}
									else // If no child exists
									{
										 ?>
										 <a href="<?php echo riake( 'href' , $menu , '#' );?>"> <i class="<?php echo riake( 'icon' , $menu , 'fa fa-star' );?>"></i> <span><?php echo riake( 'title' , $menu );?></span> </a>
										 <?php
									}
								}
								$first_index++; // upgrade index
							}
							?>
							</li>
							<?php
						}
					}
				}
			}
		}
	}
	function show_admin_menu( $position , $item )
	{
		return __show_menu( 'admin' , $position, $item );
	}
	function create_account_menu( $namespace , $position , $item )
	{
		return __create_menu( 'account' , $namespace , $position , $item );
	}
	function add_account_menu( $namespace , $config )
	{
		return __add_menu( 'account' , $namespace , $config );
	}
	function show_account_menu( $position , $item )
	{
		return __show_menu( 'account' , $position , $item );
	}
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
	function theme_assets_url($url)
	{
		$active_theme	=	get_core_vars('active_theme');
		if(is_array($url))	
			return THEMES_DIR.$active_theme['encrypted_dir'].'/'.$instance->url->array2Url($url);
		else 
			return THEMES_DIR.$active_theme['encrypted_dir'].'/'.$url;
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
		return $instance->main_url().THEMES_DIR.$instance->data['active_theme']['encrypted_dir'];
	}
	/**
	*	theme_include() include_once() en utilisant le dossier du thème dont l'interface est visité via open/themes/xx où xx est l'espace nom d'un thème valide.
	**/
	function theme_include($file_path)
	{
		$instance	=	get_instance();
		include_once(THEMES_DIR.$instance->data['theme'][0]['encrypted_dir'].'/'.$file_path);
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
	function site_theme()
	{
		$instance	=	get_instance();
		return get_themes( 'filter_active' );
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
			css_push_if_not_exists('tendoo_userbar',$instance->url->main_url().'/tendoo-assets/css/');
			// Ouputing CSS and JS
			output('css');
			output('js');
		}
		else if($element == 'headers_css') // must be added to each theme head
		{
			// Including new UserBar css
			css_push_if_not_exists('tendoo_userbar',$instance->url->main_url().'/tendoo-assets/css/');
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
	function get_db( $process = 'from_install_interface' ) // add to doc
	{
		if( $process == 'from_install_interface' ){
			global $database;
			if( !isset( $database ) ){
				$config		=	$_SESSION['db_datas'];
				$database	=	DB( $config , TRUE );
			}
			return $database;
		}
		else {
			global $database;
			return $database;
		}
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
				return (float) $instance->id();
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
	*	declare_admin_widget()
	*	Autorise la déclaration des widgets qui seront affiché à l'accueil du tableau de bord via tepas.
	**/
	function declare_admin_widget($widget,$widget_form = "normal_form") // allowed form collapsible_form, normal_form...
	{	
		$process	=	true; // Controle la déclaration d'un widget
		$widget['widget_form']	=	$widget_form;
		foreach(array_keys($widget) as $keys)
		{
			if(!in_array($keys,array('module_namespace','widget_namespace','widget_title','widget_description','widget_content','action_control','widget_form')))
			{
				$process	=	false;
			}
			else
			{
				if( riake( 'module_namespace' , $widget ) != 'system' )
				{
					// UN-app module widgets are disabled, since un-app module are also disabled on webapp mode.
					$module		=	get_modules( 'filter_namespace' , riake( 'module_namespace' , $widget ) );
					if( riake( 'handle' , $module ) != 'system' && get_core_vars( 'tendoo_mode' , 'options' , 'website' ) == 'webapp' )
					{
						$process	=	false;
					}
				}
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
			$widget[0]			=	get_meta('widget_0', 'from_user_meta' );
			$widget[1]			=	get_meta('widget_1', 'from_user_meta' );
			$widget[2]			=	get_meta('widget_2', 'from_user_meta' );
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
			$disabled_widgets	=	current_user( 'ADMIN_WIDGETS_DISABLED' );
			if( !get_meta('widget_0', 'from_user_meta' ) && !get_meta('widget_1', 'from_user_meta' ) && !get_meta('widget_2', 'from_user_meta' ) ){
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
				<div class="col-lg-4 draggable_widgets">
					<?php echo __get_sections_widgets($admin_widgets,1);?>
				</div>
				<?php
					}
					else
					{
						?>
				<div class="col-lg-4 draggable_widgets">
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
		$userDisabledWidget	=	current_user('ADMIN_WIDGETS_DISABLED');
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
			$tos_module_enabled	=	get_modules( 'filter_active' );
			if($tos_module_enabled)
			{
				foreach($tos_module_enabled as $m)
				{
					$tepas_file	=	MODULES_DIR.$m['encrypted_dir'].'/tepas.php';
					if(is_file($tepas_file))
					{
						include_once($tepas_file);
						if(class_exists($m[ 'namespace' ].'_tepas_class'))
						{
							eval('new '.$m[ 'namespace' ].'_tepas_class($m);');
						}
					}
				}
			}
			// Tepas enabled only on active theme
			$active_theme		=	get_themes( 'filter_active' );
			if( is_array( $active_theme ) && count( $active_theme ) >  0 ) { // Si le thème existe
				$tepas_file			=	THEMES_DIR . $active_theme[ 'encrypted_dir' ] . '/tepas.php';
				if( is_file( $tepas_file ) )
				{
					include_once( $tepas_file );
					if( class_exists( $active_theme[ 'namespace' ] . '_theme_tepas_class' ) )
					{
						eval( 'new '. $active_theme[ 'namespace' ] . '_theme_tepas_class($active_theme);' );
					}
				}
			}
		}
	}
	/**
	*	get_meta()
	**/
	function get_meta($key = 'all',$source	=	"from_options") // to doc
	{
		if($source	==	"from_options")
		{
			if( $key != 'all' ){
				return get_instance()->meta_datas->get( $key );
			} else {
				$query	=	get_db()->where( 'USER' , 0 )->get( 'tendoo_meta' );
				$new_array	=	array();
				foreach( $result	=	$query->result_array() as $_key => $_result ){
					if( json_decode( $_result[ 'VALUE' ] ) != null ){
						$new_array[ $_result [ 'KEY' ] ] = json_decode( $_result[ 'VALUE' ] , TRUE );
					} else if( in_array( strtolower(  $_result[ 'VALUE' ] ) , array( 'true' , 'false' ) ) ){
						$new_array[ $_result [ 'KEY' ] ] = $_result[ 'VALUE' ] == 'true' ? true : false ;
					} else {
						$new_array[ $_result [ 'KEY' ] ] = $_result[ 'VALUE' ];
					}
				}
				return $new_array;
			}
		}
		else if($source	==	"from_user_meta")
		{
			return get_instance()->meta_datas->get_user_meta( $key );
		}
		return false;
	}
	/**
	*	set_meta()
	*	futur : ajouter un timestamp à une clé et leur donner uen valeur d'un mois.
	**/
	function set_meta($key,$value,$source	=	 "from_options")
	{
		if($source	==	"from_options")
		{
			return get_instance()->meta_datas->set( $key , $value );
		}
		else if($source	==	"from_user_meta")
		{
			return get_instance()->meta_datas->set_user_meta( $key , $value );
		}
	}
	/**
	*	unset_meta()
	**/
	function unset_meta($key, $source	=	"from_options")
	{
		if($source	==	"from_options")
		{
			return get_instance()->meta_datas->_unset( $key );
		}
		else if($source	==	"from_user_meta")
		{
			return get_instance()->meta_datas->_unset_user_datat( $key );
		}
	}
	/**
	*	set_admin_menu
	**/
	function setup_admin_left_menu( $title , $icon ){
		return false;
		// deprecated
	}
	function add_admin_left_menu( $title , $link ){
		return false; 
		// deprecated
	};
	function get_admin_left_menus(){
		return false;
		// Deprecated 
	}
	/**
	*	declare_api( $api_namespace , $callback_api )
	* 	Les API ne sont définie qu'une seule fois !!
	**/
	function declare_api( $api_namespace, $name , $callback_api ){
		$declared_api	=	get_core_vars( 'api_declared' ) ? get_core_vars( 'api_declared' ) : array();
		if( !return_if_array_key_exists( $api_namespace , $declared_api ) ){
			$declared_api[ $api_namespace ] = array(
				'callback'		=>	$callback_api ,
				'name'	=>	$name,
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
	/**
	*	do redirect while webapp mode is enabled
	**/
	function redirect_if_webapp_is_enalbled( $redirect = array() )
	{
		if( riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'webapp' )
		{
			$redirect ? get_instance()->url->redirect( $redirect ) : get_instance()->url->redirect( array( 'admin' , 'index?notice=webapp_enabled' ) );
		}
	}
 