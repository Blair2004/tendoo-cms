<div class="row">
	<?php
	$modules	=	Modules::get();
	foreach( $modules as $_module )
	{
	?>
	<div class="col-lg-4">
   	<div class="box" id="#module-">
      	<div class="box-header">
         	<h3 class="box-title"><?php echo isset( $_module[ 'application' ][ 'details' ][ 'name' ] ) ? $_module[ 'application' ][ 'details' ][ 'name' ] : __( 'Tendoo Extension' );?></h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-action="enable"><i style="font-size:15px;" class="fa fa-toggle-on"></i> <?php _e( 'Enable' );?></button>
              <button class="btn btn-box-tool" data-action="disable"><i style="font-size:15px;" class="fa fa-toggle-off"></i> <?php _e( 'Disable');?></button>
              <button class="btn btn-box-tool" data-action="uninstall"><i style="font-size:15px;" class="fa fa-trash"></i> <?php _e( 'Uninstall' );?></button>
              <button class="btn btn-box-tool" data-action="update"><i style="font-size:15px;" class="fa fa-refresh"></i> <?php _e( 'Update');?></button>
            </div>
         </div>
         <div class="box-body"><?php echo isset( $_module[ 'application' ][ 'details' ][ 'description' ] ) ? $_module[ 'application' ][ 'details' ][ 'description' ] : '';?> </div>
         <div class="box-footer">
           	<?php echo 'v.' . ( isset( $_module[ 'application' ][ 'details' ][ 'version' ] ) ? $_module[ 'application' ][ 'details' ][ 'version' ] : 0.1 );?>
         </div>
      </div>
   </div>
   <?php
	}
	?>
</div>