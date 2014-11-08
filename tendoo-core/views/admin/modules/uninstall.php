<?php echo get_core_vars( 'inner_head' );?>

<section>
    <section class="hbox stretch">
        <?php echo get_core_vars( 'lmenu' );?>
        <section>
            <section class="vbox">
                <section class="scrollable">
                    <header>
                        <div class="row b-b m-l-none m-r-none">
                            <div class="col-sm-4">
                                <h4 class="m-t m-b-none"><?php echo get_page('title');?></h4>
                                <p class="block text-muted">
                                    <?php echo get_page('description');?>
                                </p>
                            </div>
                        </div>
                    </header>
                    <section class="wrapper">
						<?php echo output('notice');?>
                        <div class="row">
                            <div class="col-lg-5">
                                <section class="panel">
                                    <div class="panel-heading">
                                        <?php _e( 'Be safe' );?>
                                    </div>
                                    <div class="panel-body">
                                        <?php output('notice');?>
                                        <p>
                                            <?php echo sprintf ( __( "You're about to delete %s. This action couldn't be cancelled later. furthermore some plugins may not work anymore." ) , $module['namespace'] );?>
                                        </p>
                                        <form method="post">
                                            <div>
                                                <input type="hidden" name="module_namespace" value="<?php echo $module['namespace'];?>">
                                                <input type="submit" class="btn btn-sm btn-danger" value="<?php _e( 'Confirm and Delete' );?>">
                                            </div>
                                        </form>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </section>
            </section>
            <footer class="footer bg-white b-t">
                <div class="row m-t-sm text-center-xs">
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 text-center">
                    </div>
                    
                </div>
            </footer>
        </section>
    </section>
</section>
