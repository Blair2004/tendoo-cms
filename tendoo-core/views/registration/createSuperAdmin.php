<?php
$field_1	=	(form_error('user_pseudo')) ? form_error('user_pseudo' , '<span style="color:red">' , '</span>' , false ) : '';
$field_2	=	(form_error('user_password')) ? form_error('user_password' , '<span style="color:red">' , '</span>' , false ) : '';
$field_3	=	(form_error('user_password_confirm')) ? form_error('user_password_confirm' , '<span style="color:red">' , '</span>' , false ) : '';
;
$field_4	=	(form_error('user_mail')) ? form_error('user_mail' , '<span style="color:red">' , '</span>' , false ) : '';
$field_5	=	(form_error('user_sex')) ? form_error('user_sex' , '<span style="color:red">' , '</span>' , false ) : '';
$field_6	=	(form_error('user_captcha')) ? form_error('user_captcha' , '<span style="color:red">' , '</span>' , false ) : '';
$field_7	=	(form_error('priv_id')) ? form_error('priv_id' , '<span style="color:red">' , '</span>' , false ) : '';
;
?>
<div class="register-box">
  <div class="register-logo">
  	<a href="<?php echo get_instance()->url->main_url();?>">
    <h3 style="text-align:center;"><img style="max-height:80px;margin-top:-3px;display:inline-block;" src="<?php echo get_instance()->url->img_url("logo_4.png");?>"> </h3>
    </a>
  </div><!-- /.register-logo -->
  <div class="register-box-body">
    <p class="register-box-msg"><?php echo $pageTitle;?></p>
    <form action="" method="post">
        <div class="body">
            <div class="form-group text">
                <label class="control-label">
                    <?php _e( 'Pseudo' );?>
                </label>
                <input type="text" name="super_admin_pseudo" class="form-control" placeholder="<?php _e( 'Pseudo' );?>" />
                <span><?php echo form_error('super_admin_pseudo');?></span>
            </div>
            <div class="form-group password">
                <label class="control-label">
                    <?php _e( 'Password' );?>
                </label>
                <input class="form-control" type="password" name="super_admin_password" placeholder="<?php _e( 'Password' );?>"/>
                <span><?php echo form_error('super_admin_password');?></span>
            </div>
            <div class="form-group password">
                <label class="control-label">
                    <?php _e( 'Confirm Password' );?>
                </label>
                <input class="form-control" type="password" name="super_admin_password_confirm" placeholder="<?php _e( 'Confirm Password' );?>"/>
                <span><?php echo form_error('super_admin_password_confirm');?></span>
            </div>
            <div class="form-group text">
                <label class="control-label">
                    <?php _e( 'Email' );?>
                </label>
                <input class="form-control" type="text" name="super_admin_mail" placeholder="<?php _e( 'Email' );?>"/>
                <span><?php echo form_error('super_admin_mail');?></span>
            </div>
            <div class="form-group select">
                <label class="control-label">
                    <?php _e( 'Sex' );?>
                </label>
                <select class="form-control" name="super_admin_sex">
                    <option value="">
                    <?php _e( 'Select' );?>
                    </option>
                    <option value="MASC">
                    <?php _e( 'Male' );?>
                    </option>
                    <option value="FEM">
                    <?php _e( 'Female' );?>
                    </option>
                </select>
                <span><?php echo form_error('super_admin_sex');?></span>
            </div>
            <input class="btn btn-info" type="submit" value="<?php _e( 'Create User' );?>" />
            <input class="btn btn-darken" type="reset" value="<?php _e( 'Reset' );?>" />
        </div>
        <br />
        <div class="footer">
        	<?php echo tendoo_info( __( 'If you see this page, it means that there is not any Super Administrator for your website. <br> The super adminstrator doesn\'t have any restrictions. He can create others users, creates roles, bind privileges to a specific roles, install apps, etc. <br>Its absolutely required to create a super adminstrator before you continue.' ) );?>
            <!--<a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('login'));?>'" class="btn btn-primary btn-lg btn-block" id="btn-1"> <i class="fa fa-signin text"></i> <span class="text">
            <?php _e( 'I already have an account' );?>
            </span> <i class="fa fa-ok text-active"></i></a>-->
        </div>
    </form>
	<!--
    <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google-plus btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
    </div>
    -->
    <!-- /.social-auth-links -->
  </div><!-- /.register-box-body -->
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
</body>
</html>