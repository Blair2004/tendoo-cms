<div class="row">
	<?php
	global $Options;
	$modules	=	Modules::get();
	foreach( $modules as $_module )
	{
		if( isset( $_module[ 'application' ][ 'details' ][ 'namespace' ] ) )
		{
			$module_namespace		=	$_module[ 'application' ][ 'details' ][ 'namespace' ];
	?>
	<div class="col-lg-3">
   	<div class="box" id="#module-">
      	<div class="box-header">
         	<h3 class="box-title"><?php echo isset( $_module[ 'application' ][ 'details' ][ 'name' ] ) ? $_module[ 'application' ][ 'details' ][ 'name' ] : __( 'Tendoo Extension' );?></h3>
            <div class="box-tools pull-right">
            <?php
				if( ! Modules::is_active( $module_namespace ) )
				{
				?>
              <a href="<?php echo site_url( array( 'dashboard' , 'modules' , 'enable' , $module_namespace ) );?>" class="btn btn-default btn-box-tool" data-action="enable"><i style="font-size:20px;" class="fa fa-toggle-on"></i> Enable</a>
				<?php
				}
				else
				{
				?>
              <a href="<?php echo site_url( array( 'dashboard' , 'modules' , 'disable' , $module_namespace ) );?>" class="btn btn-default btn-box-tool" data-action="disable"><i style="font-size:20px;" class="fa fa-toggle-off"></i> Disable</a>
				<?php
				}
				?>
              <a href="<?php echo site_url( array( 'dashboard' , 'modules' , 'remove' , $module_namespace ) );?>" class="btn btn-default btn-box-tool" data-action="uninstall"><i style="font-size:20px;" class="fa fa-trash"></i> <?php _e( 'Remove' );?></a>
              
              <?php if( intval( riake( 'webdev_mode' , $Options ) ) == true ):?>
              <a href="<?php echo site_url( array( 'dashboard' , 'modules' , 'extract' , $module_namespace ) );?>" class="btn btn-default btn-box-tool" data-action="extract"><i style="font-size:20px;" class="fa fa-file-zip-o"></i> <?php _e( 'Extract' );?></a>
              <?php endif;?>
              
              <button class="btn btn-default btn-box-tool" data-action="update"><i style="font-size:20px;" class="fa fa-refresh"></i></button>
            </div>
         </div>
         <div class="box-body" style="height:100px;"><?php echo isset( $_module[ 'application' ][ 'details' ][ 'description' ] ) ? $_module[ 'application' ][ 'details' ][ 'description' ] : '';?> </div>
         <div class="box-footer">
           	<?php echo 'v' . ( isset( $_module[ 'application' ][ 'details' ][ 'version' ] ) ? $_module[ 'application' ][ 'details' ][ 'version' ] : 0.1 );?>
         </div>
      </div>
   </div>
   <?php
		}
	}
	?>
</div>
<script>
$('[data-action="uninstall"]').bind('click', function(){
	if( confirm( '<?php _e( 'Do you really want to delete this module ?' );?>' ) ){
		return true;
	}
	return false;
});
</script>