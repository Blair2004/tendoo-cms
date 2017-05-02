<?php
! defined( 'APPPATH' ) ? die() : NULL;

class Tendoo_Reset extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->events->add_action( 'load_dashboard', array( $this, 'reset_table' ) );
	}
	
	/**
	 * Reset table
	 * @return void
	**/
	
	function reset_table()
	{
		unlink( APPPATH . '/config/database.php' );
		$this->load->dbforge();
		
		$this->dbforge->drop_database( $this->db->database );
		$this->dbforge->create_database( $this->db->database );
		
		redirect( array( 'do-setup' ) );
	}
}
new Tendoo_Reset;