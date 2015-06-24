<?php 
class auth_module_class extends CI_model
{
	function __construct()
	{
		$this->events->add_action( 'load_users_custom_fields' , array( $this , 'user_custom_fields' ) );
		$this->events->add_filter( 'custom_user_meta' , array( $this , 'custom_user_meta' ) , 10 , 1 );
		$this->events->add_filter( 'dashboard_skin_class' , array( $this , 'dashboard_skin_class' ) , 5 , 1 );
		
		// Change user name in the user menu
		$this->events->add_filter( 'user_menu_name' , array( $this , 'user_menu_name' ) );
		$this->events->add_filter( 'user_menu_card_header' , array( $this , 'user_menu_header' ) );
		
		// change send administrator emails
		$this->events->add_action( 'send_recovery_email' , array( $this , 'change_auth_settings' ) );
		$this->events->add_action( 'after_app_init' , array( $this , 'after_session_starts' ) );
		$this->events->add_action( 'displays_dashboard_errors' , array( $this , 'displays_dashboard_errors' ) );
		$this->events->add_filter( 'admin_menus' , array( $this , 'menu' ) );
		$this->events->add_action( 'dashboard_loaded' , array( $this , 'dashboard' ) );	
	}
	
	function dashboard()
	{
		$this->gui->register_page( 'users' , array( $this , 'users' ) );
		$this->gui->register_page( 'roles' , array( $this , 'roles' ) );
	}
	
	/**
	 * Displays Error on Dashboard Page
	**/
	
	function displays_dashboard_errors()
	{
		$errors	=	$this->users->auth->get_errors_array();
		if( $errors )
		{
			foreach( $errors as $error )
			{
				echo tendoo_error( $error );
			}
		}
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
	 * Change Auth Class Email Settings
	 *
	 * @return : void
	**/
	
	function change_auth_settings()
	{
		$auth				=	&$this->users->auth->config_vars;
		$auth[ 'email' ]	=	'cms@tendoo.org';
		$auth[ 'name' ]		=	get( 'core_signature' ); 
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
	
	/**
	 * Adds custom fields for user creation and edit
	 *
	 * @access : public
	 * @params : Array
	 * @return : Array
	**/
	
	function user_custom_fields( $config )
	{
		// refresh user meta
		$this->users->refresh_user_meta();
		
		$this->gui->add_item( array(
			'type'		=>		'text',
			'name'		=>		'first-name',
			'label'		=>		__( 'First Name' ),
			'value'		=>		$this->options->get( 'first-name' , riake( 'user_id' , $config ) )
		) , riake( 'meta_namespace' , $config ) , riake( 'col_id' , $config ) );
		
		$this->gui->add_item( array(
			'type'		=>		'text',
			'name'		=>		'last-name',
			'label'		=>		__( 'Last Name' ),
			'value'		=>		$this->options->get( 'last-name' , riake( 'user_id' , $config ) )
		) , riake( 'meta_namespace' , $config ) , riake( 'col_id' , $config ) );
		
		ob_start();
		$skin	=	$this->options->get( 'theme-skin' , riake( 'user_id' , $config ) );
		?>
        <h3><?php _e( 'Select a theme' );?></h3>
        <ul class="list-unstyled clearfix theme-selector">
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-blue' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin">Blue</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-black' ? 'active' : '';?>">
                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin">Black</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-purple' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin">Purple</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-green' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin">Green</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-red' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin">Red</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-yellow' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #222d32;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin">Yellow</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-blue-light' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9;"></span><span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Blue Light</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-black-light' ? 'active' : '';?>">
                <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix"><span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe;"></span><span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Black Light</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-purple-light' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span><span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Purple Light</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-green-light' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span><span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Green Light</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-red-light' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span><span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px">Red Light</p>
            </li>
            <li style="float:left; width: 33.33333%; padding: 5px;"><a href="javascript:void(0);" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover <?php echo $skin == 'skin-yellow-light' ? 'active' : '';?>">
                <div><span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span><span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span></div>
                <div><span style="display:block; width: 20%; float: left; height: 50px; background: #f9fafc;"></span><span style="display:block; width: 80%; float: left; height: 50px; background: #f4f5f7;"></span></div>
                </a>
                <p class="text-center no-margin" style="font-size: 12px;">Yellow Light</p>
            </li>
        </ul>
        <input type="hidden" name="theme-skin" value="<?php echo $skin;?>" />
		<style>
        .theme-selector li a.active
        {
            opacity:1 !important;
            box-shadow:0px 0px 5px 2px #666 !important;
        }
        </style>
        <script>
        $( '.theme-selector li a' ).each(function(){
            $(this).bind( 'click' , function(){
                // remove active status
                $( '.theme-selector li a' ).each( function(){
                    $(this).removeClass( 'active' );
                });
                
                $(this).toggleClass( 'active' );
                $('input[name="theme-skin"]').val( $(this).data( 'skin' ) );
                // console.log( $(this).data( 'skin' ) );
            });
        })
        </script>
		<?php
		$dom	=	ob_get_clean();
		riake( 'gui' , $config )->add_item( array(
			'type'		=>	'dom',
			'content'	=>	$dom
		) , riake( 'meta_namespace' , $config ) , riake( 'col_id' , $config ) );
		// Clean
		unset( $skin, $config , $dom );
	}
	
	/**
	 * Adds custom meta for user
	 *
	 * @access : public
	 * @params : Array
	 * @return : Array
	**/
	
	function custom_user_meta( $fields )
	{
		$fields[ 'first-name' ]		=	( $fname = $this->input->post( 'first-name' ) ) ? $fname : '';
		$fields[ 'last-name' ]		=	( $lname = $this->input->post( 'last-name' ) ) ? $lname : '';
		$fields[ 'theme-skin' ]		=	( $skin	=	$this->input->post( 'theme-skin' ) ) ? $skin : 'skin-blue';
		return $fields;
	}
	
	/**
	 * After options init
	 *
	 * @return void
	**/
	
	function after_session_starts()
	{
		// load user model
		$this->load->model( 'users_model' , 'users' );
		// If there is no master user , redirect to master user creation if current controller isn't tendoo-setup
		if( ! $this->users->master_exists() && $this->uri->segment(1) !== 'tendoo-setup' )
		{
			redirect( array( 'tendoo-setup' , 'site' ) );
		}
		
		// force user to be connected for certain controller
		if( in_array( $this->uri->segment(1) , $this->config->item( 'controllers_requiring_login' ) ) && $this->setup->is_installed() )
		{
			if( ! $this->users->is_connected() )
			{
				redirect( array( $this->config->item( 'default_login_route' ) ) );
			}
		}
		
		// Load created roles add push it to their respective type
		$admin_groups	=	$this->options->get( 'admin_groups' );
		$public_groups	=	$this->options->get( 'public_groups' );
		
		// For public groups
		$tendoo_public_groups	=	$this->config->item( 'public_group_label' );
		$merged_public_groups	=	array_merge( $tendoo_public_groups , $admin_groups );
		$this->config->set_item( 'public_group_label' , $merged_public_groups );
		
		// for admin groups
		$tendoo_admin_groups	=	$this->config->item( 'master_group_label' );
		$merged_admin_groups	=	array_merge( $tendoo_admin_groups , $admin_groups );
		$this->config->set_item( 'master_group_label' , $merged_admin_groups );
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
			array(
				'title'			=>		__( 'Roles permissions' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/roles/permissions')
			),
			array(
				'title'			=>		__( 'Manage Groups' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/roles/permissions')
			),
			array(
				'title'			=>		__( 'Create a new Group' ),
				'icon'			=>		'fa fa-shield',
				'href'			=>		site_url('dashboard/roles/permissions')
			)			
		);
		return $menus;
	}
	
	function users( $page = 'list' , $index = 1 )
	{		
		if( $page == 'list' )
		{
			// $this->users() it's the current method, $this->users is the main user object
			$users			=		$this->users->auth->list_users($group_par = FALSE, $limit = FALSE, $offset = FALSE, $include_banneds = FALSE);
			$this->gui->set_title( sprintf( __( 'Users &mdash; %s' ) , get( 'core_signature' ) ) );
			$this->load->view( 'dashboard/users/body' , array( 
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
			
			$this->load->view( 'dashboard/users/edit' , array( 
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
			
			$this->load->view( 'dashboard/users/create' , array( 
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
			
			$this->load->view( 'dashboard/users/profile' );
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
new auth_module_class;