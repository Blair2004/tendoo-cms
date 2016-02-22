<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	header file for each admin page. include <html> tag and ends at </head> closing tag
 *	Since		:	1.4
**/

$this->Gui->col_width( 1 , 4 );

$this->Gui->add_meta( array(
	'col_id'		=>	1,
	'title'		=>	__( 'Add new extension using ZIP file' ),
	'type'		=>	'unwrapped',
	'namespace'	=>	'installer_box',
) );

ob_start();
$migrate_file		=	MODULESPATH . $module[ 'application' ][ 'details' ][ 'namespace' ] . '/migrate.php';

if( is_file( $migrate_file ) ){
	$migrate_array	=	include_once( $migrate_file );
	// looping migrate functions
	// get latest saved migration version.
	$latestversion	=	$this->options->get( 'migration_' . $module[ 'application' ][ 'details' ][ 'namespace' ] );
	$available_migration	=	array();
	
	$start_migration	=	false;
	foreach( array_reverse( $migrate_array, true ) as $version => $closure_file_to_include ) {
		if( $version == $latestversion || $latestversion === NULL && $start_migration == false ) {
			$start_migration 	=	true;
		//Start migrate at the right moment.
		} else if( $start_migration == true ) {
			$available_migration[]	=	$version;
		}
	}
	?>
	<div id="migration-progress">
    	<p><?php _e( 'Migration has started' );?></p>
    </div>
    <script>
	var Migration_Url	=	'<?php echo site_url( array( 'dashboard', 'modules', 'migrate', $module[ 'application' ][ 'details' ][ 'namespace' ] ) );?>';
	var MigrationData	=	<?php echo json_encode( $available_migration );?>;
	var Migration		=	new function(){
		this.Do			=	function() {
			if( MigrationData.length > 0 ){
				$.ajax( Migration_Url + '/run/' + MigrationData[0], {
					dataType:"JSON",
					beforeSend: function(){
						$( '#migration-progress' ).append( '<p>' + '<?php _e( 'Migrating to' );?> : ' + MigrationData[0] + '</p>' );
					},
					success: function( result ) {
						console.log( result );
						if( result.code == 'success' ) {
							$( '#migration-progress p:last-child' ).append( ' &mdash; ' + '<?php _e( 'done.' );?>' );						
							MigrationData.shift();
							Migration.Do();
						} else {
							$( '#migration-progress' ).append( '<p>' + '<?php _e( 'An error occured :' );?> ' + result.msg + '</p>' );
						}
					},				
				});
			} else {
				$( '#migration-progress' ).append( '<p>' + '<?php _e( 'Migration done.' );?>' + '</p>' );
				$( '#migration-progress' ).append( '<p><a class="btn btn-default" href="' + '<?php echo site_url( array( 'dashboard', 'modules?highlight=' . $module[ 'application' ][ 'details' ][ 'namespace' ] ) );?>' + '">' + '<?php _e( 'Go back to modules' );?>' + '</a></p>' );
			}
		}
	};
	$(document).ready(function(e) {
		//if there is no migration
		if( MigrationData.length == 0 ) {
			$( '#migration-progress' ).append( '<p>' + '<?php _e( 'No migration content available' );?>' + '</p>' );
			document.location = '<?php echo site_url( array( 'dashboard', 'modules?highlight=' . $module[ 'application' ][ 'details' ][ 'namespace' ] . '&notice=migration-not-required' ) );?>';
		} else {
			Migration.Do();
		}
    });
	</script>
    <?php
}
else
{
	echo '<p>' . __( 'Migrate not available for this module.' ) . '</p>';
}
?>

<?php

$this->Gui->add_item( array(
	'type'		=>	'dom',
	'content'	=>	ob_get_clean(),
) , 'installer_box' , 1 );



$this->Gui->output();