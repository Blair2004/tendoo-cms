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
            <p><?php _e( 'those wizards, allow you to recover an account when :');?> </p>
                        <ul>
                        	<li><?php _e( 'His not yet activated' );?></li>
                            <li><?php _e( 'His password has been forgotten' );?></li>
                        </ul>
                        <p><?php _e( 'Use "receive activation mail" when an account is not active and when you haven\'t receive an activation email. Use "password forgotten" when you don\'t remember your password.' );?></p>
                        <br />
                        <div class="line line-dashed"></div>
                        <div class="row">
                        	<div class="col-xs-6">
                        <a href="<?php echo $this->instance->url->site_url(array('login','recovery','password_lost'));?>" class="btn btn-primary"><?php _e( 'Password forgotten' );?></a>
                        </div>
                        <div class="col-xs-6">
                        <a href="<?php echo $this->instance->url->site_url(array('login','recovery','receiveValidation'));?>" class="btn btn-info"><?php _e( 'Mail Activation' );?></a>
                        </div>
                        </div>
                        <br />
            <?php echo output('notice');?>
        </div>
        <div class="footer">
            <?php
			if( get_meta( 'tendoo_registration_status' ) == '1')
			{
				?>
			<div class="line line-dashed"></div>
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