<div class="row">
	<?php
	$modules	=	Modules::get();
	foreach( $modules as $_module )
	{
		if( isset( $_module[ 'application' ][ 'details' ][ 'namespace' ] ) )
		{
			$module_namespace		=	$_module[ 'application' ][ 'details' ][ 'namespace' ];
	?>
	<div class="col-lg-4">
   	<div class="box" id="#module-">
      	<div class="box-header">
         	<h3 class="box-title"><?php echo isset( $_module[ 'application' ][ 'details' ][ 'name' ] ) ? $_module[ 'application' ][ 'details' ][ 'name' ] : __( 'Tendoo Extension' );?></h3>
            <div class="box-tools pull-right">
            <?php
				if( ! Modules::is_active( $module_namespace ) )
				{
				?>
              <button class="btn btn-default btn-box-tool" data-action="enable"><i style="font-size:20px;" class="fa fa-toggle-on"></i></button>
				<?php
				}
				else
				{
				?>
              <button class="btn btn-default btn-box-tool" data-action="disable"><i style="font-size:20px;" class="fa fa-toggle-off"></i></button>
				<?php
				}
				?>
              <button class="btn btn-default btn-box-tool" data-action="uninstall"><i style="font-size:20px;" class="fa fa-trash"></i></button>
              <button class="btn btn-default btn-box-tool" data-action="update"><i style="font-size:20px;" class="fa fa-refresh"></i></button>
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
	}
	?>
</div>