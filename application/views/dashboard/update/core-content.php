<?php
$result	= 	$this->update_model->get( $release );

if( $result === 'unknow-release' ){
	?>
   <h4><?php echo sprintf( __( 'Unknow Release : %s' ) , $release );?></h4>
   <p><?php _e( 'Update has been aborded...!!!' );?></p>
   <?php
} elseif( $result === 'old-release' ) {
	?>
   <h4><?php echo sprintf( __( 'Old Release : %s' ) , $release );?></h4>
   <p><?php _e( 'Update has been aborded...!!!' );?></p>
   <?php
} else {	
	?>
   <script>
	$(document).ready( function(){
	function stage( int ){
		if( int == 1 ){
			$.ajax( '<?php echo site_url( array( 'dashboard' , 'update' , 'download' , $result ) );?>',{
				beforeSend: function(){
					$('#update').append( '<div><?php echo _e( 'Downloading Zip file...' );?></div>' );
				},
				complete : function(){
					stage(2);
				}
			});
		} else if( int == 2 ){
			$.ajax( '<?php echo site_url( array( 'dashboard' , 'update' , 'extract' , $result ) );?>',{
				beforeSend: function(){
					$('#update').append( '<div><?php echo _e( 'Installing the new release...' );?></div>' );
				},
				complete: function(){
					document.location = '<?php echo site_url( array( 'dashboard' , 'about' ) );?>';
				}
			});
		}
	}
	stage(1);
	});
	</script>
   <p id="update"></p>
   <?php
}