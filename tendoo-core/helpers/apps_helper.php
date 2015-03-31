<?php
	/**
	 * 	Check if current script is being triggered through dashboard
	 *  @access public
	 * 	@return bool
	**/
	function is_admin()
	{
		if(defined('SCRIPT_CONTEXT'))
		{
			if(SCRIPT_CONTEXT == 'ADMIN')
			{
				return true;
			}
		}
		return false;
	}
	
	/**
	 * Return namespace for metaboxes
	 *
	 * @access public
	 * @param Array/String
	 * @param String (prefix)
	 * @return String
	**/
	
	function core_meta_namespace( $array , $base_prefix = '' )
	{
		if( is_string( $array ) )
		{
			return $base_prefix	== '' ? 'core.meta.tendoo.org/' . $array : $base_prefix . 'meta.tendoo.org' . $array;
		}
		else if( is_array( $array ) )
		{
			$base_prefix	=	( $base_prefix	== '' ) ? 'core.meta.tendoo.org' : $base_prefix . '.meta.tendoo.org' ;
			$final_slashes	=	'';
			foreach( $array as $value )
			{
				$final_slashes .=  '/' . $value;
			}
			return $base_prefix . $final_slashes;
		}
	}
	
	/**
	*	@var 	: string required
	*	@return : null
	*	@note : echo something if it's "echo-able". While Debug mode is enabled, it return an notice if @var
	**/
	function safe_echo( $var )
	{
		if( !is_object( $var ) && !is_object( $var ) && ! is_resource( $var ) )
		{
			echo $var;
		}
	}
	
	/**
	 * farray : return first index from a given Array
	 * 
	 * @access public
	 * @param Array
	 * @return Array/False
	 * @note Return False if index doesn't exists or if param is not an array.
	**/
	function farray( $array )
	{
		return riake( 0 , $array , false );
	}
	/** 
	 * Output array details
	 * @access public
	 * @param Array
	 * @param Bool
	 * @return String
	**/
	function print_array( $array , $return = FALSE )
	{
		ob_start();
		echo '<pre>';
		print_r( $array , $return );
		echo '</pre>';
		return $return ? ob_get_clean() : null;
	}
	/**
	 * Return an array if passe argument is not an array
	 *
	 * @param Var
	 * @return Array
	**/
	function convert_to_array( $item )
	{
		if( !is_array( $item ) )
		{
			return array( $item );
		}
		return $item;
	}
	/** 
	 * Force a var to be an array.
	 *
	 * @param Var
	 * @return Array
	**/
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
							$class	=	is_array( $menu_list ) && count( $menu_list ) > 1 ? 'treeview' : '';
							// Check if a menu as a open submenu
							$custom_ul_style	=	'';
							$menu_status		=	'';
							$menus_similarity	=	array();
							foreach( $menu_list as $check )
							{
								if( riake( 'href' , $check ) == get_instance()->url->site_url() )
								{
									$custom_ul_style	= 	'style="display: block;"';
									$menu_status		=	'active';
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
										$custom_style	=	get_instance()->url->site_url() == riake( 'href' , $menu , '#' ) ? 'style="color:#FEFEFE;text-shadow:0px 0px 1px #333"' : '';
										$is_submenu	=	riake( 'is_submenu' , $menu , true );
										if( $first_index == 0 ) // parent
										{
											?>
											<a <?php echo $custom_style;?> href="javascript:void(0)" class="dropdown-toggle <?php echo $menu_status;?>"> 
												<i class="<?php echo riake( 'icon' , $menu , 'fa fa-star' );?>"></i> 
												<span><?php echo $title;?></span> 
                                                <i class="fa fa-angle-left pull-right"></i>
											</a>
											<ul <?php echo $custom_ul_style;?> class="treeview-menu">
                                            <?php
											// This let you choose if the first menu is also a submenu
											if( $is_submenu ):?>
												<li> <a <?php echo $custom_style;?> href="<?php echo riake( 'href' , $menu , '#' );?>"><?php echo riake( 'title' , $menu );?></a> </li>	
                                            <?php 
											endif;
											
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
		$events_bound		=	get_core_vars( 'get_core_events' );
		$current_events		=	return_if_array_key_exists( $events , $events_bound );
		if( is_array( $current_events ) )
		{
			return $current_events;
		}
		return false;
	};
	/**
	*	bs_pagination, génère une liste de lien au format HTML de bootstrap.
	**/
	function bs_pagination($array,$additionnal_class = "pagination-sm m-t-none m-b-none")
	{
		?>
<ul class="pagination <?php echo $additionnal_class;?>" style="margin:0px;">
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
	function pagination_helper($ContentPerPage,$TotalContent,$CurrentPage,$BaseUrl,$RedirectUrl = array('error','code','page-404'))
	{
		$instance	=	get_instance();
		$result	=	$instance->tendoo->doPaginate($ContentPerPage,$TotalContent,$CurrentPage,$BaseUrl);
		if($result[0] == 'page-404'): $instance->url->redirect($RedirectUrl);endif;
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
			echo notice( 'parse' );
		}
		else if($element == 'headers') // must be added to each theme head
		{
			// Including new UserBar css
			css_push_if_not_exists('tendoo_userbar',$instance->url->main_url().'/tendoo-assets/css/');
			// Ouputing CSS and JS
			output('css');
			output('js');
		}
		else if( $element == 'content-header' )
		{
			?>
            <section class="content-header">
                <h1>
                    <?php echo get_page('title');?>
                    <!--<small><?php echo get_page( 'description' );?></small>-->
                </h1>
                <!--
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Widgets</li>
                </ol>
                -->
            </section>
            <?php
		}
		else if( $element == 'content-card' )
		{
			return; // disabled for now
			?>
            <div class="row">
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>
                                        150
                                    </h3>
                                    <p>
                                        New Orders
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-bag"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>
                                        53<sup style="font-size: 20px">%</sup>
                                    </h3>
                                    <p>
                                        Bounce Rate
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3>
                                        44
                                    </h3>
                                    <p>
                                        User Registrations
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-person-add"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>
                                        65
                                    </h3>
                                    <p>
                                        Unique Visitors
                                    </p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-pie-graph"></i>
                                </div>
                                <a href="#" class="small-box-footer">
                                    More info <i class="fa fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div><!-- ./col -->
                    </div>
            <?php
		}
		else if( $element == 'content-widgets' )
		{
			?>
            <?php echo fetch_notice_from_url();?>
            <div class="row">
                <?php ouput_admin_widgets();?>
            </div>
            <?php
			return; // disabled for now
			
			?>
            <div class="row">
                <div class="col-md-4">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Default Box (button tooltip)</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="Collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="Remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            Box class: <code>.box</code>
                            <p>
                                amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
                                berliner weisse wort chiller adjunct hydrometer alcohol aau!
                                sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
                            </p>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <code>.box-footer</code>
                        </div><!-- /.box-footer-->
                    </div><!-- /.box -->
                </div><!-- /.col -->

                <div class="col-md-4">
                    <!-- Primary box -->
                    <div class="box box-primary">
                        <div class="box-header" data-toggle="tooltip" title="Header tooltip">
                            <h3 class="box-title">Primary Box (header tooltip)</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-primary btn-xs" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-primary btn-xs" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            Box class: <code>.box.box-primary</code>
                            <p>
                                amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
                                berliner weisse wort chiller adjunct hydrometer alcohol aau!
                                sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
                            </p>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <code>.box-footer</code>
                        </div><!-- /.box-footer-->
                    </div><!-- /.box -->
                </div><!-- /.col -->

                <div class="col-md-4">
                    <!-- Info box -->
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Info Box</h3>
                            <div class="box-tools pull-right">
                                <div class="label bg-aqua">Label</div>
                            </div>
                        </div>
                        <div class="box-body">
                            Box class: <code>.box.box-info</code>
                            <p>
                                amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
                                berliner weisse wort chiller adjunct hydrometer alcohol aau!
                                sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
                            </p>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <code>.box-footer</code>
                        </div><!-- /.box-footer-->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
                <div class="col-md-4">
                    <!-- Danger box -->
                    <div class="box box-danger">
                        <div class="box-header">
                            <h3 class="box-title">Danger Box (Loading state)</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-danger btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                <button class="btn btn-danger btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="box-body">
                            Box class: <code>.box.box-danger</code>
                            <p>
                                amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
                                berliner weisse wort chiller adjunct hydrometer alcohol aau!
                                sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
                            </p>
                        </div><!-- /.box-body -->
                        <!-- Loading (remove the following to stop the loading)-->
                        <div class="overlay"></div>
                        <div class="loading-img"></div>
                        <!-- end loading -->
                    </div><!-- /.box -->
                </div><!-- /.col -->

                <div class="col-md-4">
                    <!-- Success box -->
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title">Success Box (toggle buttons)</h3>
                            <div class="box-tools pull-right">
                                <div class="btn-group" data-toggle="btn-toggle">
                                    <button type="button" class="btn btn-success btn-xs active" data-toggle="on">Left</button>
                                    <button type="button" class="btn btn-success btn-xs" data-toggle="off">Right</button>
                                </div>
                            </div>
                        </div>
                        <div class="box-body">
                            Box class: <code>.box.box-success</code>
                            <p>
                                amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
                                berliner weisse wort chiller adjunct hydrometer alcohol aau!
                                sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
                            </p>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->

                <div class="col-md-4">
                    <!-- Warning box -->
                    <div class="box box-warning">
                        <div class="box-header">
                            <h3 class="box-title">Warning Box</h3>
                            <div class="box-tools pull-right">
                                <ul class="pagination pagination-sm inline">
                                    <li><a href="#">&laquo;</a></li>
                                    <li><a href="#">1</a></li>
                                    <li><a href="#">2</a></li>
                                    <li><a href="#">&raquo;</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="box-body">
                            Box class: <code>.box.box-warning</code>
                            <p>
                                amber, microbrewery abbey hydrometer, brewpub ale lauter tun saccharification oxidized barrel.
                                berliner weisse wort chiller adjunct hydrometer alcohol aau!
                                sour/acidic sour/acidic chocolate malt ipa ipa hydrometer.
                            </p>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
            <?php
		
		}
		else if( $element == 'content-left-menu' )
		{
			echo get_core_vars( 'lmenu' );
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
				return $instance->notice->push_notice($params);
			break;
			case 'parse' : 
				echo fetch_notice_from_url();
				echo validation_errors();
				echo $instance->notice->parse_notice();
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
		return instance::get();
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
	/**		WAITING FOR APPROUVAL FOR 1.5
	$_	=	function ( $key , $value , $access = 'writable' )
	{
		return set_core_vars( $key , $value , $access );
	};
	**/
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
	function declare_notices($array,$notice_text = null ) // add to doc new tendoo 1.2
	{
		$notices	=	get_core_vars( 'tendoo_notices' );
		if(!is_array($array))
		{
			$notices[$array]	=	$notice_text;
		}
		else
		{
			foreach($array as $k => $v)
			{
				$notices[$k]	=	$v;
			}
		}
		set_core_vars( 'tendoo_notices' , $notices );
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
	*	Autorise la déclaration des widgets qui seront affiché à l'accueil du tableau de bord via init.
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
					if( !in_array( riake( 'handle' , $module ) , array( 'APP' , 'system' ) ) && get_core_vars( 'tendoo_mode' , 'options' , 'website' ) == 'webapp' )
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
	function trigger_inits()
	{
		if(!defined('INITS_EXECUTED'))
		{
			define( 'INITS_EXECUTED' , 'TRUE');
			$tos_module_enabled	=	get_modules( 'filter_active' );
			if($tos_module_enabled)
			{
				foreach($tos_module_enabled as $m)
				{
					$init_file	=	MODULES_DIR.$m['encrypted_dir'].'/init.php';
					if(is_file($init_file))
					{
						include_once($init_file);
						if(class_exists($m[ 'namespace' ].'_init_class'))
						{
							eval('new '.$m[ 'namespace' ].'_init_class($m);');
						}
					}
				}
			}
			// init enabled only on active theme
			$active_theme		=	get_themes( 'filter_active' );
			if( is_array( $active_theme ) && count( $active_theme ) >  0 ) { // Si le thème existe
				$init_file			=	THEMES_DIR . $active_theme[ 'encrypted_dir' ] . '/init.php';
				if( is_file( $init_file ) )
				{
					include_once( $init_file );
					if( class_exists( $active_theme[ 'namespace' ] . '_theme_init_class' ) )
					{
						eval( 'new '. $active_theme[ 'namespace' ] . '_theme_init_class($active_theme);' );
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
	function set_meta_array( $array , $source = 'from_options' )
	{
		// Pending
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
	function redirect_if_webapp_is_enabled( $redirect = array() )
	{
		if( riake( 'tendoo_mode' , get_core_vars( 'options' ) , 'website' ) == 'webapp' )
		{
			$redirect ? get_instance()->url->redirect( $redirect ) : get_instance()->url->redirect( array( 'admin' , 'index?notice=web-app-mode-enabled' ) );
		}
	}
	
	/**
	 *	Apply a filter to a specific hook passed as first parameters
	 *
	 *	@param string, array/string, int
	 *  @return void;
	**/
	
 	function bind_filter( $hook , $filter ) {
		$filters	=	get_core_vars( 'tendoo_filters' );
		$filters[ $hook ][]		=		$filter; // adding filter to a hook
		return set_core_vars( 'tendoo_filters' , $filters );
	}
	
	/**
	 * 	Trigger filter registered for a specific hook.
	 *
	 *	@params string, string/array/int
	 * 	@return vars multiform
	**/
	
	function trigger_filters( $hook , $parameters ){
		$filters	=	get_core_vars( 'tendoo_filters' );
		if( $sub_filters 	= 	riake( $hook , $filters ) ) {
			foreach( $sub_filters as $_filter ) {
				$parameters[0]		=	call_user_func_array( $_filter , $parameters );
			}
		}
		return $parameters[0];
	}
	
	/**
	 * Register Fields for custom forms
	 *
	 * @params String, form name
	 * @params Array, data to register
	 * @return void
	**/
	
	function register_fields( $form_name , $config ){
		/**
		 *	Config form
		 * 	array( 
		 *		'name'		=>	'example', // a valid index of POST[ 'example' ]
		 *		'purify'	=>	function( $value ){
		 *			return $value
		 *		}
		 *	)
		**/
		$fields_registered					=	riake( 'registered_fields' , get_core_vars() , array() );
		$fields_registered[ $form_name ][]	=	$config;
		set_core_vars( 'registered_fields' , $fields_registered );
	}
	
	/**
	 *	get registered fields for a specific form
	**/
	
	function get_registered_fields( $form_name ){
		$fields_registered	=	riake( 'registered_fields' , get_core_vars() , array() );
		return riake( $form_name , $fields_registered );
	}
	
	/**
	 *	Prepend 0 to single int
	**/
	
	function unsinglerize( $int )
	{
		$num_padded = sprintf("%02d", $int);
		return $num_padded; // returns 04
	}
	
	