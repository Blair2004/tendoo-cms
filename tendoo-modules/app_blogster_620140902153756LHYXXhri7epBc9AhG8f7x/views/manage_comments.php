<?php
$this->gui->cols_width( 1 , 3 );

$this->gui->set_meta( 'manage-comment' , __( 'Manage Comments' ) , 'panel' )->push_to( 1 );

$this->gui->set_item( array(
	'type'		=>		'dom',
	'value'		=>		module_view( 'views/manage-comment-form' , true , 'blogster' )
) )->push_to( 'manage-comment' );

$this->gui->get();
return;
?>
<?php echo $inner_head;?>
<section>
    <section class="hbox stretch">
        <?php echo $lmenu;?>
        <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                </div>
            </header>
            <section class="hbox stretch">
                <section class="wrapper"> 
					<?php echo output('notice');?> 
					
                    <?php echo fetch_notice_from_url();?>
                	<section class="panel">
                    	<div class="panel-heading">
                        <?php _e( 'Manage Comments' );?>
                        </div>
                        <div class="table-responsive">
                            
                        </div>
                    </section>
                </section>
            </section>
        </section>
        </section>
    </section>
    <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a> </section>