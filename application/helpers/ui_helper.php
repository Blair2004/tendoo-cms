<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
		$interface_menus	=	get_instance()->config->item( $interface . '_menus' );
		
		if( 
			in_array( $position , get_instance()->config->item( $interface . '_menu_position' ) ) && 
			in_array( $item , get_instance()->config->item( $interface . '_menu_items' ) ) 
		)
		{
			$interface_menus[ $item ][ $position ][ $namespace ]	=	array(); // Saving menu namespace
		}
		return get_instance()->config->set_item( $interface . '_menus' , $interface_menus ); // save it to the main array;
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
		$interface_menus	=	is_array( $array	=	get_instance()->config->item( $interface . '_menus' ) ) ? $array : array();
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
		get_instance()->config->set_item( $interface . '_menus' , $interface_menus );
	}
}
/**
*	show_admin_menu( 'position' )
**/
function __show_menu( $interface , $position , $item )
{
	if( in_array( $interface , array( 'admin' , 'account' ) ) ) 
	{
		if( in_array( $item , force_array( get_instance()->config->item( $interface . '_menu_items' ) ) ) )
		{
			if( in_array( $position , array( 'before' , 'after' ) ) )
			{
				$get_menus		=	riake( $item , get_instance()->config->item( $interface . '_menus' ) , array() );
				$menu_position	=	riake( $position , $get_menus , array() );
				var_dump( $menu_position );die;
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
						$parent_notice_count=	0; // for displaying notice nbr count @since 1.4
						foreach( $menu_list as $check )
						{
							$parent_notice_count +=	riake( 'notices_nbr' , $check );
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
											<?php
											 if( $parent_notice_count > 0 )
											 {
											 ?>
											 <small class="label pull-right bg-yellow"><?php echo $parent_notice_count;?></small>
											 <?php
											 }
											 ?>     
										</a>
										<ul <?php echo $custom_ul_style;?> class="treeview-menu">
										<?php
										// This let you choose if the first menu is also a submenu
										if( $is_submenu ):?>
											<li> 
												<a <?php echo $custom_style;?> href="<?php echo riake( 'href' , $menu , '#' );?>">
													<span><?php echo riake( 'title' , $menu );?></span>
													<?php
													 if( riake( 'notices_nbr' , $menu ) == true )
													 {
													 ?>
													 <small class="label pull-right bg-yellow"><?php echo riake( 'notices_nbr' , $menu );?></small>
													 <?php
													 }
													 ?>                                                             
												</a> 
											</li>	
										<?php 
										endif;
										
									}
									else // childs menus
									{
										// inlight current page
										?>
										<li> 
											<a <?php echo $custom_style;?> href="<?php echo riake( 'href' , $menu , '#' );?>">
												<span><?php echo riake( 'title' , $menu );?></span>
												<?php
												 if( riake( 'notices_nbr' , $menu ) == true )
												 {
												 ?>
												 <small class="label pull-right bg-yellow"><?php echo riake( 'notices_nbr' , $menu );?></small>
												 <?php
												 }
												 ?>                                                             
											</a> 
										</li>	
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
									 <a href="<?php echo riake( 'href' , $menu , '#' );?>"> 
										<i class="<?php echo riake( 'icon' , $menu , 'fa fa-star' );?>"></i> 
										<span><?php echo riake( 'title' , $menu );?></span> 
										<?php
										 if( riake( 'notices_nbr' , $menu ) == true )
										 {
										 ?>
										 <small class="label pull-right bg-yellow"><?php echo riake( 'notices_nbr' , $menu );?></small>
										 <?php
										 }
										 ?>                                                             
									</a>
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

/* End of file ui_helper.php */
