<body class="register-page">
    <div class="register-box">
      <div class="register-logo">
        <a href="<?php echo base_url();?>"><b><?php echo __( 'Tendoo CMS' );?></b> <?php echo get( 'core_version' );?></a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg"><?php _e( 'Sign up to' );?></p>
        <p><?php echo validation_errors();?></p>
        <p><?php echo $this->notice->output_notice();?></p>
        <form  method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="<?php _e( 'User Name' );?>" name="username">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="<?php _e( 'Email' );?>" name="email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php _e( 'Password' );?>" name="password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php _e( 'Confirm' );?>" name="confirm">
            <span class="glyphicon glyphicon-lock  form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
              <div class="checkbox icheck">
              </div>                        
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php _e( 'Sign Up' );?></button>
            </div><!-- /.col -->
          </div>
        </form> 
        <?php
		// May checks whether recovery is enabled
		?>
        <a href="<?php echo site_url( array( 'sign-in' , 'recovery' ) ) ;?>"><?php _e( 'I Lost My Password' );?></a><br>
        <?php
		// may checks whether login if login is enabled
		?>
        <a href="<?php echo site_url( array( 'sign-in' ) );?>" class="text-center"><?php _e( 'I Already Have An Account' );?></a><br>
        
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
  
</body>
</html>