<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	hold gui main body
 *	Since		:	1.4
**/
$ui_config		=	get_core_vars( 'ui_config' );
$enabled		=	riake( 'enabled' , $ui_config , array() , true );
$output			=	riake( 'output' , $ui_config , array() , true );
$content_css	=	riake( 'skip-header' , $output ) === true ? 'padding:0px' : '';
?>
<!-- 
Library : GUI-V2
Version : 1.1
Description : Provide simple UI manager
Tendoo Version Required : 1.5
-->
<div class="content-wrapper" style="min-height: 916px;">
<!-- Content Header (Page header) -->
	<?php 
    
    echo  	get_core_vars( 'page-header' );
    
    // echo	notice( 'parse' );
    
/**
*	Details 	: Output content before cols
*	Usage 		: set 'after_cols' key with GUI::config()
**/
    
    echo 	riake( 'before_cols' , $output , '' );
    
    ?>
    <div class="content">
    <div class="row">
        <?php foreach( force_array( $this->gui->get_cols() ) as $col_id =>	$col_data ):?>
        <div class="col-lg-<?php echo riake( 'width' , $col_data , 1 ) * 3 ;?>">
            <?php 
			$config = riake( 'configs' , $col_data );
			// Inner Opening Wrapper
			echo riake( 'inner-opening-wrapper' , $config , '' );
			
			// looping $col_data[ 'metas' ];
			foreach( force_array( riake( 'metas' , $col_data ) ) as $meta )
			{
				// get meta type
				if( in_array( $meta_type = riake( 'type' , $meta ) , array( 'box-default' , 'box-primary' , 'box-success' , 'box-info' , 'box-warning' , 'box' ) ) )
				{
					// meta icon ?
					$icon			=	riake( 'icon' , $meta , false );
					// enable gui form saver
					$form_expire	=	gmt_to_local( time() , 'UTC' ) + GUI_EXPIRE;
					$ref			=	urlencode( current_url() );
					$use_namespace	=	riake( 'use_namespace' , $meta , false );
					$class			=	riake( 'classes' , riake( 'custom' , $meta ) );
					$id				=	riake( 'id' , riake( 'custom' , $meta ) );
					$action			=	riake( 'action' , riake( 'custom' , $meta ) , site_url( array( 'dashboard' , 'options' , 'save' ) ) );
					$method			=	riake( 'method' , riake( 'custom' , $meta ) , 'POST' );
					$enctype		=	riake( 'enctype' , riake( 'custom' , $meta ) , 'multipart/form-data' );
					$namespace		=	riake( 'namespace' , $meta );
					if( $use_namespace )
					{
						set_core_vars( $namespace , $this->options->get( $namespace ) );
					}
					
					if( riake( 'gui_saver' , $meta ) )
					{
						?>
						<form class="form <?php echo $class;?>" id="<?php echo $id;?>" action="<?php echo $action;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
							<input type="hidden" name="gui_saver_ref" value="<?php echo $ref;?>" />
							<input type="hidden" name="gui_saver_option_namespace" value="<?php echo riake( 'namespace' , $meta );?>" />
							<input type="hidden" name="gui_saver_expiration_time" value="<?php echo $form_expire;?>" />
							<input type="hidden" name="gui_saver_use_namespace" value="<?php echo $use_namespace ? 'true' : 'false';?>" />
						<?php
					}
					?>
                    
                    <div class="box <?php echo $meta_type;?>">
                        <div class="box-header with-border">
                          <?php if( $icon ):?>
                          <i class="fa <?php echo $icon;?>"></i>
                          <?php endif;?>
                          <?php
						  // get title;
						  ?>
                          <h3 class="box-title"><?php echo riake( 'title' , $meta );?></h3>
                          <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                          </div>
                        </div><!-- /.box-header -->
                        <div class="box-body">
                          	<?php echo $this->load->view( 'dashboard/gui/gui-items' , array(
								'meta' 	=>	$meta
							) , true );;?>
                        </div><!-- /.box-body -->
                        <?php 
						if( $footer	=	riake( 'footer' , $meta ) )
						{
							?>
                        <div class="box-footer">
                        	<?php 
							if( $footer_submit	= riake( 'submit' , $footer ) )
							{
							?>
                            <button type="submit" class="btn btn-primary"><?php echo riake( 'label' , $footer_submit );?></button>
                            <?php
							}
							?>
                        </div>
                            <?php
						}
						?>
                      </div>

                    <?php
					// enable gui form saver
					if( riake( 'gui_saver' , $meta ) )
					{
						?>
						</form>
						<?php
					}
				}
				else if( $meta_type == 'dom' )
				{
					// meta icon ?
					$icon			=	riake( 'icon' , $meta , false );
					// enable gui form saver
					$form_expire	=	gmt_to_local( time() , 'UTC' ) + GUI_EXPIRE;
					$ref			=	urlencode( current_url() );
					$use_namespace	=	riake( 'use_namespace' , $meta , false );
					$class			=	riake( 'classes' , riake( 'custom' , $meta ) );
					$id				=	riake( 'id' , riake( 'custom' , $meta ) );
					$action			=	riake( 'action' , riake( 'custom' , $meta ) , site_url( array( 'dashboard' , 'options' , 'save' ) ) );
					$method			=	riake( 'method' , riake( 'custom' , $meta ) , 'POST' );
					$enctype		=	riake( 'enctype' , riake( 'custom' , $meta ) , 'multipart/form-data' );
					$namespace		=	riake( 'namespace' , $meta );
					if( $use_namespace )
					{
						set_core_vars( $namespace , $this->options->get( $namespace ) );
					}
					
					if( riake( 'gui_saver' , $meta ) )
					{
						?>
						<form class="form <?php echo $class;?>" id="<?php echo $id;?>" action="<?php echo $action;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
							<input type="hidden" name="gui_saver_ref" value="<?php echo $ref;?>" />
							<input type="hidden" name="gui_saver_option_namespace" value="<?php echo riake( 'namespace' , $meta );?>" />
							<input type="hidden" name="gui_saver_expiration_time" value="<?php echo $form_expire;?>" />
							<input type="hidden" name="gui_saver_use_namespace" value="<?php echo $use_namespace ? 'true' : 'false';?>" />
						<?php
					}
					
					echo $this->load->view( 'dashboard/gui/gui-items' , array(
						'meta' 	=>	$meta
					) , true );
										
					// enable gui form saver
					if( riake( 'gui_saver' , $meta ) )
					{
						?>
						</form>
						<?php
					}
				}
			}
			// Inner Closing Wrapper
			echo riake( 'inner-closing-wrapper' , $config , '' );
			?>
        </div>
        <?php echo riake( 'footer-script' , $config , '' );?>
        <?php endforeach;?>
        <script>
        $(document).ready(function(e) {
            $('section[namespace]').each(function(){
                var parent	=	$(this);
                $(this).find('.box-header button').bind('click',function(){
                    var status	=	$(parent).hasClass('collapsed-box') ? "default" : "collapsed-box";
                    tendoo.set_user_meta( 'gui_'+ $(parent).attr('namespace') , status );
                });
            });
        });
        </script>
        <?php if( in_array( 'dynamic-tables' , $enabled ) ) : ;?>
            <?php get_instance()->load->view( 'admin/gui/gui_dynamic_table_css' );?>
            <?php get_instance()->load->view( 'admin/gui/gui_dynamic_table_js' );?>
        <?php endif;?>
    </div>
    </div>
    <?php
    
/**
*	Details : Output content after cols
*	Usage : set 'after_cols' key with GUI::config()
**/
    
    echo riake( 'after_cols' , $output , '' );    
    ?>
</div>