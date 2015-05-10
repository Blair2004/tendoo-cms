<div class="login-box">
  <div class="login-logo">
  	<a href="<?php echo get_instance()->url->main_url();?>">
    <h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
    </a>
  </div><!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo $pageTitle;?></p>
    <form action="" method="post">
      <div class="form-group has-feedback">
        <input type="text" name="admin_pseudo" placeholder="<?php _e( 'Pseudo' );?>" class="form-control"/>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="admin_password" placeholder="<?php _e( 'Password' );?>" class="form-control"/>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">    
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="stayLoggedIn"> <?php _e( 'Stay logged' );?>
            </label>
          </div>                        
        </div><!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><?php _e( 'log in' );?></button>
        </div><!-- /.col -->
      </div>
      <?php echo output('notice');?>
    </form>
	<!--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
    </div>
    -->
    <!-- /.social-auth-links -->
	<?php
	if( get_meta( 'tendoo_registration_status' ) == '1')
	{
	?>
    <br />
    <div class="line line-dashed"></div>
    <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('registration'));?>'" class="btn btn-primary btn-lg btn-block" id="btn-1"> <i class="fa fa-group text"></i> <span class="text"><?php _e( 'Create a new account' );?></span> <i class="fa fa-ok text-active"></i></a>
    <br />
    <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('login','recovery'));?>'" class="btn btn-primary btn-lg btn-block" id="btn-1"> <i class="fa fa-share text"></i> <span class="text"><?php _e( 'Recover a password' );?></span> <i class="fa fa-ok text-active"></i></a>
	<?php
	}
	?>
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