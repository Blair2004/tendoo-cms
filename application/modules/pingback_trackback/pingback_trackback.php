<?php
class PingBack_TrackBack extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'tendoo_settings_tables', array( $this, 'setup' ) );
		$this->events->add_action( 'register_general_settings_fields', array( $this, 'settings_fields' ) );
		$this->events->add_action( 'load_dashboard', array( $this, 'init' ) );
		$this->events->add_action( 'load_frontend', array( $this, 'frontend' ) );
		$this->events->add_action( 'do_enable_module', array( $this, 'enable' ) );
		$this->events->add_action( 'do_remove_module', array( $this, 'uninstall' ) );
		$this->events->add_action( 'load_dashboard_home', array( $this, 'widgets' ) );
	}
	
	function setup()
	{
		Modules::enable( 'pingback_trackback' );
		$this->enable( 'pingback_trackback' );
	}
	
	function widgets()
	{
		$this->dashboard_widgets->add( 'pingback_trackback', array(
			'title'	=> __( 'Pingback Report' ),
			'type'	=> 'box-primary',
			// 'background-color'	=>	'',
			'position'	=> 1,
			'content'	=>	$this->load->view( '../modules/pingback_trackback/inc/widgets/pingback_trackback.php', null, true )
		) );
	}
	
	function enable( $namespace )
	{
		if( intval( $this->options->get( 'pingback_trackback_is_installed' ) ) == false && $namespace == 'pingback_trackback' ) {
			$this->db->query( 'CREATE TABLE '.$this->db->dbprefix.'trackbacks (
			 tb_id int(10) unsigned NOT NULL auto_increment,
			 entry_id int(10) unsigned NOT NULL default 0,
			 url varchar(200) NOT NULL,
			 title varchar(100) NOT NULL,
			 excerpt text NOT NULL,
			 blog_name varchar(100) NOT NULL,
			 tb_date int(10) NOT NULL,
			 ip_address varchar(16) NOT NULL,
			 PRIMARY KEY `tb_id` (`tb_id`),
			 KEY `entry_id` (`entry_id`)
			);' );
			 $this->options->set( 'pingback_trackback_is_installed', true, true );
			 $this->options->set( 'store_pingback', true );
		}		
	}
	
	function uninstall( $namespace )
	{
		if( $namespace == 'pingback_trackback' ) {
			$this->db->query( 'DROP TABLE IF EXISTS `'.$this->db->dbprefix.'trackbacks`;' );
			$this->options->delete( 'pingback_trackback_is_installed' );
			$this->options->delete( 'store_pingback' );			
		}
	}
	
	function frontend( $segments )
	{
		if( riake( 1, $segments ) == 'pingback' ){
			$this->load->library( 'trackback' );
			if ( ! $this->trackback->receive() )
			{
				$this->trackback->send_error("The Trackback did not contain valid data");
			}
			
			$data = array(
			'entry_id'   =>	$segments[1],
			'url'        => $this->trackback->data('url'),
			'title'      => $this->trackback->data('title'),
			'excerpt'    => $this->trackback->data('excerpt'),
			'blog_name'  => $this->trackback->data('blog_name'),
			'tb_date'    => time(),
			'ip_address' => $this->input->ip_address()
			);
			
			$sql = $this->db->insert_string('trackbacks', $data);
			$this->db->query($sql);
			
			$this->trackback->send_success();
		}
	}
	
	function init()
	{
		$this->load->library( 'trackback' );
		$site_name		=	$this->options->get( 'site_name' );
		// var_dump( current_url() );die;
		// If pinback to store is enabled
		if( intval( $this->options->get( 'store_pingback' ) ) == true && intval( $this->options->get( 'has_pinged' ) ) == false ) {
			$data		=	array(
				'ping_url'		=>	'http://ci3.tendoo.org/index.php/pingback',
				'url'			=>	current_url(),
				'title'			=>	'First installation pingback',
				'excerpt'		=>	'This trackback is send for first install Tendoo CMS',
				'blog_name'		=>	$site_name == null ? 'Tendoo CMS Unamed Website' : $site_name,
				'charset'   	=> 'utf-8',
				'release'		=>	$this->config->item( 'version' )
			);
			
			if ( ! $this->trackback->send( $data ) )
			{
				 $this->events->add_filter( 'ui_notices', function( $notices ){
					 $notices[]	=	array(
						'msg'		=>	$this->trackback->display_errors(),
						'title'		=>	'Pingback report',
						'href'		=>	site_url( array( 'dashboard', 'settings' ) ),
						'type'		=>	'warning'
					 );
					 return $notices;
				 });
			}
			else
			{
				 $this->events->add_filter( 'ui_notices', function( $notices ){
					 $notices[]	=	array(
						'msg'		=>	'Pingback has been send',
						'title'		=>	'Pingback report',
						'href'		=>	site_url( array( 'dashboard', 'settings' ) )
					 );
					 return $notices;
				 });
			}
			$this->options->set( 'has_pinged', true, true );
		}
	}
	
	/** 
	 * Registering Settings fields
	**/
	
	function settings_fields()
	{
		$this->Gui->add_meta( array(
			'type'		=>	'box-primary',
			'title'		=>	__( 'PingBack and Trackback Settings' ),
			'namespace'	=>	'pinback_trackback',
			'col_id'	=>	1, // required,
			'gui_saver'	=>	true, // use tendoo option saver
			'footer'	=>	array(
				'submit'	=>	array(
					'label'	=>	__( 'Save Settings' )
				)
			),
			'use_namespace'	=>	false
		) );
		
		$this->Gui->add_item( array(
			'type'		=>	'select',
			'name'		=>	'store_pingback',
			'label'		=>	__( 'Enable Store Pingback ?' ),
			'placeholder'=>	__( 'Enable Store Pingback' ),
			'options'	=>	array(
				0	=>	__( 'No' ),
				1	=>	__( 'Yes' )
			)
		) , 'pinback_trackback' , 1 );
		
	}
}
new PingBack_TrackBack;