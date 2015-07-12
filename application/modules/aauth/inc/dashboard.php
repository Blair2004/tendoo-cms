<?php
class aauth_dashboard extends CI_model
{
	function __construct()
	{
		$this->events->add_action( 'load_dashboard' , array( $this , 'dashboard' ) );	
		$this->events->add_filter( 'admin_menus' , array( $this , 'menu' ) );		
		$this->events->add_filter( 'dashboard_skin_class' , array( $this , 'dashboard_skin_class' ) , 5 , 1 );		
		// Change user name in the user menu
		$this->events->add_filter( 'user_menu_name' , array( $this , 'user_menu_name' ) );
		$this->events->add_filter( 'user_menu_card_header' , array( $this , 'user_menu_header' ) );
	}
	function dashboard()
	{
		$this->gui->register_page( 'users' , array( $this , 'users' ) );
		$this->gui->register_page( 'roles' , array( $this , 'roles' ) );
	}
	function menu( $menus )
	{
		$menus[ 'users' ]		=	array(
			array(
				'title'			=>		__( 'Manage Users' ),
				'icon'			=>		'fa fa-users',
				'href'			=>		site_url('dashboard/users')
			),
			array(
				'title'			=>		__( 'Create a new User' ),
				'icon'			=>		'fa fa-users',
				'href'			=>		site_url('dashboard/users/create')
			)			
		);
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
				'href'			=>		site_url('dashboard/roles/groups')
			),
			array(
				'title'			=>		__( 'Create a new group' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/roles/groups/new')
			),
			array(
				'title'			=>		__( 'Groups permissions' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/roles/groups/permissions')
			)			
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
	
	function dashboard_skin_class( $skin )
	{
		//var_dump( $this->users->get_meta( 'theme-skin' ) );die;
		// skin is defined by default
		$skin	=	( $db_skin = $this->users->get_meta( 'theme-skin' ) ) ? $db_skin : $skin; // weird ??? lol
		unset( $db_skin );
		return $skin;
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
		else if( $page == 'edit') 
		{
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
		else if( $page == 'create' )
		{
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
		else if( $page == 'delete' )
		{
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
	
	function roles( $page = 'list' , $index = 1 )
	{
		// Display all roles
		if( $page == 'list' )
		{
			$groups		=	$this->users->auth->list_groups();
			
			$this->gui->set_title( sprintf( __( 'Roles &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/roles/body' , array(
				'groups'	=>	$groups
			) );
		}
		// Display Creation form
		else if( $page == 'create' )
		{
			// Validating role creation form
			$this->load->library( 'form_validation' );
			$this->form_validation->set_rules( 'role_name' , __( 'Role Name' ) , 'required' );
			$this->form_validation->set_rules( 'role_type' , __( 'Role Type' ) , 'required' );
			
			if( $this->form_validation->run() )
			{
				$exec 	=	$this->users->set_role( 
					$this->input->post( 'role_name' ),
					$this->input->post( 'role_definition' ),
					$this->input->post( 'role_type' )
				);
				if( $exec == 'group-created' )
				{
					redirect( array( 'dashboard' , 'roles?notice=' . $exec ) );
				}
				$this->notice->push_notice( $this->lang->line( $exec ) );
			}
			
			
			$this->gui->set_title( sprintf( __( 'Create new role &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/roles/create' );
		}
		// Display Edit form
		else if( $page == 'edit' )
		{
			// Fetch role or redirect
			$role	=	$this->users->auth->get_group_name( $index );
			if( $role === FALSE ): redirect( array( 'dashboard' , 'group-not-found' ) ); endif;
			
			$this->load->library( 'form_validation' );
			$this->form_validation->set_rules( 'role_name' , __( 'Role Name' ) , 'required' );
			$this->form_validation->set_rules( 'role_type' , __( 'Role Type' ) , 'required' );
			if( $this->form_validation->run() )
			{
				$exec 	=	$this->users->set_role( 
					$this->input->post( 'role_name' ),
					$this->input->post( 'role_definition' ),
					$this->input->post( 'role_type' ),
					'edit', 
					$index
				);
				if( $exec == 'group-created' )
				{
					redirect( array( 'dashboard' , 'roles?notice=' . $exec ) );
				}
				$this->notice->push_notice( $this->lang->line( $exec ) );
			}
			
			$this->gui->set_title( sprintf( __( 'Edit Roles &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/roles/edit' );
		}
	}
}
new aauth_dashboard;