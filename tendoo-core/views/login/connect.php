<div class="row m-n"> 
    <div class="col-md-4 col-md-offset-4 m-t-lg"> 
        <section class="panel"> 
            <header class="panel-heading text-center"> <?php echo $pageTitle;?> </header> 
            <form method="POST" class="panel-body"> 
                <div class="form-group"> 
                    <label class="control-label"><?php _e( 'Pseudo' );?></label> 
                    <input type="text" name="admin_pseudo" placeholder="<?php _e( 'Pseudo' );?>" class="form-control"> 
                </div> 
                <div class="form-group"> 
                    <label class="control-label"><?php _e( 'Password' );?></label> 
                    <input type="password" id="inputPassword" name="admin_password" placeholder="<?php _e( 'Password' );?>" class="form-control"> 
                </div> 
                <div class="checkbox"> 
                    <label> 
                        <input type="checkbox" name="stayLoggedIn"> <?php _e( 'Stay logged' );?>
                    </label> 
                </div>
                <button type="submit" class="form-control btn btn-info"><i class="fa fa-signin"></i><?php _e( 'log in' );?></button>
                <br>
                <?php
						if( get_meta( 'allow_registration' ) == '1')
						{
							?>
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('registration'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="fa fa-group text"></i> <span class="text"><?php _e( 'Create a new account' );?></span> <i class="fa fa-ok text-active"></i></a>
                        <div class="line line-dashed"></div>
                        <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('login','recovery'));?>'" class="btn btn-white btn-lg btn-block" id="btn-1"> <i class="fa fa-share text"></i> <span class="text"><?php _e( 'Recover a password' );?></span> <i class="fa fa-ok text-active"></i></a>
                        <?php
						}
						?>
                <br>
                <?php echo validation_errors();?>
                <?php echo fetch_notice_from_url();?>
                <?php echo output('notice');?>
                
            </form> 
        </section> 
    </div> 
</div>