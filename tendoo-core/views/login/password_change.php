<div class="form-box" id="login-box">
	<a class="nav-brand" href="<?php echo get_instance()->url->main_url();?>">
    	<h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
	</a>
    <div class="header"><?php echo $pageTitle;?></div>
    <form action="" method="post">
        <div class="body bg-gray">
            <div class="form-group">
                <label class="control-label"><?php _e( 'New password' );?></label>
                <input type="password" name="password_new" class="form-control" />
            </div>
            <div class="form-group">
                <label class="control-label"><?php _e( 'Confirm your new password' );?></label>
                <input type="password" name="password_new_confirm" class="form-control" />
            </div>
            <div class="form-group">
                <p><?php _e( 'The new password should not match the old one.' );?></p>
            </div>
            <div class="form-group">
                <input type="submit" value="<?php _e( 'Save the new password' );?>" class="btn btn-primary" />
            </div>
            <?php echo output('notice');?>
        </div>
        <div class="footer">
            <?php
			if( get_meta( 'tendoo_registration_status' ) == '1')
			{
				?>
			<div class="line line-dashed"></div>
			<a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('registration'));?>'" class="btn btn-primary btn-lg btn-block" id="btn-1"> <i class="fa fa-group text"></i> <span class="text"><?php _e( 'Create a new account' );?></span> <i class="fa fa-ok text-active"></i></a>
			<div class="line line-dashed"></div>
			<a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('login','recovery'));?>'" class="btn btn-primary btn-lg btn-block" id="btn-1"> <i class="fa fa-share text"></i> <span class="text"><?php _e( 'Recover a password' );?></span> <i class="fa fa-ok text-active"></i></a>
			<?php
			}
			?>
        </div>
    </form>
	<?php if( true == false ):?>
    <div class="margin text-center">
        <span>Sign in using social networks</span>
        <br/>
        <button class="btn bg-light-blue btn-circle"><i class="fa fa-facebook"></i></button>
        <button class="btn bg-aqua btn-circle"><i class="fa fa-twitter"></i></button>
        <button class="btn bg-red btn-circle"><i class="fa fa-google-plus"></i></button>

    </div>
    <?php endif;?>
</div>