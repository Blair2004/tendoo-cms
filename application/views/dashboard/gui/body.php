<?php
/**
 * 	File Name 	: 	body.php
 *	Description :	hold gui main body
 *	Since		:	1.4
**/
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
    
    echo  	$this->events->apply_filters( 'gui_page_title' , $page_header );
    
    // echo	notice( 'parse' );
    
/**
*	Details 	: Output content before cols
*	Usage 		: set 'after_cols' key with GUI::config()
**/

    echo 	$this->events->apply_filters( 'gui_before_cols' , '' );
    
    ?>
    <div class="content">
    <?php 
	if( function_exists( 'validation_errors' ) )
	{
		// validation errors
		echo ( validation_errors() ) != '' ? tendoo_error( strip_tags( validation_errors() ) ) : '';
	}
	$this->notice->push_notice( fetch_notice_from_url() );
	$this->events->do_action( 'displays_dashboard_errors' );
	// display notice
	echo $this->notice->output_notice();	
	
	$col_range	=	( count( $this->Gui->cols ) > 3 ) ? 3 : 4;
	?>
    
    
    <div class="row">
        <?php foreach( force_array( $this->Gui->get_cols() ) as $col_id =>	$col_data ):?>
        <div class="meta-row col-lg-<?php echo ceil( riake( 'width' , $col_data , 1 ) * $col_range ) ;?>">
            <?php 
			$config = riake( 'configs' , $col_data );
			// Inner Opening Wrapper
			echo $this->events->apply_filters( 'gui_opening_wrapper' , '' );    
			
			// looping $col_data[ 'metas' ];
			foreach( force_array( riake( 'metas' , $col_data ) ) as $meta )
			{
				$meta_class		=	riake( 'meta_class', $meta );
				$attrs			=	riake( 'attrs', $meta );
				/**
				 * Attrs String
				**/
				$attrs_string	=	'';
				
				foreach( force_array( $attrs ) as $key => $attr ) {
					$attrs_string	.=	$key . '="' . $attr . '" ';
				}
				// get meta type
				if( in_array( $meta_type = riake( 'type' , $meta ) , array( 'box-default' , 'box-primary' , 'box-success' , 'box-info' , 'box-warning' , 'box' ) ) )
				{
					// meta icon ?
					$icon				=	riake( 'icon' , $meta , false );
					// enable gui form saver
					$form_expire	=	gmt_to_local( time() , 'UTC' ) + GUI_EXPIRE;
					$ref				=	urlencode( current_url() );
					$use_namespace	=	riake( 'use_namespace' , $meta , false );
					$class			=	riake( 'classes' , riake( 'custom' , $meta ) );
					$id				=	riake( 'id' , riake( 'custom' , $meta ) );
					$action			=	riake( 'action' , riake( 'custom' , $meta ) , site_url( array( 'dashboard' , 'options' , 'save' ) ) );
					$method			=	riake( 'method' , riake( 'custom' , $meta ) , 'POST' );
					$enctype		=	riake( 'enctype' , riake( 'custom' , $meta ) , 'multipart/form-data' );
					$namespace		=	riake( 'namespace' , $meta );
					
					if( riake( 'gui_saver' , $meta ) )
					{
						?>
						<form class="form <?php echo $class;?>" id="<?php echo $id;?>" action="<?php echo $action;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
							<input type="hidden" name="gui_saver_ref" value="<?php echo $ref;?>" />
							<input type="hidden" name="gui_saver_option_namespace" value="<?php echo riake( 'namespace' , $meta );?>" />
							<input type="hidden" name="gui_saver_expiration_time" value="<?php echo $form_expire;?>" />
							<input type="hidden" name="gui_saver_use_namespace" value="<?php echo $use_namespace ? 'true' : 'false';?>" />
						<?php
					} elseif( in_array( $action, array( null, FALSE ), true ) ) {
						?>
                        <form class="form <?php echo $class;?>" id="<?php echo $id;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
                        <?php
					}
					
					
					// Meta status
					$meta_status	=	''; //$this->options->get( 'meta_status', User::id() );
					/**
					 * Background-Color will help you set a default background for the meta
					**/
					?>                    
                    <div class="box <?php echo $meta_type;?> <?php echo riake( $namespace, $meta_status );?> <?php echo riake( 'background-color', $meta );?> meta-<?php echo $namespace;?>" id="meta-<?php echo $namespace;?>" data-meta-namespace="<?php echo $namespace;?>" <?php echo $attrs_string;?>>
                   		<?php
						/**
						 *	Whether you want to display border, use "display-border" and set it to true
						**/
						?>
                        <div class="box-header <?php echo riake( 'display-border', $meta ) ? 'with-border' : '';?>">
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
                        </div>
                        <!-- /.box-header -->
                        <?php if( ! riake( 'hide_body_wrapper', $meta ) ):?>
                        <div class="box-body">
                        <?php endif;?>
                          	<?php echo $this->load->view( 'dashboard/gui/gui-items' , array(
								'namespace'	=>	$namespace,
								'meta' 	=>	$meta
							) , true );;?>
						<?php if( ! riake( 'hide_body_wrapper', $meta ) ):?>
                        </div>
                        <?php endif;?>
                        <!-- /.box-body -->
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
							// if pagination is enabled
							if( riake( 'pagination' , $footer ) )
							{
							?>
                            <ul class="pagination pagination-sm no-margin pull-right">
                                <li><a href="#">«</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">»</a></li>
                              </ul>
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
					if( riake( 'gui_saver' , $meta ) || $action === null )
					{
						?>
						</form>
						<?php
					}
				}
				else
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
										
					if( riake( 'gui_saver' , $meta ) )
					{
						?>
						<form class="form <?php echo $class;?>" id="<?php echo $id;?>" action="<?php echo $action;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
							<input type="hidden" name="gui_saver_ref" value="<?php echo $ref;?>" />
							<input type="hidden" name="gui_saver_option_namespace" value="<?php echo riake( 'namespace' , $meta );?>" />
							<input type="hidden" name="gui_saver_expiration_time" value="<?php echo $form_expire;?>" />
							<input type="hidden" name="gui_saver_use_namespace" value="<?php echo $use_namespace ? 'true' : 'false';?>" />
						<?php
					} elseif( in_array( $action, array( null, FALSE ), true ) ) {
						?>
                        <form class="form <?php echo $class;?>" id="<?php echo $id;?>" enctype="<?php echo $enctype;?>" method="<?php echo $method;?>">
                        <?php
					}
					
					echo $this->load->view( 'dashboard/gui/gui-items' , array(
						'meta' 			=>	$meta,
						'namespace'		=>	$namespace
					) , true );
					
					if( $footer	=	riake( 'footer' , $meta ) )
					{
						if( $footer_submit	= riake( 'submit' , $footer ) )
						{
						?>
						<button type="submit" class="btn btn-primary"><?php echo riake( 'label' , $footer_submit );?></button>
						<?php
						}
						// if pagination is enabled
						if( riake( 'pagination' , $footer ) )
						{
						?>
						<ul class="pagination pagination-sm no-margin pull-right">
							<li><a href="#">«</a></li>
							<li><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">»</a></li>
						  </ul>
						<?php
						}
					}
										
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
			echo $this->events->apply_filters( 'gui_inner_wrapper' , '' );    
			?>
        </div>
        <?php echo $this->events->apply_filters( 'gui_footer' , '' );    ?>
        <?php endforeach;?>
        <script>
        /** $(document).ready(function(e) {
            $('section[namespace]').each(function(){
                var parent	=	$(this);
                $(this).find('.box-header button').bind('click',function(){
                    var status	=	$(parent).hasClass('collapsed-box') ? "default" : "collapsed-box";
                    tendoo.set_user_meta( 'gui_'+ $(parent).attr('namespace') , status );
                });
            });
        }); **/
        </script>
        <?php if( in_array( 'dynamic-tables' , $this->events->apply_filters( 'gui_enabled' , array() ) ) ) : ;?>
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
    
    echo $this->events->apply_filters( 'gui_after_cols' , '' );    
    ?>
</div>