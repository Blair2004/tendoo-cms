<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class aauth_dashboard extends CI_model
{
	function __construct()
	{
		$this->events->add_action( 'load_dashboard' , array( $this , 'dashboard' ) );	
		$this->events->add_filter( 'admin_menus' , array( $this , 'menu' ) );		
		$this->events->add_filter( 'dashboard_body_class' , array( $this , 'dashboard_body_class' ) , 5 , 1 );		
		// Change user name in the user menu
		$this->events->add_filter( 'user_menu_name' , array( $this , 'user_menu_name' ) );
		$this->events->add_filter( 'user_menu_card_header' , array( $this , 'user_menu_header' ) );
		$this->events->add_filter( 'tendoo_object_user_id' , array( $this , 'user_id' ) );
		$this->events->add_filter( 'user_header_profile_link' , array( $this , 'user_profile_link' ) );
	}
	function user_profile_link( $link )
	{
		return site_url( array( 'dashboard' , 'users' , 'profile' ) );
	}
	function user_id( $user_id )
	{
		if( $user_id == 'false' )
		{
			return $this->users->auth->get_user_id();
		}
	}
	function before_dashboard_menu()
	{
		ob_start();
		?>
      <div class="user-panel">
         <div class="pull-left image"><img class="img-circle" alt="user image" src=""/></div>
         <div class="pull-left info">
           <p><?php echo $this->events->apply_filters( 'user_menu_name' , $this->config->item( 'default_user_names' ) );?></p>
           <a href="#"><i class="fa fa-circle text-success"></i> Online</a> </div>
       </div>
      <?php
		return ob_get_clean();
	}
	function dashboard()
	{
		$this->gui->register_page( 'users' , array( $this , 'users' ) );
		$this->gui->register_page( 'groups' , array( $this , 'groups' ) );
	}
	function menu( $menus )
	{		
		$menus[ 'users' ]		=	array(
			array(
				'title'			=>		__( 'Manage Users' ),
				'icon'			=>		'fa fa-users',
				'href'			=>		site_url('dashboard/users')
			)
		);
		
		/**
		 * Checks whether a user can manage user
		**/
		
		if( User::can( 'manage_users' ) ) :
		
		$menus[ 'users' ][]	=				array(
			'title'			=>		__( 'Create a new User' ),
			'icon'			=>		'fa fa-users',
			'href'			=>		site_url('dashboard/users/create')
		);
		
		endif; // for manage_users permission
		
		$menus[ 'roles' ]		=		array(
			/** 
			array(
				'title'			=>		__( 'Roles' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/roles'),
			),
			array(
				'title'			=>		__( 'Create new role' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/roles/create')
			),
			**/ 
			array(
				'title'			=>		__( 'Groups' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/groups')
			),
			array(
				'title'			=>		__( 'Create a new group' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/groups/new')
			),
			/**
			array(
				'title'			=>		__( 'Groups permissions' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/groups/permissions')
			)	
			**/		
		);
		
		return $menus;
	}
	
	/**
	 * Perform Change over Auth emails config
	 * 
	 * @access : public
	 * @params : string user names
	 * @return : string
	**/
	
	function user_menu_name( $user_name )
	{
		$name 	=	$this->users->get_meta( 'first-name' );
		$last	=	$this->users->get_meta( 'last-name' );
		$full	=	trim( ucwords( substr( $name , 0 , 1 ) ) . '.' . ucwords( $last ) );
		return $full == '.' ? $user_name : $full;
	}
	
	/**
	 * Perform Change over Auth emails config
	 * 
	 * @access : public
	 * @params : string user names
	 * @return : string
	**/
	
	function user_menu_header( $user_name )
	{
		$name 	=	$this->users->get_meta( 'first-name' );
		$last	=	$this->users->get_meta( 'last-name' );
		$full	=	trim( ucwords( substr( $name , 0 , 1 ) ) . '.' . ucwords( $last ) );
		return $full == '.' ? $user_name : $full;
	}
	
	
	
	/**
	 * Get dashboard skin for current user
	 *
	 * @access : public
	 * @params : string
	 * @return : string
	**/
	
	function dashboard_body_class( $class )
	{
		//var_dump( $this->users->get_meta( 'theme-skin' ) );die;
		// skin is defined by default
		$class	=	( $db_skin = $this->users->get_meta( 'theme-skin' ) ) ? $db_skin : $class; // weird ??? lol
		unset( $db_skin );
		
		// get user sidebar status
		$sidebar		=	$this->users->get_meta( 'dashboard-sidebar' );
		if( $sidebar == true )
		{
			$class	.= ' ' . $sidebar;
		}
		else
		{
			$class	.=	' sidebar-expanded';
		}
		return $class;
		
	}
	
	function users( $page = 'list' , $index = 1 )
	{		
		if( $page == 'list' )
		{
			// $this->users() it's the current method, $this->users is the main user object
			$users			=		$this->users->auth->list_users($group_par = FALSE, $limit = FALSE, $offset = FALSE, $include_banneds = FALSE);
			$this->gui->set_title( sprintf( __( 'Users &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( '../modules/aauth/views/users/body' , array( 
				'users'	=>	$users
			) );
		}
		
		/**
		 * Status : 
		 * 	permissions ok
		**/
		
		else if( $page == 'edit') 
		{
			if( ! User::can( 'manage_users' ) ) : redirect( array( 'dashboard?notice=access-denied' ) ); endif; // permission checks
			
			// if current user matches user id
			if( $this->users->auth->get_user_id() == $index )
			{
				redirect( array( 'dashboard' , 'users' , 'profile' ) );
			}
			// User Goup
			$user				=	$this->users->auth->get_user( $index );			
			$user_group			=	farray( $this->users->auth->get_user_groups( $index ) );

			if( ! $user )
			{
				redirect( array( 'dashboard' , 'unknow-user' ) );
			}
			
			// validation rules			
			$this->load->library( 'form_validation' );
			
			$this->form_validation->set_rules( 'user_email' , __( 'User Email' ), 'required|valid_email' );
			$this->form_validation->set_rules( 'password' , __( 'Password' ), 'min_length[6]' );
			$this->form_validation->set_rules( 'confirm' , __( 'Confirm' ), 'matches[password]' );
			$this->form_validation->set_rules( 'userprivilege' , __( 'User Privilege' ), 'required' );
			
			// load custom rules
			$this->events->do_action( 'user_creation_rules' );
			
			if( $this->form_validation->run() )
			{
				$exec	=	$this->users->edit(
				 	$index , 
					$this->input->post( 'user_email' ),
					$this->input->post( 'password' ),
					$this->input->post( 'userprivilege' ),
					$user_group
				);			
				$this->notice->push_notice( $this->lang->line( 'user-updated' ) );
				// Refresh user data
				$user				=	$this->users->auth->get_user( $index );
				// User Goup
				$user_group			=	farray( $this->users->auth->get_user_groups( $index ) );
				
				if( ! $user )
				{
					redirect( array( 'dashboard' , 'unknow-user' ) );
				}
			}			
			
			// User Goup
			$user_group			=	farray( $this->users->auth->get_user_groups( $user->id ) );
			// selecting groups
			$groups				=	$this->users->auth->list_groups();		
			
			$this->gui->set_title( sprintf( __( 'Edit user &mdash; %s' ) , get( 'core_signature' ) ) );
			
			$this->load->view( '../modules/aauth/views/users/edit' , array( 
				'groups'		=>	$groups,
				'user'			=>	$user,
				'user_group'	=>	$user_group
			) );
		}
		
		/**
		 * Status : 
		 * 	permissions ok
		**/
		
		else if( $page == 'create' )
		{
			if( ! User::can( 'manage_users' ) ) : redirect( array( 'dashboard?notice=access-denied' ) ); endif; // permission checks
			
			$this->load->library( 'form_validation' );
			
			$this->form_validation->set_rules( 'username' , __( 'User Name' ), 'required|min_length[5]' );
			$this->form_validation->set_rules( 'user_email' , __( 'User Email' ), 'required|valid_email' );
			$this->form_validation->set_rules( 'password' , __( 'Password' ), 'required|min_length[6]' );
			$this->form_validation->set_rules( 'confirm' , __( 'Confirm' ), 'required|matches[password]' );
			$this->form_validation->set_rules( 'userprivilege' , __( 'User Privilege' ), 'required' );
			
			// load custom rules
			$this->events->do_action( 'user_creation_rules' );
			
			if( $this->form_validation->run() )
			{
				$exec	=	$this->users->create( 
					$this->input->post( 'user_email' ),
					$this->input->post( 'password' ),
					$this->input->post( 'username' ),					
					$this->input->post( 'userprivilege' )
				);
				if( $exec == 'user-created' )
				{
					redirect( array( 'dashboard' , 'users?notice=' . $exec ) ); exit;
				}
				$this->notice->push_notice( $this->lang->line( $exec ) );
			}
			
			// selecting groups
			$groups				=	$this->users->auth->list_groups();
			
			$this->gui->set_title( sprintf( __( 'Create a new user &mdash; %s' ) , get( 'core_signature' ) ) );
			
			$this->load->view( '../modules/aauth/views/users/create' , array( 
				'groups'	=>	$groups
			) );
		}

		/**
		 * Status : 
		 * 	permissions ok
		**/
		
		else if( $page == 'delete' )
		{
			if( ! User::can( 'manage_users' ) ) : redirect( array( 'dashboard?notice=access-denied' ) ); endif; // permission checks
			
			$user	=	$this->users->auth->user_exsist_by_id( $index );
			if( $user )
			{
				$this->users->delete( $index );
				redirect( array( 'dashboard' , 'users?notice=user-deleted' ) );
			}
			redirect( array( 'dashboard' , 'unknow-user' ) );
		}
		else if( $page == 'profile' )
		{
			$this->load->library( 'form_validation' );
			
			$this->form_validation->set_rules( 'user_email' , __( 'User Email' ), 'valid_email' );
			$this->form_validation->set_rules( 'old_pass' , __( 'Old Pass' ), 'min_length[6]' );
			$this->form_validation->set_rules( 'password' , __( 'Password' ), 'min_length[6]' );
			$this->form_validation->set_rules( 'confirm' , __( 'Confirm' ), 'matches[password]' );
			
			// Launch events for user profiles edition rules
			$this->events->do_action( 'user_profile_rules' );
			if( $this->form_validation->run() )
			{
				$exec	=	$this->users->edit(
					$this->users->auth->get_user_id() , 
					$this->input->post( 'user_email' ),
					$this->input->post( 'password' ),
					$this->input->post( 'userprivilege' ),
					null, // user Privilege can't be editer through profile dash
					$this->input->post( 'old_pass' ),
					'profile'
				);
				
				$this->notice->push_notice_array( $exec );
			}
			
			$this->gui->set_title( sprintf( __( 'My Profile &mdash; %s' ) , get( 'core_signature' ) ) );
			
			$this->load->view( '../modules/aauth/views/users/profile' );
		}
	}
	
	/**
	 * Admin Roles
	 *
	 * Handle Groups management
	 * @since 1.5
	**/
	
	function groups( $page = 'list' , $index = 1 )
	{
		// Display all roles
		if( $page == 'list' )
		{
			$groups		=	$this->users->auth->list_groups();
			
			$this->gui->set_title( sprintf( __( 'Roles &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( '../modules/aauth/views/groups/body' , array(
				'groups'	=>	$groups
			) );
		}
		
		/**
		 * Details : Display Creation form
		 * Status : 
		 * 	permissions ok
		**/
		
		else if( $page == 'new' )
		{
			if( ! User::can( 'manage_users' ) ) : redirect( array( 'dashboard?notice=access-denied' ) ); endif; // permission checks
			
			// Validating role creation form
			$this->load->library( 'form_validation' );
			$this->form_validation->set_rules( 'role_name' , __( 'Role Name' ) , 'required' );
			$this->form_validation->set_rules( 'role_type' , __( 'Role Type' ) , 'required' );
			
			if( $this->form_validation->run() )
			{
				$exec 	=	$this->users->set_group( 
					$this->input->post( 'role_name' ),
					$this->input->post( 'role_definition' ),
					$this->input->post( 'role_type' )
				);
				if( $exec == 'group-created' )
				{
					redirect( array( 'dashboard' , 'groups?notice=' . $exec ) );
				}
				$this->notice->push_notice( $this->lang->line( $exec ) );
			}
			
			
			$this->gui->set_title( sprintf( __( 'Create new role &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( '../modules/aauth/views/groups/create' );
		}
		
		/**
		 * Details : Display Edit form
		 * Status : 
		 * 	permissions ok
		**/
		
		else if( $page == 'edit' )
		{			
			if( ! User::can( 'manage_users' ) ) : redirect( array( 'dashboard?notice=access-denied' ) ); endif; // permission checks
			
			$this->load->library( 'form_validation' );
			$this->form_validation->set_rules( 'role_name' , __( 'Role Name' ) , 'required' );
			$this->form_validation->set_rules( 'role_type' , __( 'Role Type' ) , 'required' );
			if( $this->form_validation->run() )
			{
				$exec 	=	$this->users->set_group( 
					$this->input->post( 'role_name' ),
					$this->input->post( 'role_definition' ),
					$this->input->post( 'role_type' ),
					'edit', 
					$index
				);
				if( $exec == 'group-updated' )
				{
					redirect( current_url() . '?notice=' . $exec );
				}
				$this->notice->push_notice( $this->lang->line( $exec ) );
			}
			// Fetch role or redirect
			$group	=	$this->users->auth->get_group_id( $index );
			
			if( is_object( $group ) === FALSE ): redirect( array( 'dashboard' , 'group-not-found' ) ); endif;
			$usergroup			=	$this->users->auth->get_user_groups( $index );
			
			$this->gui->set_title( sprintf( __( 'Edit Roles &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( '../modules/aauth/views/groups/edit' , array(
				'group'		=>		$group
			) );
		}
	}
}
new aauth_dashboard;