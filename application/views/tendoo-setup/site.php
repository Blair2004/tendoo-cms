<body class="register-page">
    <div class="register-box" style="width:50%;">
      <div class="register-logo">
        <a href="<?php echo base_url();?>"><b><?php echo __( 'Tendoo CMS' );?></b> <?php echo get( 'str_core' );?></a>
      </div>

      <div class="register-box-body">
        <p class="login-box-msg"><?php _e( 'Define site settings' );?></p>
        <p><?php echo fetch_notice_from_url();?></p>
        <p><?php echo $this->notice->output_notice();?></p>
        <p><?php echo validation_errors();?></p>
        <form method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="<?php _e( 'Site Name' );?>" name="site_name" value="<?php echo set_value( 'site_name' );?>">
          </div>
          <?php echo $this->events->apply_filters( 'installation_fields' , '' );?>
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