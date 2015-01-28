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
                            <div class="col-sm-8">
                                <a href="http://tendoo.org/index.php/get-involved/le-panneau-de-configuration/accueil" class="btn btn-lg <?php echo theme_button_class();?>" style="float:right;margin:10px;"><i style="font-size:20px;" class="fa fa-question-circle"></i> </a>
                            </div>
                        </div>
                    </header>
                    <section>
                        <section class="scrollable wrapper">
                            <?php echo fetch_notice_from_url();?>
                            <div class="row">
                                <?php ouput_admin_widgets();?>
                            </div>
                        </section>
                    </section>
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
</section>
