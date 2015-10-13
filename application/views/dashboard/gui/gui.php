<?php 
	$ui_config	=	get_core_vars( 'ui_config' );
	$enabled	=	riake( 'enabled' , $ui_config , array() , true );
	$output		=	riake( 'output' , $ui_config , array() , true );
	$content_css=	riake( 'skip-header' , $output ) === true ? 'padding:0px' : '';
?>
<!-- 
Library : GUI-V2
Version : 1.1
Description : Provide simple UI manager
Tendoo Version Required : 1.5
-->
<!-- Site wrapper -->
<div class="wrapper">
	
	<?php echo get_core_vars( 'inner_head' );?>
    <!-- Left side column. contains the logo and sidebar -->
    <?php output( 'content-left-menu' );?>
    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="right-side" id="inner-content"> 
        <!-- Content Header (Page header) -->
        <?php if( riake( 'skip-header' , $output ) !== true ):?>
			<?php output( 'content-header' );?>
        <?php endif;?>
        <!-- Main content -->
        <section class="content" style="padding-bottom:50px;<?php echo $content_css;?>">
                <?php echo output('notice');?>
                <?php
				/**
				 *	Details 	: Output content before cols
				 *	Usage 		: set 'after_cols' key with GUI::config()
				**/
                ?>
                <?php echo riake( 'before_cols' , $output , '' );?>
                <div class="row">
                    <?php $total_width = 12;?>
                    <?php foreach( force_array( $this->cols ) as $key	=>	$c):?>
                    <?php if( ( $total_width - ( riake( 'width' , $c , 4 ) * 3 ) ) >= 0):?>
                    <?php $total_width -= ( riake( 'width' , $c , 4 ) * 3 );?>
                    <div class="col-lg-<?php echo riake( 'width' , $c , 4 ) * 3 ;?>">
                        <?php $config = return_if_array_key_exists( 'configs' , $this->cols[ $key ] );?>
                        <?php 
								// Inner Opening Wrapper
								echo riake( 'inner-opening-wrapper' , $config , '' );
                                if( is_array( $config ) )
                                {
                                    foreach( $config as $key => $_v )
                                    {
                                        if( is_array( $_v ) )
                                        {
                                            foreach( $_v as $_k => $panel )
                                            {
												// To add specfic wrapper before meta
												echo riake( 'opening-wrapper' , $panel , '' );
                                                $type	=	riake( 'type' , $panel , 'panel' );	
												set_core_vars( 'panel' , $panel );
                                                if( $type == "panel" )
                                                {
                                        ?>
                        <section class="box <?php echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?>" namespace="<?php echo $panel[ 'namespace' ];?>">
                            <header class="box-header">
                            	<div class="box-tools pull-right">
                                    <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <h3 class="box-title"><?php echo riake( 'title' , $panel );?></h3>
							</header>
                            <div class="box-body clearfix">
                                <?php 
								set_core_vars( 'panel' , $panel );
								$this->load->view( 'dashboard/others/gui_items' );   
								?>
                            </div>
                            <?php
							// If pagination is defined
							if( get_core_vars( 'pagination_data' ) )
							{
								?>
							<div class="box-footer clearfix">
                              <?php bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination pagination-sm no-margin pull-right");?>
                            </div>
                                <?php
							}
							?>
                        </section>
                        <?php
                                                }
                                                else if( $type == 'unwrapped' )
                                                {
													$this->load->view( 'dashboard/others/gui_items' );
                                                }
												else if( $type == 'panel-ho' )
												{
                                        ?>
                        <section class="box <?php echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?>" namespace="<?php echo $panel[ 'namespace' ];?>">
                            <header class="box-header">
                            	<div class="box-tools pull-right">
                                    <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <h3 class="box-title"><?php echo riake( 'title' , $panel );?></h3>
							</header>
                            <?php
                                            $this->load->view( 'dashboard/others/gui_items' );
                                            ?>
							<?php
							// If pagination is defined
							if( get_core_vars( 'pagination_data' ) )
							{
								?>
							<div class="box-footer clearfix">
                            	<?php bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination pagination-sm no-margin pull-right");?>
                            </div>
                                <?php
							}
							?>
                        </section>
                        <?php
                                                    
												}
												else if( $type == 'panel-footer' )
												{
													?>
                        <section class="box <?php echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?>" namespace="<?php echo $panel[ 'namespace' ];?>">
                            <header class="box-header">
                            	<div class="box-tools pull-right">
                                    <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                                <h3 class="box-title"><?php echo riake( 'title' , $panel );?></h3>
							</header>
                            <div class="box-body clearfix">
                                <?php
                                            $this->load->view( 'dashboard/others/gui_items' );
                                            ?>
                            </div>
                            <footer class="panel-footer">
                                <?php
												foreach( force_array( riake( 'footer-buttons' , $panel ) ) as $_button )
												{
													$class	=	riake( 'class' , $_button , 'btn btn-white btn-sm' );
													$attrs	=	riake( 'attrs' , $_button, '' );
													$value	=	riake( 'value' , $_button , __( 'Sample Button' ) );
													$text	=	riake( 'text' , $_button , __( 'Sample Button' ) );
													$name	=	riake( 'name' , $_button );
													$type	=	riake( 'type' , $_button , 'button' );
													$placeholder = riake( 'placeholder' , $_button );
													?>
                                <button value="<?php echo $value;?>" name="<?php echo $name;?>" type="<?php echo $type;?>" <?php echo $attrs;?> class="<?php echo $class;?>"><?php echo $text;?></button>
                                <?php
												}
												?>
								<?php bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination pagination-sm no-margin pull-right");?>
                            </footer>
                        </section>
                        <?php	
												}
												
												// To add specfic wrapper after meta
												echo riake( 'closing-wrapper' , $panel , '' );
                                            }
                                        }
                                    }
                                }
								// Inner Closing Wrapper
								echo riake( 'inner-closing-wrapper' , $config , '' );
                                ?>
                    </div>
                    <?php endif;?>
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
						<?php get_instance()->load->view( 'admin/others/gui_dynamic_table_css' );?>
                        <?php get_instance()->load->view( 'admin/others/gui_dynamic_table_js' );?>
                    <?php endif;?>
                </div>
                <?php
				/**
				 *	Details : Output content after cols
				 *	Usage : set 'after_cols' key with GUI::config()
				**/
                ?>
                <?php echo riake( 'after_cols' , $output , '' );?>
        </section>
        <section class="content-footer" style="">
        	<div class="row m-t-sm text-center-xs">
				<?php if( in_array( 'loader' , $enabled ) ) : ;?>
                <div class="col-sm-2 pull-left" id="ajaxLoading">
                </div>
                <?php else:?>
                <div class="col-sm-2">
                </div>
                <?php endif;?>
                <div class="col-sm-4 text-center">
                </div>
                <?php if( in_array( 'pagination' , $enabled ) && get_core_vars( 'pagination_data' ) ) : ;?>
                <div class="col-sm-4 text-right text-center-xs">
                    <?php bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination-sm m-t-none m-b-none");?>
                </div>
                <?php endif;?>
            </div>
        </section>
    </aside>
</div>
