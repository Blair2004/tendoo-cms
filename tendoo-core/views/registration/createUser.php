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
      <div class="form-group has-feedback">
        <input type="text" name="user_pseudo" class="form-control" placeholder="<?php _e( 'Pseudo' );?> " />
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input class="form-control" type="password" name="user_password" placeholder="<?php _e( 'Password' );?> "/>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input class="form-control" type="password" name="user_password_confirm" placeholder="<?php _e( 'Confirm password' );?> "/>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input class="form-control" type="text" name="user_mail" placeholder="<?php _e( 'Email' );?> "/>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <?php
		if( riake( 'allow_privilege_selection' , $options ) == "1")
		{
		?>
		<div class="form-group">
			<select class="form-control" name="priv_id">
				<option value=""><?php _e( 'Select a role' );?> </option>
				<?php
				foreach($allowPrivilege as $a)
				{
					?>
					<option value="<?php echo $a['PRIV_ID'];?>"><?php echo $a['NAME'];?></option>
					<?php
				}
				?>
			</select>
		</div>
		<?php
		}
		?>	
      <div class="form-group">
            <select class="form-control" name="user_sex">
                <option value=""><?php _e( 'Sex' );?> </option>
                <option value="MASC"><?php _e( 'Male' );?> </option>
                <option value="FEM"><?php _e( 'Female' );?> </option>
            </select>
        </div>
      <div class="form-group text">
            <img src="<?php echo $captcha['DIRECTORY'];?>" class="form-control" style="height:100px;" />
            <input type="hidden" value="<?php echo $captcha['CODE'];?>" name="captchaCorrespondance" />
            <label class="control-label"><?php _e( 'Type this code in the following field' );?>  <?php echo $field_6;?></label>
            <input type="text" name="user_captcha" class="form-control" placeholder="Code captcha" />
        </div>	
      
      <div class="row">
        <div class="col-xs-8">    
                                  
        </div><!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat"><?php _e( 'Sing me in' );?></button>
        </div><!-- /.col -->

      </div>
              <br />
              <div class="form-group">
        <a type="button" onclick="window.location	=	'<?php echo $this->instance->url->site_url(array('login'));?>'" class="btn btn-primary btn-lg btn-block" id="btn-1"> <i class="fa fa-signin text"></i> <span class="text"><?php _e( 'I already have an account' );?> </span> <i class="fa fa-ok text-active"></i></a>
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