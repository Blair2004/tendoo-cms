<?php echo $inner_head;?>

<section id="content">
<section class="hbox stretch">
    <?php echo $lmenu;?>
    <section class="vbox">
        <section class="scrollable" id="pjax-container">
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
            <section class="scrollable">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="panel">
                                <div class="panel-heading">
                                    <?php _e( 'Create manually a sitemap' );?>
                                </div>
                                <div class="panel-body">
                                    <?php
									echo tendoo_warning( __( 'Please make sure you know what you\'re doing.' ) );
									?>
                                    <form fjax method="POST" action="<?php echo $this->instance->url->site_url(array('admin','ajax','sm_manual'));?>">
                                        <div class="form-group">
                                            <textarea name="sitemap" class="form-control" rows="10"><?php echo $getSitemap;?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn <?php echo theme_button_class();?>" value="<?php _e( 'Create / Update a sitemap' );?>">
                                        </div>
                                    </form>
                                    <hr class="line">
                                    <form fjax method="POST" action="<?php echo $this->instance->url->site_url(array('admin','ajax','sm_remove'));?>">
                                        <div class="form-group">
                                            <input type="submit" name="sm_remove" class="btn btn-danger" value="<?php _e( 'Delete the sitemap' );?>">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="panel">
                                <div class="panel-heading">
                                    <?php _e( 'Others options' );?>
                                </div>
                                <div class="panel-body">
                                    <form method="post">
                                        <div class="form-group">
                                            <input class="btn <?php echo theme_button_class();?>" type="submit" name="autoGenerate" value="<?php _e( 'Create a sitemap automatically' );?>">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
