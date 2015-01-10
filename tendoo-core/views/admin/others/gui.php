<?php 
	$ui_config	=	get_core_vars( 'ui_config' );
	$enabled	=	return_if_array_key_exists( 'enabled' , $ui_config ) 
		? return_if_array_key_exists( 'enabled' , $ui_config ) : array();
?>
<!-- 
Library : GUI-V1
Version : 1.0
Description : Provide simple UI manager
Tendoo Version Required : 1.4
-->
<?php echo get_core_vars( 'inner_head' );?>
<section>
    <section class="hbox stretch"><?php echo get_core_vars( 'lmenu' );?>
    	<section class="vbox">
            <section class="scrollable" id="pjax-container">
                <header>
                    <div class="row b-b m-l-none m-r-none">
                        <div class="col-sm-4">
                            <?php if( $icon	=	return_if_array_key_exists( 'icon' , $ui_config ) )
                            {
                                ?>
                                <img class="pull-left" src="<?php echo get_instance()->url->main_url() . $icon;?>" style="height:50px;margin:6px 12px 0px 0px;">
                                <?php
                            }
                            ?>
                            <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                            <p class="block text-muted"><?php echo get_page('description');?></p>
                        </div>
                    </div>
                </header>
                <section class="vbox">
                    <section class="wrapper"> 
						<?php echo output('notice');?> 
						<?php echo validation_errors(); ?>
                        <div class="row">
                            <?php $total_width = 12;?>
                            <?php foreach( force_array( $this->cols ) as $key	=>	$c):?>
                            <?php if( ( $total_width - ( riake( 'width' , $c , 4 ) * 3 ) ) >= 0):?>
                            <?php $total_width -= ( riake( 'width' , $c , 4 ) * 3 );?>
                            <div class="col-lg-<?php echo riake( 'width' , $c , 4 ) * 3 ;?>">
                                <?php $config = return_if_array_key_exists( 'configs' , $this->cols[ $key ] );?>
                                <?php 
								// Inner Opening Wrapper
								echo riake( 'inner-opening-wrapper' , $config );
                                if( is_array( $config ) )
                                {
                                    foreach( $config as $key => $_v )
                                    {
                                        if( is_array( $_v ) )
                                        {
                                            foreach( $_v as $_k => $panel )
                                            {
												// To add specfic wrapper before meta
												echo riake( 'opening-wrapper' , $panel );
                                                $type	=	riake( 'type' , $panel , 'panel' );											
                                                if( $type == "panel" )
                                                {
                                        ?>
                                        <section class="panel pos-rlt clearfix" namespace="<?php echo $panel[ 'namespace' ];?>">
                                            <header class="panel-heading">
                                                <ul class="nav nav-pills pull-right">
                                                    <li> <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
                                                </ul>
                                                <?php echo riake( 'title' , $panel );?> 
											</header>
                                            <div class="panel-body <?php echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?> clearfix">
                                                <?php 
                                                
												$this->load->view('admin/others/gui_items' , array(
													'panel'		=>	$panel
												) );
												                                                
                                                ?>
                                            </div>
                                        </section>
                                        <?php
                                                }
                                                else if( $type == 'unwrapped' )
                                                {
													$this->load->view('admin/others/gui_items' , array(
														'panel'		=>	$panel
													) );
                                                }
												else if( $type == 'panel-ho' )
												{
                                        ?>
                                        <section class="panel pos-rlt clearfix" namespace="<?php echo $panel[ 'namespace' ];?>">
                                            <header class="panel-heading">
                                                <ul class="nav nav-pills pull-right">
                                                    <li> <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
                                                </ul>
                                                <?php echo riake( 'title' , $panel );?>
                                            </header>
											<?php
                                            $this->load->view('admin/others/gui_items' , array(
                                                'panel'		=>	$panel
                                            ) );
                                            ?>
										</section>
                                        <?php
                                                    
												}
												else if( $type == 'panel-footer' )
												{
													?>
                                        <section class="panel pos-rlt clearfix" namespace="<?php echo $panel[ 'namespace' ];?>">
                                            <header class="panel-heading">
                                                <ul class="nav nav-pills pull-right">
                                                    <li> <a href="#" class="panel-toggle text-muted"><i class="fa fa-caret-down text-active"></i><i class="fa fa-caret-up text"></i></a> </li>
                                                </ul>
                                                <?php echo riake( 'title' , $panel );?>
                                            </header>
                                            <div class="panel-body <?php echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?> clearfix">
											<?php
                                            $this->load->view('admin/others/gui_items' , array(
                                                'panel'		=>	$panel
                                            ) );
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
                                            </footer>
										</section>
                                        <?php	
												}
												// To add specfic wrapper after meta
												echo riake( 'closing-wrapper' , $panel );
                                            }
                                        }
                                    }
                                }
								// Inner Closing Wrapper
								echo riake( 'inner-closing-wrapper' , $config );
                                ?>
                            </div>
                            <?php endif;?>
                            <?php endforeach;?>
                            <script>
                            $(document).ready(function(e) {
                                $('section[namespace]').each(function(){
                                    var parent	=	$(this);
                                    $(this).find('ul.nav li a.panel-toggle').bind('click',function(){
                                        var status	=	$(parent).find('.panel-body').hasClass('collapse') ? "uncollapse" : "collapse";
                                        tendoo.set_user_meta( 'gui_'+ $(parent).attr('namespace') , status );
                                    });
                                });
                            });
                            </script>
                            <?php echo riake( 'footer-script' , $config );?>
                        </div>
                    </section>
                </section>
            </section>
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <?php if( in_array( 'loader' , $enabled ) ) : ;?>
                    <div class="col-sm-2 pull-left" id="ajaxLoading"> </div>
                    <?php else:?>
                    <div class="col-sm-2"></div>
                    <?php endif;?>
                    <div class="col-sm-4 text-center"> </div>
                    <div class="col-sm-2"></div>
                    <?php if( in_array( 'pagination' , $enabled ) && get_core_vars( 'pagination_data' ) ) : ;?>
                    <div class="col-sm-4 text-right text-center-xs">
                    	<?php bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination-sm m-t-none m-b-none");?>
                    </div>
                    <?php endif;?>
                </div>
            </footer>
        </section>
    </section>
</section>
<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
</section>
