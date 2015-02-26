<div class="login-box">
  <div class="login-logo">
  	<a href="<?php echo get_instance()->url->main_url();?>">
    <h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
    </a>
  </div><!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo $pageTitle;?></p>
    <form action="" method="post">
        <div class="body">
            <div class="form-group">
                <label class="control-label"><?php _e( 'Email' );?></label>
                <input name="email_valid" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <p><?php _e( 'Please, enter the account\'s email address for which you require a password recovery. Changing password will expire within 3 hours, after that a new recovery should be attempted again.' );?></p>
            </div>
            <div class="form-group">
                <input type="submit" value="<?php _e( 'Attemp to recover a password' );?>" class="btn btn-primary" />
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
			<br />
        <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('login'));?>'" class="btn btn-primary btn-lg btn-block" id="btn-1"> <i class="fa fa-signin text"></i> <span class="text"><?php _e( 'I already have an account' );?> </span> <i class="fa fa-ok text-active"></i></a>
			<?php
			}
			?>
        </div>
    </form>
  </div><!-- /.login-box-body -->
</div>
<script>
  $(function () {
	$('input').iCheck({
	  checkboxClass: 'icheckbox_square-blue',
	  radioClass: 'iradio_square-blue',
	  increaseArea: '20%' // optional
	});
  });
</script>
<div class="form-box" id="login-box">
	<a class="nav-brand" href="<?php echo get_instance()->url->main_url();?>">
    	<h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
	</a>
    <div class="header"><?php echo $pageTitle;?></div>
    <form action="" method="post">
        <div class="body">
            <div class="form-group">
                <label class="control-label"><?php _e( 'Email' );?></label>
                <input name="email_valid" type="text" class="form-control" />
            </div>
            <div class="form-group">
                <p><?php _e( 'Please, enter the account\'s email address for which you require a activation mail. If this email is valid, the activation mail will be sended.<br>The activation mails expire within 48 hours. After this, you should try again.' );?></p>
            </div>
            <div class="form-group">
                <input type="submit" value="<?php _e( 'Receive the activation mail' );?>" class="btn btn-primary" />
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
<div class="form-box" id="login-box">
	<a class="nav-brand" href="<?php echo get_instance()->url->main_url();?>">
    	<h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
	</a>
    <div class="header"><?php echo $pageTitle;?></div>
    
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