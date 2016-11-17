<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 	@details : Recovery
 *		@role : This page page is used to displays forgotten password field
 * 	@since : 1.5
 *
**/
?>
<body class="login-page">
    <div class="login-box" style="width:50%;">
        <div class="register-logo">
            <?php
            $logo   =   '<a href="' . base_url() . '"><b>' . __('Tendoo CMS') . '</b> ' . get('str_core') . '</a>';
            echo $this->events->apply_filters( 'signin_logo', $logo );
            ?>
        </div>
      <div class="login-box-body">
      	<p class="login-box-msg"><?php echo $this->events->apply_filters('recovery_notice_message', $this->lang->line('recovery-notice-message'));?></p>
        <p><?php echo(validation_errors()) != '' ? tendoo_error(strip_tags(validation_errors())) : '';?></p>
        <p><?php $this->notice->output_notice();?></p>

        <form method="post">
        	<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			<?php echo $this->events->apply_filters('recovery_fields', '');    ?>
        </form>
        <br>
		<?php
        // Should checks whether a login page is enabled
        ?>
        <a class="btn btn-primary" href="<?php echo site_url(array( 'sign-in' ));?>"><?php _e('Sign In');?></a>
		<?php
        // Should checks whether a registration is enabled
        ?>
        <a class="btn btn-default" href="<?php echo site_url(array( 'sign-up' ));?>" class="text-center"><?php _e('Sign Up');?></a>

      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

</body>
</html>
