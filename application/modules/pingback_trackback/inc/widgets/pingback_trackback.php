<?php 
		$query	=	$this->db->get( 'trackbacks' );
		$result_array	=	$query->result_array();
		$active_installs	=	0;
		if( count( $result_array ) > 0 ) {
			foreach( $result_array as $result ) {
				$active_installs++;
			}
		}
?>
<h2><?php echo sprintf( __( '%s actives installations' ), $active_installs );?></h2>