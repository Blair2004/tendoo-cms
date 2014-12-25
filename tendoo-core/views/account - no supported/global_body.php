<body>
    <section class="vbox"> <!-- .aside -->
        <?php echo get_core_vars( 'inner_head' );?>
        <section>
            <section class="hbox stretch">
                <?php echo get_core_vars( 'lmenu' );?>
			</section>
            <section>
                <section class="vbox">
                </section>
            </section>
		</section>
        <!-- /.aside --> <!-- .hbox stretch -->
        <?php if( true == false ):?>
        <section class="hbox stretch">
        <!-- <section id="content">
            <section class="hbox stretch">
                <section class="scrollable">
                    <section class="thinwrapper stretch">
                        <section class="wrapper">
                            <section class="hbox stretch">
                                <?php echo $body;?>                            
                            </section>
                        </section>
                        <aside class="aside-lg bg-light lter b-l">
                            <section class="hbox stretch">
                                <section class="scrollable">
                                    <div class="wrapper">
                                        <div class="clearfix m-b"> <a href="#" class="pull-left thumb m-r"> <img src="<?php echo current_user('avatar_link');?>" class="img-circle"> </a>
                                            <div class="clear">
                                                <div class="h3 m-t-xs m-b-xs"><?php echo ucwords($this->instance->users_global->current('PSEUDO'));?></div>
                                                    <small class="text-muted"><i class="fa fa-map-marker"></i> <?php echo $this->instance->users_global->current('TOWN');?>, <?php echo $this->instance->users_global->current('STATE');?></small> 
                                                </div>
                                        </div>
                                        <div> <small class="text-uc text-xs text-muted"><?php _e( 'Name' );?></small>
                                            <p><?php echo $this->instance->users_global->current('NAME');?></p>
                                            <small class="text-uc text-xs text-muted"><?php _e( 'Surname' );?></small>
                                            <p><?php echo $this->instance->users_global->current('SURNAME');?></p>
                                            <div class="line"></div>
                                            <small class="text-uc text-xs text-muted"><?php _e( 'Social Networks' );?></small>
                                            <p class="m-t-sm"> <a href="#" class="btn btn-rounded btn-twitter btn-icon"><i class="fa fa-twitter"></i></a> <a href="#" class="btn btn-rounded btn-facebook btn-icon"><i class="fa fa-facebook"></i></a> <a href="#" class="btn btn-rounded btn-gplus btn-icon"><i class="fa fa-google-plus"></i></a> </p>
                                        </div>
                                    </div>
                                </section>
                            </section>
                        </aside>
                    </section>
                </section>
            </section>
            <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="body"></a> </section> -->
        </section>
        <?php endif;?>
        <!-- /.hbox stretch --> 
    </section>
<?php echo $this->file_2->js_load();?>
</body>