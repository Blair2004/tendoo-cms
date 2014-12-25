<div class="row m-n">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="text-center m-b-lg">
            <h1 class="h text-white animated bounceInDown" style="font-size:120px"><?php _e( 'Error' );?></h1>
        </div>
        <?php 
		if( is_array( $error ) )
		{
			?>
            <div class="panel">	
            	<div class="panel-heading">
                	<?php echo riake( 1 , $error , __( 'Unknow Error Code' ) );?> <small>( <?php echo riake( 0 , $error , __( 'Unknow Error Code' ) );?> )</small>
                </div>
                <div class="panel-body">
                	<p><?php echo riake( 2 , $error , __( 'Unknow Error Code' ) );?></p>
                    <hr class="line-dashed" />
                    <h5><?php echo riake( 3 , $error , __( 'Unknow Error Code' ) );?> <small> ( <?php echo riake( 4 , $error , __( 'Unknow Error Code' ) );?> ) </small></h5>
                    
                </div>
            </div>
            <?php
		}
		else
		{
			?>
            <div class="panel">
            	<div class="panel-body">
					<?php echo $error;?>
            	</div>
            </div>
            <?php
		}
		?>
        <div class="list-group m-b-sm bg-white m-b-lg">
            <a href="<?php echo get_instance()->url->main_url();?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-home"></i> <?php _e( 'Home' );?> </a>
            <?php
            if( get_instance()->is_installed() )
            {
                if( current_user()->isConnected() )
                {
                    if(get_instance()->users_global->isConnected())
                    {
                        ?>
            <a href="<?php echo get_instance()->url->site_url(array('admin/profile'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-user"></i> <?php _e( 'Profile' );?> </a>
            <?php
                        if(get_instance()->users_global->isAdmin())
                        {
                            ?>
            <a href="<?php echo get_instance()->url->site_url(array('admin'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-dashboard"></i> <?php _e( 'Dashboard' );?> </a>
            <?php					
                        }
                    }
                    else
                    {
                        ?>
            <a href="<?php echo get_instance()->url->site_url(array('login'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-signin"></i> <?php _e( 'Login' );?> </a>
            <?php
                        if($options[0]['ALLOW_REGISTRATION'] == '1')
                        {
                        ?>
            <a href="<?php echo get_instance()->url->site_url(array('registration'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-group"></i> <?php _e( 'Registration' );?> </a>
            <?php
                        }
                    }
                }
                else if(get_instance()->users_global === FALSE)
                {
                    ?>
            <a href="<?php echo get_instance()->url->site_url(array('install'));?>" class="list-group-item"> <i class="fa fa-chevron-right"></i> <i class="fa fa-signin"></i> <?php _e( 'Install Tendoo' );?> </a>
            <?php
                }
            }
            ?>
        </div>
    </div>
</div>
