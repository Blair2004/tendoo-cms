<body class="register-page">
    <div class="register-box" style="width:50%;">
      <div class="register-logo">
        <a href="<?php echo base_url();?>"><b><?php echo __( 'Tendoo CMS' );?></b> <?php echo get( 'core-version' );?></a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg"><?php _e( 'Define site settings' );?></p>
        <p><?php echo fetch_notice_from_url();?></p>
        <p><?php echo $this->notice->parse_notice();?></p>
        <p><?php echo validation_errors();?></p>
        <form method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="<?php _e( 'Site Name' );?>" name="site_name" value="<?php echo set_value( 'site_name' );?>">
          </div>
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="<?php _e( 'User Name' );?>" name="username" value="<?php echo set_value( 'username' );?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="<?php _e( 'Email' );?>" name="email" value="<?php echo set_value( 'email' );?>">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php _e( 'Password' );?>" name="password" value="<?php echo set_value( 'password' );?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?php _e( 'Password confirm' );?>" name="confirm" value="<?php echo set_value( 'confirm' );?>">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php _e( 'Continue to dashboard' );?></button>
            </div><!-- /.col -->
          </div>
        </form>        
      </div><!-- /.form-box -->
    </div><!-- /.register-box -->
  
</body>
</html>