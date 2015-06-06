<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 	@details : Recovery 
 *	@role : This page page is used to displays forgotten password field
 * 	@since : 1.5
 *  
**/
?>
<body class="login-page">
    <div class="login-box" style="width:50%;">
      <div class="register-logo">
        <a href="<?php echo base_url();?>"><b><?php echo __( 'Tendoo CMS' );?></b> <?php echo get( 'core-version' );?></a>
      </div>
      <div class="login-box-body">
        <p class="login-box-msg"><?php echo $this->events->apply_filters( 'signin_notice_message' , $this->lang->line( 'signin_notice_message' ) );?></p>
        <p><?php echo ( validation_errors() ) != '' ? tendoo_error( strip_tags( validation_errors() ) ) : '';?></p>
        <p><?php $this->notice->output_notice();?></p>
        <p><?php echo ( $msg = $this->flexi_auth->get_messages() ) != '' ? tendoo_error( strip_tags( $msg ) ) : '';?></p>
        <?php echo tendoo_info( __( 'Please provide your user email in order to get recovery email' ) );?>
        <form method="post">
			<?php
            // May action for recovery fields
            ?>
            <div class="input-group">
              <span class="input-group-addon" id="basic-addon1"><?php _e( 'User email or Pseudo' );?></span>
              <input type="text" class="form-control" placeholder="<?php _e( 'User email or Pseudo' );?>" aria-describedby="basic-addon1" name="user_email">
              <span class="input-group-btn">
                <button class="btn btn-default" type="submit"><?php _e( 'Get recovery Email' );?></button>
              </span>
            </div>
            
        </form>
        <br>
		<?php
        // Should checks whether a login page is enabled
        ?>
        <a class="btn btn-primary" href="<?php echo site_url( array( 'login' ) );?>"><?php _e( 'Sign In' );?></a>
		<?php
        // Should checks whether a registration is enabled
        ?>
        <a class="btn btn-default" href="<?php echo site_url( array( 'sign-in' ) );?>" class="text-center"><?php _e( 'Sign Up' );?></a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
  
</body>
</html>