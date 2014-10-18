<body>
<section class="thinwrapper stretch"> <!-- .aside -->
    <?php echo $left_menu;?>
    <!-- /.aside --> <!-- .bigwrapper -->
    <section id="content">
        <section class="bigwrapper">
            <section class="scrollable">
            	<section class="thinwrapper stretch">
    				<aside class="bg-white">
                        <section class="bigwrapper">
                        	<?php echo $body;?>                            
                        </section>
                    </aside>
    				<aside class="aside-lg bg-light lter b-l">
                        <section class="bigwrapper">
                            <section class="scrollable">
                                <div class="wrapper">
                                    <div class="clearfix m-b"> <a href="#" class="pull-left thumb m-r"> <img src="" class="img-circle"> </a>
                                        <div class="clear">
                                            <div class="h3 m-t-xs m-b-xs"><?php echo ucwords($user[0]['PSEUDO']);?></div>
                                                <small class="text-muted"><i class="fa fa-map-marker"></i> <?php echo $this->instance->users_global->current('TOWN');?>, <?php echo $user[0]['STATE'];?></small> 
                                            </div>
                                    </div>
                                    <div> <small class="text-uc text-xs text-muted">Nom</small>
                                        <p><?php echo $user[0]['NAME'] == '' ? __( 'Unset' ) : $user[0]['NAME'];?></p>
                                        <small class="text-uc text-xs text-muted">Pr&eacute;nom</small>
                                        <p><?php echo $user[0]['SURNAME'] == '' ? __( 'Unset' ) : $user[0]['SURNAME'];?></p>
                                        <div class="line"></div>
                                        <small class="text-uc text-xs text-muted">connection</small>
                                        <p class="m-t-sm"> <a href="#" class="btn btn-rounded btn-twitter btn-icon"><i class="fa fa-twitter"></i></a> <a href="#" class="btn btn-rounded btn-facebook btn-icon"><i class="fa fa-facebook"></i></a> <a href="#" class="btn btn-rounded btn-gplus btn-icon"><i class="fa fa-google-plus"></i></a> </p>
                                    </div>
                                </div>
                            </section>
                        </section>
                    </aside>
				</section>
            </section>
        </section>
        <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="body"></a> </section>
    <!-- /.bigwrapper --> </section>
<?php echo $this->instance->file_2->js_load();?>
</body>