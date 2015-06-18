<?php
/**
 *
 * Title 	:	 Internal Modules model
 * Details	:	 All usefull modules are loaded before session_start
 *
**/

class Internal_modules extends CI_Model
{
	function __construct()
	{
		parent::__construct();		
		
		$this->events->add_action( 'load_users_custom_fields' , array( $this , 'user_custom_fields' ) );
		$this->events->add_filter( 'custom_user_meta' , array( $this , 'custom_user_meta' ) , 10 , 1 );
		$this->events->add_filter( 'dashboard_skin_class' , array( $this , 'dashboard_skin_class' ) , 5 , 1 );
		
		// Change user name in the user menu
		$this->events->add_filter( 'user_menu_name' , array( $this , 'user_menu_name' ) );
		$this->events->add_filter( 'user_menu_card_header' , array( $this , 'user_menu_header' ) );
		
		// change send administrator emails
		$this->events->add_action( 'send_recovery_email' , array( $this , 'change_auth_settings' ) );
		// load custom config
		$this->events->add_action( 'before_session_starts' , array( $this , 'before_session_starts' ) );
	}
	
	/**
	 * 	Edit Tendoo.php config before session starts
	 *
	 *	@return	: void
	**/
	
	function before_session_starts()
	{
		$this->config->set_item( 'tendoo_logo_long' , '<b>Tend</b>oo' );
		$this->config->set_item( 'tendoo_logo_min' , '<img style="height:40px;" src="' . img_url() . 'logo_minim.png' . '" alt=logo>' );
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
}
