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
		<?php $total_width = 12;?>
        <?php foreach( force_array( $this->gui->get_cols() ) as $key	=>	$c):?>
        <?php if( ( $total_width - ( riake( 'width' , $c , 4 ) * 3 ) ) >= 0):?>
        <?php $total_width -= ( riake( 'width' , $c , 4 ) * 3 );?>
        <div class="col-lg-<?php echo riake( 'width' , $c , 4 ) * 3 ;?>">
            <?php $config = riake( 'configs' , $this->gui->cols[ $key ] );?>
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
            <section class="box <?php // echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?>" namespace="<?php echo $panel[ 'namespace' ];?>">
                <header class="box-header">
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <h3 class="box-title"><?php echo riake( 'title' , $panel );?></h3>
                </header>
                <div class="box-body clearfix">
                    <?php 
                    set_core_vars( 'panel' , $panel );
                    $this->load->view( 'dashboard/gui/gui_items' );   
                    ?>
                </div>
                <?php
                // If pagination is defined
                if( get_core_vars( 'pagination_data' ) )
                {
                    ?>
                <div class="box-footer clearfix">
                  <?php // bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination pagination-sm no-margin pull-right");?>
                </div>
                    <?php
                }
                ?>
            </section>
            <?php
                                    }
                                    else if( $type == 'unwrapped' )
                                    {
                                        $this->load->view( 'dashboard/gui/gui_items' );
                                    }
                                    else if( $type == 'panel-ho' )
                                    {
                            ?>
            <section class="box <?php // echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?>" namespace="<?php echo $panel[ 'namespace' ];?>">
                <header class="box-header">
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <h3 class="box-title"><?php echo riake( 'title' , $panel );?></h3>
                </header>
                <?php
                                $this->load->view( 'dashboard/gui/gui_items' );
                                ?>
                <?php
                // If pagination is defined
                if( get_core_vars( 'pagination_data' ) )
                {
                    ?>
                <div class="box-footer clearfix">
                    <?php //  bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination pagination-sm no-margin pull-right");?>
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
            <section class="box <?php // echo get_user_meta( 'gui_'.$panel[ 'namespace' ] );?>" namespace="<?php echo $panel[ 'namespace' ];?>">
                <header class="box-header">
                    <div class="box-tools pull-right">
                        <button class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    </div>
                    <h3 class="box-title"><?php echo riake( 'title' , $panel );?></h3>
                </header>
                <div class="box-body clearfix">
                    <?php
                                $this->load->view( 'dashboard/gui/gui_items' );
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
                    <?php // bs_pagination( get_core_vars( 'pagination_data' ) , $additionnal_class = "pagination pagination-sm no-margin pull-right");?>
                </footer>
            </section>
            <?php	
                                    }
									else if( $type == 'panel-tabbed' ) // @since 1.5 on the way
									{	
										var_dump( $panel );									
										?>
										<div class="nav-tabs-custom">
											<ul class="nav nav-tabs">
											  <li class=""><a href="#tab_1" data-toggle="tab" aria-expanded="false">Tab 1</a></li>
											  <li class="active"><a href="#tab_2" data-toggle="tab" aria-expanded="true">Tab 2</a></li>
											  <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li>
											  <li class="dropdown">
												<a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
												  Dropdown <span class="caret"></span>
												</a>
												<ul class="dropdown-menu">
												  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
												  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
												  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
												  <li role="presentation" class="divider"></li>
												  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
												</ul>
											  </li>
											  <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
											</ul>
											<div class="tab-content">
											  <div class="tab-pane" id="tab_1">
												<b>How to use:</b>
												<p>Exactly like the original bootstrap tabs except you should use
												  the custom wrapper <code>.nav-tabs-custom</code> to achieve this style.</p>
												A wonderful serenity has taken possession of my entire soul,
												like these sweet mornings of spring which I enjoy with my whole heart.
												I am alone, and feel the charm of existence in this spot,
												which was created for the bliss of souls like mine. I am so happy,
												my dear friend, so absorbed in the exquisite sense of mere tranquil existence,
												that I neglect my talents. I should be incapable of drawing a single stroke
												at the present moment; and yet I feel that I never was a greater artist than now.
											  </div><!-- /.tab-pane -->
											  <div class="tab-pane active" id="tab_2">
												The European languages are members of the same family. Their separate existence is a myth.
												For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
												in their grammar, their pronunciation and their most common words. Everyone realizes why a
												new common language would be desirable: one could refuse to pay expensive translators. To
												achieve this, it would be necessary to have uniform grammar, pronunciation and more common
												words. If several languages coalesce, the grammar of the resulting language is more simple
												and regular than that of the individual languages.
											  </div><!-- /.tab-pane -->
											  <div class="tab-pane" id="tab_3">
												Lorem Ipsum is simply dummy text of the printing and typesetting industry.
												Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
												when an unknown printer took a galley of type and scrambled it to make a type specimen book.
												It has survived not only five centuries, but also the leap into electronic typesetting,
												remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
												sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
												like Aldus PageMaker including versions of Lorem Ipsum.
											  </div><!-- /.tab-pane -->
											</div><!-- /.tab-content -->
										  </div>
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