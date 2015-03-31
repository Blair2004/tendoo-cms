<?php echo get_core_vars( 'inner_head' );?>
<section>
    <section class="hbox stretch">
        <?php echo get_core_vars( 'lmenu' );?>
        <section class="vbox">
        <section class="scrollable" id="pjax-container">
            <header>
                <div class="row b-b m-l-none m-r-none">
                    <div class="col-sm-4">
                        <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                        <p class="block text-muted"><?php echo get_page('description');?></p>
                    </div>
                    <div class="col-sm-8">
                        <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/a-propos-de-tendoo" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i>
                        </a>
                    </div>
                </div>
            </header>
            <div class="wrapper">
                <div class="panel">
                    <div class="panel-heading">
                    	<?php echo sprintf( __( 'About %s' )  , get( 'core_version' ) );?>
                    </div>
                    <div class="wrapper">
                        <p><?php _e( 'The very easy to use CMS.' );?></p>
                        <small><?php echo sprintf( __( 'Current Version : %s' ) , get( 'core_id' ) );?></small>
                        <hr class="line-dashed" />
                        <p><?php _e( 'Special thanks to all those tools ' );?>
                        	<ul>
	                        	<li><?php _e( 'TODO Administration Dashboard' );?></li>
    	                        <li><?php _e( 'jQuery' );?></li>
                                <li><?php _e( 'CKEditor' );?></li>
                                <li><?php _e( 'Bootstrap' );?></li>
								<li><a href="https://github.com/dbushell/Nestable">Nestable</a> Jquery plugin</li>
                                <li><?php _e( 'jQuery UI' );?></li>
                                <li><a href="http://github.com/heartcode/CanvasLoader"><?php _e( 'CanvasLoader' );?></a></li>
							</ul>
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <footer class="footer bg-white b-t">
            <div class="row m-t-sm text-center-xs">
                <div class="col-sm-2" id="ajaxLoading">
                </div>
            </div>
        </footer>
        </section>
    </section>
</section>