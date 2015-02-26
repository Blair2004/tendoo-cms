<div class="row m-n">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="text-center m-b-lg">
            <h1 class="h text-white animated bounceInDown" style="font-size:120px">
                <?php _e( 'Error' );?>
            </h1>
        </div>
        <?php echo output('notice');?>
        <div class="list-group m-b-sm bg-white m-b-lg">
            <a href="<?php echo $this->instance->url->main_url();?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-home"></i> Accueil </a>
            <?php
                            if($this->instance->users_global)
                            {
                                if($this->instance->users_global->isConnected())
                                {
                                    ?>
            <a href="<?php echo $this->instance->url->site_url(array('admin' , 'profile' ));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-user"></i>
            <?php _e( 'Profile' );?>
            </a>
            <?php
                                    if($this->instance->users_global->isAdmin())
                                    {
                                        ?>
            <a href="<?php echo $this->instance->url->site_url(array('admin'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-dashboard"></i>
            <?php _e( 'Dashboard' );?>
            </a>
            <?php					
                                    }
                                }
                                else
                                {
                                    ?>
            <a href="<?php echo $this->instance->url->site_url(array('login'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-sign-in"></i>
            <?php _e( 'Log in' );?>
            </a>
            <?php
                                    if( riake( 'allow_registration' , $options ) == '1')
                                    {
                                    ?>
            <a href="<?php echo $this->instance->url->site_url(array('registration'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-group"></i>
            <?php _e( 'Registration' );?>
            </a>
            <?php
                                    }
                                }
                            }
                            else if($this->instance->users_global === FALSE)
                            {
                                ?>
            <a href="<?php echo $this->instance->url->site_url(array('install'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-signin"></i>
            <?php _e( 'Install Tendoo' );?>
            </a>
            <?php
                            }
                            ?>
        </div>
    </div>
</div>
